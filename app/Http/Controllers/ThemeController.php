<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\PhpWord;

class ThemeController extends Controller
{

    public function showAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Theme::all();
    }

    public function get(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'section_name' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $sectionId = Section::where('name', $request->input('section_name'))->first()->id;

            if (!$sectionId) {
                return response()->json([
                    'error' => 'Section id not found',
                ]);
            }

            $themes = Theme::where('section_id', $sectionId)
                ->orderBy('sort_id', 'asc')
                ->get();

            return response()->json([
                'status' => true,
                'themes' => $themes,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function getContent(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'theme_name' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $content = Theme::with('section')->where('title', $request->input('theme_name'))->first();

            return response()->json([
                'status' => true,
                'content' => $content,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'title' => 'required|min:5',
                    'section_name' => 'required|min:5|unique:themes,title',
                    'insert_after' => 'min:5',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $sectionId = Section::where('name', $request->input('section_name'))->first()->id;

            $theme = new Theme();
            $theme->title = $request->input('title');
            $theme->section_id = $sectionId;
            $theme->description = '[]';

            $insertAfter = Theme::where('title', $request->input('insert_after'))->first();

            if ($insertAfter) {
                $insertAfterId = $insertAfter->sort_id;
                $othersRows = Theme::where('section_id', $sectionId)
                    ->where('sort_id', '>', $insertAfterId)
                    ->get();

                foreach ($othersRows as $othersRow) {
                    $newId = $othersRow->sort_id + 1;
                    $othersRow->sort_id = $newId;
                    $othersRow->save();
                }
                $theme->sort_id = $insertAfterId + 1;
            } else {
                $check = Theme::where('section_id', $sectionId)->exists();
                if ($check) {
                    $lastRow = Theme::where('section_id', $sectionId)
                        ->latest('sort_id')
                        ->first();
                    $theme->sort_id = $lastRow->sort_id + 1;
                } else {
                    $theme->sort_id = 1;
                }
            }
            $theme->save();

            return response()->json([
                'status' => true,
                'new_theme' => $theme,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function createDescription(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'theme_name' => 'required|min:5',
                    'description' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $themeId = Theme::where('title', $request->theme_name)->first()->id;
            $theme = Theme::find($themeId);
            $theme->description = $request->description;
            $theme->save();

            return response()->json([
                'status' => true,
                'theme' => $theme,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function uploadImage(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalName();
            $image->storeAs('uploads/images', $imageName, 'public');

            return response()->json([
                'status' => true,
                'image_name' => $imageName,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function removeImage(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'image_name' => 'required|min:5',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $imageName = 'uploads/images/' . $request->input('image_name');
            if (!Storage::disk('public')->exists($imageName)) {
                return response()->json([
                    'status' => false,
                    'image' => 'image not found',
                ], 200);
            }

            Storage::disk('public')->delete($imageName);

            return response()->json([
                'status' => true,
                'image' => 'image remove successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'new_name' => 'required|min:5|unique:themes,title',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $theme = Theme::find($id);
            $theme->title = $request->new_name;

            $theme->save();

            return response()->json([
                'status' => true,
                'new_theme' => $theme,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $theme = Theme::find($id);

            if (!$theme) {
                return response()->json([
                    'status' => false,
                    'message' => 'Theme not found',
                ], 404);
            }

            $othersRows = Theme::where('section_id', $theme->section_id)
                ->where('sort_id', '>', $theme->sort_id)->get();
            if ($othersRows->count() > 0) {
                foreach ($othersRows as $othersRow) {
                    $newId = $othersRow->sort_id - 1;
                    $othersRow->sort_id = $newId;
                    $othersRow->save();
                }
            }

            $theme->delete();

            return response()->json([
                'status' => true,
                'deleted_theme' => $theme,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchText');

        $elements = Theme::with('section')->get();//->pluck('description');

        $results = [];

        foreach ($elements as $element) {
            $matches = [];
            preg_match_all(
                "/<[^>]*>/",
                $element->description,
                $matches,
                PREG_SET_ORDER
            ); // Вилучити HTML теги з елементу
            $text = strip_tags($element->description); // Вилучити HTML теги з елементу

            if (mb_stripos(
                    $text,
                    $searchTerm,
                    0,
                    'UTF-8'
                ) !== false) { // Здійснити регістронезалежний пошук з підтримкою кирилиці
                $results[] = $element;
            }
        }

        return response()->json($results);
    }


}
