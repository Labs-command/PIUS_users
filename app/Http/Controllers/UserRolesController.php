<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserRolesResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserRolesService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserRole",
 * @OA\Property(
 *         property="user_id",
 *         type="string",
 *         example="123e4567-e89b-12d3-a456-426614174000"
 *     ),
 * @OA\Property(
 *         property="role",
 *         type="string",
 *         example="admin"
 *     )
 * )
 */
class UserRolesController
{
    protected UserRolesService $userRolesService;

    public function __construct(UserRolesService $userRolesService)
    {
        $this->userRolesService = $userRolesService;
    }


    /**
     * @OA\Post(
     *     path="/api/v1/roles",
     *     summary="Add roles to a user",
     *     tags={"User Roles"},
     * @OA\RequestBody(
     *         required=true,
     * @OA\JsonContent(
     *             required={"user_id", "roles"},
     * @OA\Property(property="user_id", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
     * @OA\Property(property="roles",   type="array", @OA\Items(type="string", enum={"user", "admin"}))
     *         )
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="Roles added successfully",
     * @OA\JsonContent(type="array",    @OA\Items(ref="#/components/schemas/UserRole"))
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
    public function add(Request $request): JsonResponse
    {
        try {
            $data = $request->json()->all();
            $result = $this->userRolesService->add($data['user_id'], $data['roles']);

            return response()->json(['data' => $result]);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['errors' => $e->getMessage()], $statusCode);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/v1/roles",
     *     summary="Remove roles from a user",
     *     tags={"User Roles"},
     * @OA\RequestBody(
     *         required=true,
     * @OA\JsonContent(
     *             required={"user_id", "roles"},
     * @OA\Property(property="user_id", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
     * @OA\Property(property="roles",   type="array", @OA\Items(type="string", enum={"user", "admin"}))
     *         )
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="Roles removed successfully"
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
    public function remove(Request $request): JsonResponse
    {
        try {
            $data = $request->json()->all();
            $result = $this->userRolesService->remove($data['user_id'], $data['roles']);

            return response()->json(['data' => $result]);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['errors' => $e->getMessage()], $statusCode);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/roles",
     *     summary="Set roles for a user (replace existing roles)",
     *     tags={"User Roles"},
     * @OA\RequestBody(
     *         required=true,
     * @OA\JsonContent(
     *             required={"user_id", "roles"},
     * @OA\Property(property="user_id", type="string", example="123e4567-e89b-12d3-a456-426614174000"),
     * @OA\Property(property="roles",   type="array", @OA\Items(type="string", enum={"user", "admin"}))
     *         )
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="Roles set successfully"
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
    public function set(Request $request): JsonResponse
    {
        try {
            $data = $request->json()->all();
            $result = $this->userRolesService->set($data['user_id'], $data['roles']);

            return response()->json(['data' => $result]);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['errors' => $e->getMessage()], $statusCode);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/roles",
     *     summary="List roles for a user",
     *     tags={"User Roles"},
     * @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID of the user",
     * @OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *         response="200",
     *         description="List of roles for the user",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserRole"))
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
    public function list(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            $result = $this->userRolesService->list($request->input('user_id'));

            return UserRolesResource::collection($result);
        } catch (Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            return response()->json(['errors' => $e->getMessage()], $statusCode);
        }
    }
}
