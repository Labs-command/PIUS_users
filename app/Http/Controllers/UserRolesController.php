<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserRolesService;
class UserRolesController
{
    protected UserRolesService $userRolesService;

    public function __construct(UserRolesService $userRolesService)
    {
        $this->userRolesService = $userRolesService;
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $result = $this->userRolesService->add($data['user_id'], $data['roles']);

        if (isset($result['code'])) {
            return response()->json($result, $result['code']);
        }

        return response()->json($result);
    }

    public function remove(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $result = $this->userRolesService->remove($data['user_id'], $data['roles']);

        if (isset($result['code'])) {
            return response()->json($result, $result['code']);
        }

        return response()->json($result);
    }

    public function set(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $result = $this->userRolesService->set($data['user_id'], $data['roles']);

        if (isset($result['code'])) {
            return response()->json($result, $result['code']);
        }

        return response()->json($result);
    }
    public function list(Request $request): JsonResponse
    {
        $result = $this->userRolesService->list($request->input('user_id'));

        return response()->json($result);
    }
}
