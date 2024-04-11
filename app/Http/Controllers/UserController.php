<?php

namespace App\Http\Controllers;

use App\Services\UsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Users service API",
 *     version="1.0.0",
 *     description="Description of Users service API"
 * )
 */
/**
 * @OA\Schema(
 *     schema="User",
 * @OA\Property(
 *         property="user_id",
 *         type="string",
 *         example="123e4567-e89b-12d3-a456-426614174000"
 *     ),
 * @OA\Property(
 *         property="state",
 *         type="string",
 *         example="active"
 *     )
 * )
 */
class UserController
{
    protected UsersService $userService;

    public function __construct(UsersService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user",
     *     summary="List all users",
     *     tags={"User"},
     * @OA\Parameter(
     *         name="search_field",
     *         in="query",
     *         description="Field to search by",
     * @OA\Schema(type="string",     enum={"user_id", "state"})
     *     ),
     * @OA\Parameter(
     *         name="search_value",
     *         in="query",
     *         description="Value to search for",
     * @OA\Schema(type="string")
     *     ),
     * @OA\Parameter(
     *         name="sort_field",
     *         in="query",
     *         description="Field to sort by",
     * @OA\Schema(type="string",     enum={"user_id", "state"})
     *     ),
     * @OA\Parameter(
     *         name="sort_order",
     *         in="query",
     *         description="Sort order (asc or desc)",
     * @OA\Schema(type="string",     enum={"asc", "desc"})
     *     ),
     * @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset for pagination",
     * @OA\Schema(type="integer")
     *     ),
     * @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit for pagination",
     * @OA\Schema(type="integer")
     *     ),
     * @OA\Parameter(
     *         name="role",
     *         in="query",
     *         description="Role to filter by",
     * @OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="List of users",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     ),
     * @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function list(Request $request): JsonResponse
    {
        $users = $this->userService->list($request);

        return response()->json($users);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/user",
     *     summary="Create a new user",
     *     tags={"User"},
     * @OA\RequestBody(
     *         required=true,
     * @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * @OA\Response(
     *         response="201",
     *         description="User created successfully",
     * @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $result = $this->userService->create($data);

        return response()->json($result['message'], $result['code'] ?? 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/user",
     *     summary="Update a user",
     *     tags={"User"},
     * @OA\RequestBody(
     *         required=true,
     * @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="User updated successfully",
     * @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * @OA\Response(
     *         response="404",
     *         description="User not found"
     *     ),
     * @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $result = $this->userService->update($data);

        if (isset($result['code'])) {
            return response()->json($result['message'], $result['code']);
        }

        return response()->json($result['message']);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/user",
     *     summary="Delete a user",
     *     tags={"User"},
     * @OA\RequestBody(
     *         required=true,
     * @OA\JsonContent(
     *             required={"user_id"},
     * @OA\Property(property="user_id", type="string", example="123e4567-e89b-12d3-a456-426614174000")
     *         )
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="User deleted successfully"
     *     ),
     * @OA\Response(
     *         response="404",
     *         description="User not found"
     *     ),
     * @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function delete(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $result = $this->userService->delete($data);

        if (isset($result['code'])) {
            return response()->json($result['message'], $result['code']);
        }

        return response()->json($result['message']);
    }
}
