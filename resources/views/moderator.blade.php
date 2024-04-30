@extends('base')

@section('title', 'Модерация задач')

@section('content')
    <div class="container mt-5">
        <h1>Модерация задач</h1>
        <div class="row mt-3">
            @foreach ($tasks as $task)
                <div class="col-md-6">
                    <div class="card task-card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $task['subject'] }}</h5>
                            <p class="card-text">{{ $task['text'] }}</p>
{{--                            <p class="card-text"><small class="text-muted">Добавлено: {{ $task['date_added'] }}</small></p>--}}
                            <p class="card-text">Автор: {{ $task['author']['name'] }}</p>
                            @if (!empty($task['answer']))
                                <div class="alert alert-info" role="alert">
                                    Ответ модератора: {{ $task['answer'] }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <form action="{ route('', $task['id']) }" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Одобрить</button>
                                </form>
                                <form action="{ route('', $task['id']) }" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Отклонить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
