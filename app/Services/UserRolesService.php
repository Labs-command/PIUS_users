<?php

namespace App\Services;

use App\Models\Users;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserRolesService
{
    public function add($userId, $roles): array
    {
        try {
            $user = Users::find($userId);

            if (!$user) {
                throw new Exception("User not found", 404);
            }

            foreach ($roles as $role) {
                if (!in_array($role, ['user', 'admin'])) {
                    throw new Exception("Invalid role: $role", 400);
                }
            }

            $roleRecords = [];
            foreach ($roles as $role) {
                $roleRecords[] = [
                    'user_id' => $user->user_id,
                    'role' => $role,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($roleRecords)) {
                DB::table('user_roles')->insert($roleRecords);
            }

            return ['message' => "Roles successfully added"];
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Role add error", 'code' => 500];
        }
    }

    public function set($userId, $roles): array
    {
        try {
            $user = Users::find($userId);

            if (!$user) {
                return ['message' => "User not found", 'code' => 404];
            }

            DB::transaction(
                function () use ($user, $roles) {
                    $user->roles()->delete();

                    $roleRecords = [];
                    foreach ($roles as $role) {
                        $roleRecords[] = [
                        'user_id' => $user->user_id,
                        'role' => $role,
                        'created_at' => now(),
                        'updated_at' => now(),
                        ];
                    }

                    if (!empty($roleRecords)) {
                        DB::table('user_roles')->insert($roleRecords);
                    }
                }
            );

            return ['message' => "Roles successfully set"];
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Role set error", 'code' => 500];
        }
    }

    public function list($userId): mixed
    {
        try {

            $user = Users::with('roles')->find($userId);

            if (!$user) {
                return ['message' => "User not found", 'code' => 404];
            }

            Log::channel('errorlog')->error($user->id);
            return $user->roles;
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Internal server error", 'code' => 500];
        }
    }

    public function remove($userId, $rolesToRemove): array
    {
        try {
            $user = Users::find($userId);

            if (!$user) {
                return ['message' => "User not found", 'code' => 404];
            }

            $roles = $user->roles()->whereIn('role', $rolesToRemove)->get();

            foreach ($roles as $role) {
                $role->delete();
            }

            return ['message' => "Roles successfully removed"];
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Role remove error", 'code' => 500];
        }
    }
}

