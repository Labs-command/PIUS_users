<h1 class="mt-4">Список задач</h1>
<div id="messages" class="row">
</div>
<div class="row mt-3">
    <div class="col-md-2">
        <label>
            <input id="searchInput" type="text" class="form-control" placeholder="Поиск по задачам">
        </label>
    </div>
    <div class="col-md-2">
        <button id="clearAuthorButton" type="button" onclick="clearAuthorId()" class="btn btn-danger">Автор ✖</button>
    </div>
    @if($user)
        <div class="col-md-2">
            <select id="sortField" class="form-select">
                <option value="date_added">Дата создания</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="sortValue" class="form-select">
                <option value="asc">По возрастанию</option>
                <option value="desc">По убыванию</option>
            </select>
        </div>
    @endif

    <div class="col-md-1">
        <select id="limit" class="form-select" onchange="changeLimit()">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
        </select>
    </div>
    @if($user)
        <div class="col-md-2">
            <a href="{{ route("users.tasks.create.page")  }}">
                <button class="btn btn-success" onclick="" type="button">Создать <b>+</b></button>
            </a>
        </div>
    @endif
</div>
<div class="row mt-3">
    <div class="col-md-4">
        <button id="searchButton" type="button" onclick="search()" class="btn btn-primary">Поиск</button>
    </div>
    @if($user)
        <div class="col-md-4">
            <button id="sortButton" type="button" onclick="search()" class="btn btn-primary">Упорядочить
            </button>
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const authorId = localStorage.getItem('author_id');
        if (!authorId) {
            document.getElementById('clearAuthorButton').style.display = 'none';
        }
    });
    function clearAuthorId() {
        localStorage.removeItem('author_id');
        window.location.href = getUrl();
    }

    @if($user)
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

            if (offset === 0) {
                document.getElementById("previous_page").style.display = "none";
            }
        });
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

            let url = "{{ route('users.page') }}";
            url = url.endsWith('/') ? url.slice(0, -1) : url;

            const params = [];

            if (searchInput.trim() !== '') {
                params.push(`search_query=${searchInput}`);
            }
            if (sortField.trim() !== '') {
                params.push(`sort_field=${sortField}`);
            }
            if (sortValue.trim() !== '') {
                params.push(`sort_value=${sortValue}`);
            }
            if (limit) {
                params.push(`limit=${limit}`);
            }
            if (offset) {
                params.push(`offset=${offset}`);
            }
            const authorId = localStorage.getItem('author_id');
            if (authorId) {
                params.push(`author_id=${authorId}`);
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            return url;
        }

    @else
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = localStorage.getItem('search_query');
            const limit = localStorage.getItem('limit') || '10';
            const offset = parseInt(localStorage.getItem('offset') || '0', 10);

            if (searchInput) {
                document.getElementById('searchInput').value = searchInput;
            }
            if (limit) {
                document.getElementById('limit').value = limit;
            }

            if (offset === 0) {
                document.getElementById("previous_page").style.display = "none";
            }
        });
        function updateFields() {
            const search = document.getElementById('searchInput').value;
            const limit = document.getElementById('limit').value;

            localStorage.setItem('search_query', search);
            localStorage.setItem('limit', limit);
        }
        function getUrl() {
            updateFields();

            const limit = parseInt(document.getElementById('limit').value, 10);
            const offset = parseInt(localStorage.getItem('offset') || '0', 10);
            const searchInput = document.getElementById('searchInput').value;

            let url = "{{ route('moderators.page')  }}";
            url = url.endsWith('/') ? url.slice(0, -1) : url;

            const params = [];

            if (searchInput.trim() !== '') {
                params.push(`search_query=${searchInput}`);
            }
            if (limit) {
                params.push(`limit=${limit}`);
            }
            if (offset) {
                params.push(`offset=${offset}`);
            }
            const authorId = localStorage.getItem('author_id');
            if (authorId) {
                params.push(`author_id=${authorId}`);
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            return url;
        }
    @endif

    function search() {
        window.location.href = getUrl();
    }

    function authorTasks(authorId) {
        localStorage.setItem('author_id', authorId);
        window.location.href = getUrl();
    }

    function changeLimit() {
        const limit = parseInt(document.getElementById('limit').value, 10);
        localStorage.setItem('limit', limit);
        search();
    }
</script>
