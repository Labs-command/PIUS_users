<h5 class="card-title">{{ $task['subject'] }}</h5>
<p class="card-text">{{ $task['text'] }}</p>
<div id="answer_{{ $task['task_id'] }}" style="display: none;"></div>
<div class="mt-auto">
    <button class="btn btn-info" onclick="showAnswer('{{ $task['answer'] }}')">Показать
        ответ
    </button>
    <button class="btn btn-secondary mt-2" onclick="authorTasks({{ $task['author_id'] }})">
        Задачи автора
    </button>
</div>
