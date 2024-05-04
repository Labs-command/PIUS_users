<?php

namespace App\Services;

class TasksService extends BaseTasksService
{
    public function __construct()
    {
        parent::__construct('tasks', 1);
    }
}

