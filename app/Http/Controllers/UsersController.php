<?php

namespace App\Http\Controllers;

use App\Services\ReportedTasksService;
use App\Services\TasksService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class UsersController
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
            //            $cacheKey = json_encode($criteria);

            //            if (Cache::has($cacheKey)) {
            //                $tasks = Cache::get($cacheKey);
            //            } else {
                $tasks = $this->tasksService->searchTasks($criteria);
            //                Cache::put($cacheKey, $tasks, now()->addMinutes(1));
            //            }

            $user = true;

            return view('tasks', ['tasks' => $tasks['data'], 'user' => $user]);

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
}
