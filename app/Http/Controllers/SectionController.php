<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sections = Section::orderBy('sort_id', 'asc')->get();
        $themes = [];
        $result = [];
        foreach ($sections as $section) {
            foreach ($section->themes as $theme) {
                $themes[] = $theme->title;
            }
            $result[] = ['section' => $section->name, 'themes' => $themes];
            $themes = [];
        }
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'section_name' => 'required|min:5|unique:sections,name',
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

            $section = new Section();
            $section->name = $request->input('section_name');

            $insertAfter = Section::where('name', $request->input('insert_after'))->first();

            if ($insertAfter) {
                $insertAfterId = $insertAfter->sort_id;
                $othersRows = Section::where('sort_id', '>', $insertAfterId)->get();

                foreach ($othersRows as $othersRow) {
                    $newId = $othersRow->sort_id + 1;
                    $othersRow->sort_id = $newId;
                    $othersRow->save();
                }
                $section->sort_id = $insertAfterId + 1;
            } else {
                $lastRow = Section::latest('sort_id')->first();
                $section->sort_id = $lastRow->sort_id + 1;
            }
            $section->save();

            return response()->json([
                'status' => true,
                'new_section' => $section,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function showAll()
    {
        return Section::orderBy('sort_id', 'asc')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $section = Section::find($id);

            if (!$section) {
                return response()->json([
                    'status' => false,
                    'message' => 'Section not found',
                ], 404);
            }

            $othersRows = Section::where('sort_id', '>', $section->sort_id)->get();
            if ($othersRows->count() > 0) {
                foreach ($othersRows as $othersRow) {
                    $newId = $othersRow->sort_id - 1;
                    $othersRow->sort_id = $newId;
                    $othersRow->save();
                }
            }

            $section->delete();

            return response()->json([
                'status' => true,
                'deleted_section' => $section,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
