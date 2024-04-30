<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BaseTasksService
{
    private const MAX_RETRY_COUNT = 3;
    protected $baseUrl;

    public function __construct(string $apiEntity, int $apiVersion)
    {
        $this->baseUrl = env('TASKS_BASE_URL') . '/' . $apiEntity .'/api/v' . $apiVersion . '/tasks/';
    }

    /**
     * @throws RequestException
     */
    private function retryRequest(callable $request, array $args): ?array
    {
        $retryCount = 0;

        while ($retryCount < self::MAX_RETRY_COUNT) {
            try {
                $response = $request(...$args);

                if (!is_null($response)) {
                    return $response;
                }
            } catch (Exception $e) {
                Log::channel('errorlog')->error("Failed request to task service: try " . ($retryCount + 1) . " with message: " . $e->getMessage());
            }

            $retryCount++;
        }

        throw new RequestException($response);
    }


    /**
     * Получить данные о задаче по идентификатору.
     *
     * @param  int $id Идентификатор задачи.
     * @return array|null Данные о задаче или null, если не удалось получить данные.
     * @throws RequestException
     */
    public function getTaskById(int $id): ?array
    {
        return $this->retryRequest(
            function (int $id) {
                $response = Http::get($this->baseUrl . $id);

                if ($response->successful()) {
                    return $response->json();
                }

                return null;
            }, [$id]
        );
    }


    /**
     * Поиск задач по критериям.
     *
     * @param  array $criteria Критерии поиска.
     * @return array|null Результаты поиска или null, если не удалось выполнить запрос.
     * @throws RequestException
     */
    public function searchTasks(array $criteria = []): ?array
    {
        return $this->retryRequest(
            function (array $criteria) {
                $response = Http::post($this->baseUrl . 'search', $criteria);

                if ($response->successful()) {
                    return $response->json();
                }

                return null;
            }, [$criteria]
        );
    }

    /**
     * Создать новую задачу.
     *
     * @param  array $data Данные для создания задачи.
     * @return array|null Результат создания задачи или null, если не удалось выполнить запрос.
     * @throws RequestException
     */
    public function createTask(array $data): ?array
    {
        return $this->retryRequest(
            function (array $data) {
                $response = Http::post($this->baseUrl, $data);

                if ($response->successful()) {
                    return $response->json();
                }

                return null;
            }, [$data]
        );
    }

    /**
     * Удалить задачу по идентификатору.
     *
     * @param  int $id Идентификатор задачи для удаления.
     * @return array Флаг успешного удаления задачи.
     * @throws RequestException
     */
    public function deleteTask(int $id): array
    {
        return $this->retryRequest(
            function (int $id) {
                $response = Http::delete($this->baseUrl . $id);
                return $response->successful();
            }, [$id]
        );
    }
}
