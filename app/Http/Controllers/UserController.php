<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use Illuminate\Http\Request;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UsersService $userService)
    {
        $this->userService = $userService;
    }

    public function list(Request $request)
    {
        $users = $this->userService->list($request);

        return response()->json($users);
    }

    public function create(Request $request)
    {
        $data = $request->json()->all();

        $result = $this->userService->create($data);

        return response()->json($result['message'], $result['code'] ?? 200);
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();

        $result = $this->userService->update($data);

        if (isset($result['code'])) {
            return response()->json($result['message'], $result['code']);
        }

        return response()->json($result['message']);
    }

    public function delete(Request $request)
    {
        $data = $request->json()->all();

        $result = $this->userService->delete($data);

        if (isset($result['code'])) {
            return response()->json($result['message'], $result['code']);
        }

        return response()->json($result['message']);
    }
}
