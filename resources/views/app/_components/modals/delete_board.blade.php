<div class="modal fade" id="deleteBoardModal" tabindex="-1" aria-labelledby="deleteBoardModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="deleteBoardModalLabel">Deletar Quadro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p>Tem certeza que deseja deletar o quadro?</p>
            </div>

            <div class="modal-footer border-0">
                <button type="button" onclick="deleteBoard(event)" data-board-id="" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Deletar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const deleteBoard = async (event) => {
    // Delete the board
    event.preventDefault();

    const boardId = $('#deleteBoardModal').data('data-board-id');

    console.log('id___2', boardId);

    $.ajax({
        url: `/boards/${boardId}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            'Accept': 'application/json',
        },
        success: function(response) {
            boardsReload();
            loadBoards();
            $('#deleteBoardModal').modal('hide');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}
</script>


