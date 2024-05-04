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

<script>
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
