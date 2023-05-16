<?php

namespace App\Http\Controllers;

use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function getViews()
    {
        return View::all();
    }

    public function create(Request $request)
    {
        try {
            $view = new View();
            $view->ip_address = $request->ip();
            $view->user_agent = $request->userAgent();

            $view->save();

            return response()->json([
                'status' => true,
                'view' => $view,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $view = View::where('ip_address', $request->ip())
                ->where('user_agent', $request->userAgent())
                ->delete();

            return response()->json([
                'status' => true,
                'deleted_view' => $view,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}
