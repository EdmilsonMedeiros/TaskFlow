<div class="modal fade" id="deleteColumnModal" tabindex="-1" aria-labelledby="deleteColumnModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="deleteColumnModalLabel">Deletar Categoria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p>Tem certeza que deseja deletar a categoria?</p>
            </div>

            <div class="modal-footer border-0">
                <button type="button" onclick="deleteColumn(event)" data-column-id="" class="btn btn-danger">
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
    
const deleteColumn = async (event) => {
    // Delete the board
    const columnId = $('#deleteColumnModal').data('data-column-id');

    $.ajax({
        url: `/columns/${columnId}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        success: function(response) {
            columnsReload();
            loadColumns();
            $('#deleteColumnModal').modal('hide');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);  
        }
    });
}
</script>