<div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="answerModalLabel">{{ $modalHeader }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="answerBody"></div>
        </div>
    </div>
</div>

<script>
    function showAnswer(answer) {
        document.getElementById('answerBody').innerHTML = answer;
        const myModal = new bootstrap.Modal(document.getElementById('answerModal'));
        myModal.show();
    }
</script>
