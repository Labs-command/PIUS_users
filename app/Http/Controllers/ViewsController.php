<?php

namespace App\Http\Controllers;

use App\Services\TasksService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;

class ViewsController
{

    public function __construct(TasksService $tasksService)
    {
        $this->tasksService = $tasksService;
    }

    public function userPage(): View
    {
        try {
            $tasks = $this->tasksService->searchTasks();
            return view('tasks', ['tasks' => $tasks['data']]);
        } catch (Exception $e) {
            return view('error', ['message' => 'Произошла ошибка при загрузке задач. Пожалуйста, попробуйте снова позже.']);
        }
    }

    public function searchTasksPage(Request $request): View
    {
        $criteria = [
            "search_query" => $request->input('search_query'),
            "sort_field" => $request->input('sort_field'),
            "sort_value" => $request->input('sort_order') ?: 'asc',
            "offset" => $request->input('offset') ?: 0,
            "limit" => $request->input('limit') ?: 10,
            "author_id" => $request->input('author_id')
        ];

        $tasks = $this->tasksService->searchTasks($criteria);

        return view('tasks', ['tasks' => $tasks['data']]);
    }


    public function moderatorPage(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $tasks = Http::get(
            'localhost:8001/tasks/api/v1/reported-tasks'
        );
        return view('moderator', ['tasks' => $tasks]);
    }
}
