<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class UsersService
{
    public function list($request)
    {
        $query = Users::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('state')) {
            $query->where('state', $request->input('state'));
        }

        if ($request->has('role')) {
            $query->whereHas(
                'roles', function ($query) use ($request) {
                    $query->where('role', $request->input('role'));
                }
            );
        }

        return $query->get();
    }

    public function create($data)
    {
        try {
            DB::transaction(
                function () use ($data) {
                    $user = Users::create(
                        [
                        'state' => $data['state'] ?? 'blocked',
                        ]
                    );
                    $roles = $data['roles'] ?? array('user');
                    foreach ($roles as $role) {
                        $user->roles()->create(
                            [
                            'role' => $role,
                            ]
                        );
                    }
                }
            );

            return ['message' => "Successfully created", 'code' => 201];
        } catch (\Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "User create error", 'code' => 500];
        }
    }

    public function update($data)
    {
        try {
            $userId = $data['user_id'];

            $user = Users::find($userId);

            $user->update(
                [
                'state' => $data['state'] ?? $user->state,
                ]
            );

            return ['message' => "Successfully updated"];
        } catch (\Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "User update error", 'code' => 500];
        }
    }

    public function delete($data)
    {
        try {
            $userId = $data['user_id'];

            Users::destroy($userId);

            return ['message' => "Successfully deleted"];
        } catch (\Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "User delete error", 'code' => 500];
        }
    }
}
