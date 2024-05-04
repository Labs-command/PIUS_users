<?php

use App\Http\Controllers\UserApiController;
use App\Http\Resources\UserResource;
use App\Models\Users;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

test(
    'lists users', function () {
        $userService = \Mockery::mock(UsersService::class);
        $controller = new UserApiController($userService);
        $users = [
        new Users(['user_id' => '1', 'state' => 'active']),
        new Users(['user_id' => '2', 'state' => 'inactive']),
        new Users(['user_id' => '3', 'state' => 'active']),
        ];
        $userService->shouldReceive('list')->once()->andReturn(new Collection($users));

        $request = Request::create('/user', 'GET');
        $response = $controller->list($request);

        expect($response)->toBeInstanceOf(AnonymousResourceCollection::class);
    }
);


test(
    'creates a user', function () {
        $userService = \Mockery::mock(UsersService::class);
        $controller = new UserApiController($userService);

        $request = Request::create(
            '/user', 'POST', [
            'state' => 'active',
            'user_id' => 'test_user_id',
            'roles' => ['user'],
            ]
        );

        $userService->shouldReceive('create')->once()->andReturn(['message' => 'Successfully created', 'code' => 201]);

        $response = $controller->create($request);

        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(201);
    }
);

test(
    'updates a user', function () {
        $userService = \Mockery::mock(UsersService::class);
        $controller = new UserApiController($userService);

        $request = Request::create(
            '/user', 'PUT', [
            'user_id' => 'test_user_id',
            'state' => 'active',
            ]
        );

        $userService->shouldReceive('update')->once()->andReturn(['message' => 'Successfully updated']);

        $response = $controller->update($request);

        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(200);
    }
);

test(
    'deletes a user', function () {
        $userService = \Mockery::mock(UsersService::class);
        $controller = new UserApiController($userService);

        $request = Request::create(
            '/user', 'DELETE', [
            'user_id' => 'test_user_id',
            ]
        );

        $userService->shouldReceive('delete')->once()->andReturn(['message' => 'Successfully deleted']);

        $response = $controller->delete($request);

        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(200);
    }
);
