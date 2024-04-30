<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportedTasksService extends BaseTasksService
{
    public function __construct()
    {
        parent::__construct('reported-tasks', 1);
    }

    public function confirmTask(string $id): ?array
    {
        return $this->retryRequest(
            function (string $id) {
                $response = Http::post($this->baseUrl . 'confirm/'. $id);
                if ($response->successful()) {
                    return $response->json();
                }

                return null;
            }, [$id]
        );
    }
}
