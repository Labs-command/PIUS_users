<?php
use App\Http\Controllers\ModeratorsController;
use App\Services\TasksService;
use App\Services\ReportedTasksService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

test(
    'renders moderator page', function () {
        $tasksService = \Mockery::mock(TasksService::class);
        $reportedTasksService = \Mockery::mock(ReportedTasksService::class);
        $tasksService->shouldReceive('searchTasks')->andReturn(['data' => []]);
        $reportedTasksService->shouldReceive('searchTasks')->andReturn(['data' => []]);
        $controller = new ModeratorsController($tasksService, $reportedTasksService);

        $request = Request::create('/users/moderator', 'GET');
        $response = $controller->moderatorPage($request);

        expect($response)->toBeInstanceOf(View::class);
        $this->assertEquals('tasks', $response->getName());
    }
);

it(
    'confirms reported task', function () {
        $reportedTasksService = \Mockery::mock(ReportedTasksService::class);
        $controller = new ModeratorsController(\Mockery::mock(TasksService::class), $reportedTasksService);
        $reportedTasksService->shouldReceive('confirmTask')->once()->with(1)->andReturn([]);

        $response = $controller->reportedTaskConfirm(1);

        expect($response)->toBeInstanceOf(Response::class);
        expect($response->getStatusCode())->toBe(200);
    }
);

it(
    'rejects reported task', function () {
        $reportedTasksService = \Mockery::mock(ReportedTasksService::class);
        $controller = new ModeratorsController(\Mockery::mock(TasksService::class), $reportedTasksService);
        $reportedTasksService->shouldReceive('deleteTask')->once()->with(1)->andReturn(true);

        $response = $controller->reportedTaskReject(1);

        expect($response)->toBeInstanceOf(Response::class);
        expect($response->getStatusCode())->toBe(200);
    }
);
