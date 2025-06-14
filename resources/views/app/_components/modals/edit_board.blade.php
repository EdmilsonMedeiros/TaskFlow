<style>
    .error-message-container {
        background-color: #e9a8af;
        color: #FFF;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="editBoardModal" tabindex="-1" aria-labelledby="editBoardModalLabel" aria-hidden="true" data-bs-backdrop="static" data-board-id="{{ $board->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header border-0">
            <h1 class="modal-title fs-5" id="editBoardModalLabel">Editar Quadro</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="card-id text-danger p-2 mb-4 w-100 rounded-1 error-message-container d-none">
                {{-- Errro messages --}}
            </div>
            <form id="editBoardForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nome do Board</label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ $board->name }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control form-control-lg" id="description" name="description">{{ $board->description }}</textarea>
                </div>
            </form>
        </div>

        <div class="modal-footer border-0">
            <button type="submit" form="editBoardForm" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Atualizar
            </button>
        </div>

        </div>
    </div>
</div>


<script>
    // Submit form with ajax jQuery
    $('#editBoardForm').on('submit', function(e) {
        const boardId = $('#editBoardModal').data('board-id');
        console.log(boardId);
        e.preventDefault();
        $.ajax({
            url: '/boards/' + boardId,
            type: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': `{{ csrf_token() }}`,
                'Accept': 'application/json',
            },
            success: function(response) {
                boardNameReload(response.name);
                boardDescriptionReload(response.description);

                $('#editBoardModal').modal('hide');
            },
            error: function(xhr, status, error) {
                const errorMessageElement = $('.error-message-container');
                errorMessageElement.append(`${xhr.responseJSON.error.name[0]}`);
                errorMessageElement.removeClass('d-none');
            }
        });
    });

    // reload the board name
    const boardNameReload = async (boardName) => {
        $('.board-name').text(boardName);
    }

    // reload the board description
    const boardDescriptionReload = async (boardDescription) => {
        $('.board-description').text(boardDescription);
    }
</script>