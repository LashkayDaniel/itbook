<?php

namespace App\Http\Api;

use Illuminate\Http\JsonResponse;

trait ApiHelper
{
    protected function isAdmin($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('Admin');
        }
        return false;
    }

    protected function isUser($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('Student');
        }
        return false;
    }

    protected function onSuccess($data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function onError(int $code, string $message = ''): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }

    protected function sectionValidationRules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    protected function themeValidationRules(): array
    {
        return [
            'title' => 'required|string',
            'section_id' => 'required|int',
            'description' => 'required|string',
        ];
    }

    protected function userValidatedRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
