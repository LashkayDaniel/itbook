<?php

namespace App\Http\Controllers;

use App\Http\Api\ApiHelper;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    use ApiHelper;

    public function download1(): string
    {
        return "download page";
    }

    public function createSection(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($this->isAdmin($user)) {
            $validator = Validator::make($request->all(), $this->sectionValidationRules());
            if ($validator->passes()) {
                $section = new Section();
                $section->name = $request->input('name');
                $section->save();
                return $this->onSuccess($section, 'Section Created');
            }
            return $this->onError(400, $validator->errors());
        }
        return $this->onError(401, 'Unauthorized Access');
    }
}
