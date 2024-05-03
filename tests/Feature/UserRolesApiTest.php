<?php

use App\Http\Controllers\UserRolesApiController;
use App\Services\UserRolesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

test(
    'adds roles to user', function () {
        $userRolesService = \Mockery::mock(UserRolesService::class);
        $controller = new UserRolesApiController($userRolesService);
        $data = [
        'user_id' => '123',
        'roles' => ['admin', 'user'],
        ];
        $userRolesService->shouldReceive('add')->once()->with($data['user_id'], $data['roles'])->andReturn(['message' => 'Roles successfully added']);

        $request = Request::create('/roles', 'POST', [], [], [], [], json_encode($data));
        $response = $controller->add($request);

        expect($response)->toBeInstanceOf(JsonResponse::class);
    }
);

test(
    'removes roles from user', function () {
        $userRolesService = \Mockery::mock(UserRolesService::class);
        $controller = new UserRolesApiController($userRolesService);
        $data = [
        'user_id' => '123',
        'roles' => ['admin', 'user'],
        ];
        $userRolesService->shouldReceive('remove')->once()->with($data['user_id'], $data['roles'])->andReturn(['message' => 'Roles successfully removed']);

        $request = Request::create('/roles', 'DELETE', [], [], [], [], json_encode($data));
        $response = $controller->remove($request);

        expect($response)->toBeInstanceOf(JsonResponse::class);
    }
);


test(
    'lists user roles', function () {
        $userRolesService = \Mockery::mock(UserRolesService::class);
        $controller = new UserRolesApiController($userRolesService);
        $userId = '123';
        $userRoles = [
        (object) ['id' => 1, 'user_id' => '123', 'role' => 'admin'],
        (object) ['id' => 2, 'user_id' => '123', 'role' => 'user'],
        ];
        $userRolesService->shouldReceive('list')->once()->with($userId)->andReturn($userRoles);

        $request = Request::create('/roles', 'GET', ['user_id' => $userId]);
        $response = $controller->list($request);

        expect($response)->toBeInstanceOf(AnonymousResourceCollection::class);
    }
);

test(
    'sets user roles', function () {
        $userRolesService = \Mockery::mock(UserRolesService::class);
        $controller = new UserRolesApiController($userRolesService);
        $data = [
        'user_id' => '123',
        'roles' => ['admin', 'user'],
        ];
        $userRolesService->shouldReceive('set')->with($data['user_id'], $data['roles'])->andReturn(['message' => 'Roles successfully set']);

        $request = Request::create('/roles', 'PUT', $data);
        $response = $controller->set($request);

        expect($response)->toBeInstanceOf(JsonResponse::class);
    }
);
