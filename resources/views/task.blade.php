<h5 class="card-title">{{ $task['subject'] }}</h5>
<p class="card-text">{{ $task['text'] }}</p>
<div id="answer_{{ $task['task_id'] }}" style="display: none;"></div>
<div class="mt-auto">
    @if($user)
        <button class="btn btn-info" onclick="showAnswer('{{ $task['answer'] }}')">Показать
            ответ
        </button>
        <button class="btn btn-secondary mt-2" onclick="authorTasks({{ $task['author_id'] }})">
            Задачи автора
        </button>
    @else
        <button class="btn btn-success mt-2" onclick="confirm_task(`{{ $task['task_id']  }}`)">
            Одобрить
        </button>
        <button class="btn btn-danger mt-2" onclick="reject_task(`{{ $task['task_id']  }}`)">
            Отказать
        </button>
    @endif
</div>
