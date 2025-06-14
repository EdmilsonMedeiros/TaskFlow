<style>
    .error-message-container {
        background-color: #e9a8af;
        color: #FFF;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="newBoardModal" tabindex="-1" aria-labelledby="newBoardModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header border-0">
            <h1 class="modal-title fs-5" id="newBoardModalLabel">Novo Quadro</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="card-id text-danger p-2 mb-4 w-100 rounded-1 error-message-container d-none">
                {{-- Errro messages --}}
            </div>
            <form id="newBoardForm" action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome do Quadro</label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control form-control-lg" id="description" name="description"></textarea>
                </div>
            </form>
        </div>

        <div class="modal-footer border-0">
            <button type="submit" form="newBoardForm" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Criar
            </button>
        </div>

        </div>
    </div>
</div>


<script>
// Submit form with ajax jQuery
$('#newBoardForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '/boards',
        type: 'POST',
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            'Accept': 'application/json',
        },
        success: function(response) {
            boardsReload();
            loadBoards();

            $('#newBoardModal').modal('hide');
        },
        error: function(xhr, status, error) {
            const errorMessageElement = $('.error-message-container');
            errorMessageElement.append(`${xhr.responseJSON.error.name[0]}`);
            errorMessageElement.removeClass('d-none');
        }
    });
});
</script>