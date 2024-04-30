<div id="task_{{ $task['task_id']  }}">
    <h5 class="card-title">{{ $task['subject'] }}</h5>
    <p class="card-text">{{ $task['text'] }}</p>
    <p class="card-answer">Ответ: {{ $task['answer'] }}</p>
    <div class="mt-auto">
        <button class="btn btn-success mt-2" onclick="accept_task(`{{ $task['task_id']  }}`)">
            Одобрить
        </button>
        <button class="btn btn-danger mt-2" onclick="reject_task(`{{ $task['task_id']  }}`)">
            Отказать
        </button>
    </div>
</div>
