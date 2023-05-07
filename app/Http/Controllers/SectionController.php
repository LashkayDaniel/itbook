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
        $sections = \App\Models\Section::all();
        $themes = [];
        $result = [];
        foreach ($sections as $section) {
            $sectionName = $section['name'];
            foreach ($section->themes as $theme) {
                $themes[] = $theme['title'];
            }
            $result[] = ['section' => $sectionName, 'themes' => $themes];
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
                    'section_name' => 'required',
                    'insert_after' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $insertAfterRow = Section::where('name', $request->input('insert_after'))->first()->id;
//            $newSection = Section::insert([
//                'name' => $request->input('section_name'),
//            ])->after($insertAfterRow);

//            DB::statement('INSERT INTO table (column1, column2) VALUES (?, ?)', [$value1, $value2]);

            return response()->json([
                'status' => true,
//                'new_section' => $newSection,
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
        return Section::all();
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
