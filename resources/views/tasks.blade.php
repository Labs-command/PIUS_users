@extends('base')

@section('title', 'Задачи')

@section('content')
    <div class="container">
        @include('tasks_panel')
        <div class="row mt-3">
            @foreach($tasks as $task)
                <div class="col-md-6 mt-2 mb-2">
                    <div class="card task-card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $task['subject'] }}</h5>
                            <p class="card-text">{{ $task['text'] }}</p>
                            <p class="card-text">Автор: {{ $task['author_id'] }}</p>
                            <div id="answer_{{ $task['id'] }}" style="display: none;"></div>
                            <div class="mt-auto">
                                <button class="btn btn-info" onclick="showAnswer('{{ $task['answer'] }}')">Показать ответ</button>
                                <button class="btn btn-secondary mt-2" onclick="authorTasks({{ $task['author_id'] }})">Задачи автора</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item" id="previous_page">
                        <button class="page-link" type="button" onclick="previous_page()" aria-label="Next">
                            <span aria-hidden="true">&laquo;</span>
                        </button>
                    </li>
                    <li class="page-item" id="next_page">
                        <button class="page-link" type="button" onclick="next_page()" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
        @include('modal', ['modalHeader' => 'Ответ на задачу'])
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = localStorage.getItem('search_query');
            const sortField = localStorage.getItem('sort_field');
            const sortValue = localStorage.getItem('sort_value');
            const limit = localStorage.getItem('limit') || '10';
            const offset = parseInt(localStorage.getItem('offset') || '0', 10);

            if (searchInput) {
                document.getElementById('searchInput').value = searchInput;
            }
            if (sortField) {
                document.getElementById('sortField').value = sortField;
            }
            if (sortValue) {
                document.getElementById('sortValue').value = sortValue;
            }
            if (limit) {
                document.getElementById('limit').value = limit;
            }

            if(offset === 0){
                document.getElementById("previous_page").style.display = "none";
            }
        });

        function search() {
            window.location.href = getUrl();
        }

        function authorTasks(authorId) {
            localStorage.setItem('author_id', authorId);
            window.location.href = getUrl();
        }

        function updateFields() {
            const search = document.getElementById('searchInput').value;
            const sortField = document.getElementById('sortField').value;
            const sortValue = document.getElementById('sortValue').value;
            const limit = document.getElementById('limit').value;

            localStorage.setItem('search_query', search);
            localStorage.setItem('sort_field', sortField);
            localStorage.setItem('sort_value', sortValue);
            localStorage.setItem('limit', limit);
        }

        function getUrl() {

            updateFields();

            const limit = parseInt(document.getElementById('limit').value, 10);
            const offset = parseInt(localStorage.getItem('offset') || '0', 10);
            const sortField = document.getElementById('sortField').value;
            const sortValue = document.getElementById('sortValue').value;
            const searchInput = document.getElementById('searchInput').value;

            let url = '/users/search?';

            if (searchInput.trim() !== '') {
                url += `&search_query=${searchInput}`;
            }
            if (sortField.trim() !== '') {
                url += `&sort_field=${sortField}`;
            }
            if (sortValue.trim() !== '') {
                url += `&sort_value=${sortValue}`;
            }
            if (limit) {
                url += `&limit=${limit}`;
            }
            if (offset) {
                url += `&offset=${offset}`;
            }
            const authorId = localStorage.getItem('author_id');
            if (authorId) {
                url += `&author_id=${authorId}`;
            }

            if (url.charAt(url.length - 1) === '&') {
                url = url.slice(0, -1);
            }

            return url;
        }

        function changeLimit() {
            const limit = parseInt(document.getElementById('limit').value, 10);
            localStorage.setItem('limit', limit);
            search();
        }

        function next_page() {
            let offset = parseInt(localStorage.getItem('offset') || '0', 10);
            const limit = parseInt(localStorage.getItem('limit') || '10', 10);
            offset = Math.min(limit + offset, 1000);

            localStorage.setItem('offset', offset);
            search();
        }

        function previous_page() {
            let offset = parseInt(localStorage.getItem('offset') || '0', 10);
            const limit = parseInt(localStorage.getItem('limit') || '10', 10);
            offset = Math.max(offset - limit, 0);

            localStorage.setItem('offset', offset);
            search();
        }
    </script>

@endsection

