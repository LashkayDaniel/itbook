<?php

namespace App\Http\Controllers;

use App\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DictionaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $dictionaryItems = Dictionary::orderBy('title')->get();

            return response()->json([
                'status' => true,
                'items' => $dictionaryItems,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'title' => 'required|min:5|unique:dictionaries,title',
                    'description' => 'required|min:10',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 422);
            }

            $dictionary = new Dictionary();
            $dictionary->title = $request->input('title');
            $dictionary->description = $request->input('description');

            $dictionary->save();

            return response()->json([
                'status' => true,
                'new_dictionary' => $dictionary,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Dictionary $dictionary
     * @return \Illuminate\Http\Response
     */
    public function show(Dictionary $dictionary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Dictionary $dictionary
     * @return \Illuminate\Http\Response
     */
    public function edit(Dictionary $dictionary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dictionary $dictionary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dictionary $dictionary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Dictionary $dictionary
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Dictionary $dictionary)
    {
        try {
            $dictionary->deleteOrFail();

            return response()->json([
                'status' => true,
                'deleted_dictionary' => $dictionary,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
