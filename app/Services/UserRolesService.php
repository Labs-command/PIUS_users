<?php

namespace App\Services;

use App\Models\Users;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserRolesService
{
    public function add($userId, $roles)
    {
        try {
            $user = Users::find($userId);

            if (!$user) {
                return ['message' => "User not found", 'code' => 404];
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
        } catch (\Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Role add error", 'code' => 500];
        }
    }

    public function set($userId, $roles)
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
        } catch (\Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Role set error", 'code' => 500];
        }
    }

    public function list($userId)
    {
        try {
            $user = Users::with('roles')->find($userId);

            if (!$user) {
                return ['message' => "User not found", 'code' => 404];
            }

            return $user->roles;
        } catch (\Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Role set error", 'code' => 500];
        }
    }

    public function remove($userId, $rolesToRemove)
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
        } catch (\Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "Role remove error", 'code' => 500];
        }
    }
}

