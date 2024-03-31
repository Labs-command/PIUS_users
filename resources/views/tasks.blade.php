@extends('base')

@section('title', 'Задачи')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .task-card {
            margin-bottom: 20px;
        }
    </style>
    <div class="container">
        <h1 class="mt-4">Список задач</h1>
        <input type="text" class="form-control mt-3" placeholder="Поиск по задачам">
        <div class="row mt-3">
            @foreach($tasks as $task)
                <div class="col-md-6">
                    <div class="card task-card  h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $task['subject'] }}</h5>
                            <p class="card-text">{{ $task['text'] }}</p>
                            <p class="card-text">Дата создания: {{ $task['date_added'] }}</p>
                            <p class="card-text">Автор: {{ $task['author']['name'] }}</p>
                            <div class="mt-auto">
                                <button class="btn btn-info " onclick="showAnswer({{ $task['id'] }})">Показать ответ
                                </button>
                                <button class="btn btn-secondary mt-2"
                                        onclick="showAuthorInfo({{ $task['author']['id'] }})">
                                    Информация об авторе
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        function showAnswer(taskId) {
            // Логика для показа ответа на задачу
        }

        function showAuthorInfo(authorId) {
            // Логика для отображения информации об авторе
        }
    </script>
@endsection
