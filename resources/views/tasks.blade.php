@extends('base')

@section('title', 'Задачи')

@section('content')
    <div id="container" class="container">
        @include('tasks_panel')
        <div class="row mt-3">
            @foreach($tasks as $task)
                <div id="task_{{ $task['task_id']  }}" class="col-md-6 mt-2 mb-2">
                    <div class="card task-card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            @if($user)
                                @include('task', ['task' => $task])
                            @else
                                @include('reported-task', ['task' => $task])
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @include('pagination_buttons')
        @include('modal', ['modalHeader' => 'Ответ на задачу'])
    </div>
    @if(!$user)
        <script>
            function accept_task(taskId) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/users/moderator/confirm/" + taskId, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            let notification = document.createElement('div');
                            notification.className = 'alert alert-success';
                            notification.innerHTML = 'Задача успешно принята!';
                            let messagesElement = document.getElementById('messages');
                            messagesElement.appendChild(notification);
                            document.getElementById('task_' + taskId).remove()
                            setTimeout(function () {
                                messagesElement.removeChild(notification);
                            }, 5000);
                        } else if (xhr.status === 500) {
                            let errorNotification = document.createElement('div');
                            errorNotification.className = 'alert alert-danger';
                            errorNotification.innerHTML = 'Произошла ошибка при обработке запроса!';
                            let messagesElement = document.getElementById('messages');
                            messagesElement.appendChild(errorNotification);
                            setTimeout(function () {
                                messagesElement.removeChild(errorNotification);
                            }, 5000);
                        }
                    }
                };
                xhr.send();
            }


            function reject_task(taskId) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/users/moderator/reject/" + taskId, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            let notification = document.createElement('div');
                            notification.className = 'alert alert-success';
                            notification.innerHTML = 'Задача успешно отклонена!';
                            let messagesElement = document.getElementById('messages');
                            messagesElement.appendChild(notification);
                            document.getElementById('task_' + taskId).remove()
                            setTimeout(function () {
                                messagesElement.removeChild(notification);
                            }, 5000);
                        } else if (xhr.status === 500) {
                            let errorNotification = document.createElement('div');
                            errorNotification.className = 'alert alert-danger';
                            errorNotification.innerHTML = 'Произошла ошибка при обработке запроса!';
                            let messagesElement = document.getElementById('messages');
                            messagesElement.appendChild(errorNotification);
                            setTimeout(function () {
                                messagesElement.removeChild(errorNotification);
                            }, 5000);
                        }
                    }
                };
                xhr.send();
            }
        </script>
    @endif
@endsection

