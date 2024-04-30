<?php

namespace App\Http\Controllers;

use App\Services\ReportedTasksService;
use App\Services\TasksService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Redirect;

class ViewsController
{

    public function __construct(TasksService $tasksService, ReportedTasksService $reportedTasksService)
    {
        $this->tasksService = $tasksService;
        $this->reportedTasksService = $reportedTasksService;
    }

    public function userPage(Request $request): View
    {
        try {
            $criteria = [
                "search_query" => $request->input('search_query') ?: "",
                "sort_field" => $request->input('sort_field'),
                "sort_value" => $request->input('sort_order') ?: 'asc',
                "offset" => $request->input('offset') ?: 0,
                "limit" => $request->input('limit') ?: 10,
                "author_id" => $request->input('author_id')
            ];
            $tasks = $this->tasksService->searchTasks($criteria);

            return view('tasks', ['tasks' => $tasks['data'], 'user' => true]);
        } catch (Exception $e) {
            return view('error', ['message' => 'Произошла ошибка при загрузке задач. Пожалуйста, попробуйте снова позже.']);
        }
    }
    public function createTaskPage(): View
    {

        return view('create_task_form');
    }

    public function createTask(Request $request): View|RedirectResponse
    {

        try {
            $params = [
                "subject" => $request->input('subject') ?: "",
                "answer" => $request->input('answer') ?: "",
                "text" => $request->input('text') ?: "",
                "author_id" => $request->input('author_id'),
            ];
            $created = $this->reportedTasksService->createTask($params);
            if($created) {
                if($request->input('createAnother')) {
                    return view('create_task_form');
                }
                return Redirect::to('/users');
            }
            else {
                throw new Exception("Task creation failed");
            }
        } catch (Exception $e) {
            return view('error', ['message' => 'Произошла ошибка при создании задачи. Пожалуйста, попробуйте снова позже.']);
        }
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
