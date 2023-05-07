<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

            $themes = Theme::where('section_id', $sectionId)->get();

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
                    'section_name' => 'required|min:5',
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
            $theme->description = '';
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

}
