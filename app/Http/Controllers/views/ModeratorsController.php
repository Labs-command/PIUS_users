<?php

namespace App\Http\Controllers\views;

use App\Services\ReportedTasksService;
use App\Services\TasksService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ModeratorsController
{

    public function __construct(TasksService $tasksService, ReportedTasksService $reportedTasksService)
    {
        $this->tasksService = $tasksService;
        $this->reportedTasksService = $reportedTasksService;
    }

    public function moderatorPage(Request $request): View
    {
        try {
            $criteria = [
                "search_value" => $request->input('search_query'),
                "sort_field" => $request->input('sort_field'),
                "sort_value" => $request->input('sort_order') ?: 'asc',
                "offset" => $request->input('offset') ?: 0,
                "limit" => $request->input('limit') ?: 10,
            ];
            $tasks = $this->reportedTasksService->searchTasks($criteria);

            return view('tasks', ['tasks' => $tasks['data'], 'user' => false]);
        } catch (Exception $e) {
            return view('error', ['message' => 'Произошла ошибка при загрузке задач. Пожалуйста, попробуйте снова позже.']);
        }
    }
    public function reportedTaskConfirm($id): Response
    {
        try {
            $tasks = $this->reportedTasksService->confirmTask($id);

            return response('', 200);
        } catch (Exception $e) {
            return response('Confirm task error', 500);
        }
    }
    public function reportedTaskReject($id): Response
    {
        try {
            $tasks = $this->reportedTasksService->deleteTask($id);

            return response('', 200);
        } catch (Exception $e) {
            return response('Reject task error', 500);
        }
    }
}
