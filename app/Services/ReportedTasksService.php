<?php

namespace App\Services;

class ReportedTasksService extends BaseTasksService
{
    public function __construct()
    {
        parent::__construct('reported-tasks', 1);
    }
}
