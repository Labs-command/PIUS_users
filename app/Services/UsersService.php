<?php

namespace App\Services;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class UsersService
{
    /**
     * @throws Exception
     */
    public function list($request): Collection|array
    {
        $query = Users::query();


        if ($request->has('search_field') && $request->has('search_value')) {
            $searchField = $request->input('search_field');
            $searchValue = $request->input('search_value');
            if (in_array($searchField, ['user_id', 'state'])) {
                $query->where($searchField, 'like', '%' . $searchValue . '%');
            } else {
                throw new Exception("Invalid search field", 400);
            }
        }

        $sortOrder = $request->has('sort_order') ? $request->input('sort_order') : "asc";
        if ($request->has('sort_field')) {
            $sortField = $request->input('sort_field');
            if (in_array($sortField, ['user_id', 'state'])) {
                $query->orderBy($sortField, $sortOrder);
            } else {
                throw new Exception("Invalid sort field", 400);
            }
        }

        $offset = $request->has('offset') ? intval($request->input('offset')) : 0;
        $limit = $request->has('limit') ? intval($request->input('limit')) : 10;
        $query->offset($offset)->limit($limit);

        if ($request->has('role')) {
            $query->whereHas(
                'roles', function (Builder $query) use ($request) {
                    $query->where('role', $request->input('role'));
                }
            );
        }

        return $query->get();
    }

    public function create($data): array
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
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "User create error", 'code' => 500];
        }
    }

    public function update($data): array
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
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "User update error", 'code' => 500];
        }
    }

    public function delete($data): array
    {
        try {
            $userId = $data['user_id'];

            Users::destroy($userId);

            return ['message' => "Successfully deleted"];
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return ['message' => "User delete error", 'code' => 500];
        }
    }
}
