<?php
use App\Http\Controllers\UsersController;
use App\Services\TasksService;
use App\Services\ReportedTasksService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

test(
    'renders user page', function () {
        // Создаем моки для сервисов
        $tasksService = \Mockery::mock(TasksService::class);
        $reportedTasksService = \Mockery::mock(ReportedTasksService::class);
        $tasksService->shouldReceive('searchTasks')->once()->andReturn(['data' => []]);
        $controller = new UsersController($tasksService, $reportedTasksService);

        $request = Request::create('/users', 'GET');
        $response = $controller->userPage($request);

        expect($response)->toBeInstanceOf(View::class);
        $this->assertEquals('tasks', $response->getName());
    }
);

test(
    'redirects after creating a task', function () {
        $tasksService = \Mockery::mock(TasksService::class);
        $reportedTasksService = \Mockery::mock(ReportedTasksService::class);
        $reportedTasksService->shouldReceive('createTask')->once()->andReturn(['task_created' => true]);
        $controller = new UsersController($tasksService, $reportedTasksService);

        $request = Request::create(
            '/users/create', 'POST', [
            'subject' => 'Test Subject',
            'answer' => 'Test Answer',
            'text' => 'Test Text',
            'author_id' => 'test_author_id',
            ]
        );
        $response = $controller->createTask($request);

        expect($response)->toBeInstanceOf(RedirectResponse::class);
        $this->assertEquals('http://0.0.0.0/users', $response->getTargetUrl());
    }
);

