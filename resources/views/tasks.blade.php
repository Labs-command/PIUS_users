@extends('base')

@section('title', 'Задачи')

@section('content')
    <div class="container">
        <h1 class="mt-4">Список задач</h1>
        <label>
            <input type="text" class="form-control mt-3" placeholder="Поиск по задачам">
        </label>
        <div class="row mt-3">
            @foreach($tasks as $task)
                <div class="col-md-6">
                    <div class="card task-card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $task['subject'] }}</h5>
                            <p class="card-text">{{ $task['text'] }}</p>
                            <p class="card-text">Дата создания: {{ $task['date_added'] }}</p>
                            <p class="card-text">Автор: {{ $task['author']['name'] }}</p>
                            <div id="answer_{{ $task['id'] }}" style="display: none;">

                            </div>
                            <div class="mt-auto">
                                <button class="btn btn-info " onclick="showAnswer('{{ $task['answer'] }}')">Показать ответ</button>
                                <button class="btn btn-secondary mt-2"
                                        onclick="showAuthorInfo({{ $task['author']['id'] }})">
                                    Задачи автора
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="answerModalLabel">Ответ на задачу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="answerBody">
                </div>
            </div>
        </div>
    </div>
    <script>
        function showAnswer(answer) {
            console.log(document.getElementById('answerBody'))

            document.getElementById('answerBody').innerHTML = answer;

            const myModal = new bootstrap.Modal(document.getElementById('answerModal'));
            myModal.show();
        }

        function showAuthorInfo(authorId) {
            window.location.href = '/users/user/' + authorId;
        }
    </script>

@endsection
