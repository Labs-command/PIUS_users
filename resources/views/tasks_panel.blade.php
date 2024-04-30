<h1 class="mt-4">Список задач</h1>
<div class="row mt-3">
    <div class="col-md-2">
        <label>
            <input id="searchInput" type="text" class="form-control" placeholder="Поиск по задачам">
        </label>
    </div>
    <div class="col-md-2">
        <button id="clearAuthorButton" type="button" onclick="clearAuthorId()" class="btn btn-danger">Автор ✖</button>
    </div>
    <div class="col-md-2">
        <select id="sortField" class="form-select">
            <option value="subject">Тема</option>
            <option value="id">ID</option>
            <option value="created_at">Дата создания</option>
        </select>
    </div>
    <div class="col-md-2">
        <select id="sortValue" class="form-select">
            <option value="asc">По возрастанию</option>
            <option value="desc">По убыванию</option>
        </select>
    </div>
    <div class="col-md-1">
        <select id="limit" class="form-select" onchange="changeLimit()">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
        </select>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-4">
        <button id="searchButton" type="button" onclick="search()" class="btn btn-primary">Поиск</button>
    </div>
    <div class="col-md-4">
        <button id="sortButton" type="button" onclick="search()" class="btn btn-primary">Упорядочить
        </button>
    </div>
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
</script>
