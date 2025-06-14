
<style>
    .error-message-container {
        background-color: #e9a8af;
        color: #FFF;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="editColumnModal" tabindex="-1" aria-labelledby="editColumnModalLabel" aria-hidden="true" data-bs-backdrop="static" data-column-id="">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header border-0">
            <h1 class="modal-title fs-5" id="editColumnModalLabel">Editar Categoria</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="card-id text-danger p-2 mb-4 w-100 rounded-1 error-message-container d-none">
                {{-- Errro messages --}}
            </div>
            <form id="editColumnForm" action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome da Categoria</label>
                    <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control form-control-lg" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Cor</label>
                    <input type="color" class="form-control form-control-lg" id="color" name="color" value="#000000">
                </div>
            </form>
        </div>

        <div class="modal-footer border-0">
            <button type="submit" form="editColumnForm" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Atualizar
            </button>
        </div>

        </div>
    </div>
</div>


<script>
// Submit form with ajax jQuery
$('#editColumnForm').on('submit', function(e) {
    const columnId = $('#editColumnModal').data('data-column-id');
    const name = $('#editColumnModal #name').val();
    const color = $('#editColumnModal #color').val();

    console.log({
        columnId: columnId,
        name: name,
        color: color,
    })

    e.preventDefault();
    $.ajax({
        url: `/columns/${columnId}`,
        type: 'PUT',
        data: {
            name: name,
            board_id: {{ $board->id }},
            color: color,
        },
        headers: {
            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            'Accept': 'application/json',
        },
        success: function(response) {
            console.log(response);
            columnsReload();
            loadColumns();
            $('#editColumnModal').modal('hide');
        },
        error: function(xhr, status, error) {
            const errorMessageElement = $('.error-message-container');
            errorMessageElement.append(`${xhr.responseJSON.error.name[0]}`);
            errorMessageElement.removeClass('d-none');
        }
    });
});
</script>