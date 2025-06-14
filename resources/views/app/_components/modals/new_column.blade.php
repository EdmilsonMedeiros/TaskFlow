
<style>
    .error-message-container {
        background-color: #e9a8af;
        color: #FFF;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="newColumnModal" tabindex="-1" aria-labelledby="newColumnModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header border-0">
            <h1 class="modal-title fs-5" id="newColumnModalLabel">Nova Categoria</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="card-id text-danger p-2 mb-4 w-100 rounded-1 error-message-container d-none">
                {{-- Errro messages --}}
            </div>
            <form id="newColumnForm" action="" method="POST">
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
            <button type="submit" form="newColumnForm" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Adicionar
            </button>
        </div>

        </div>
    </div>
</div>


<script>
// Submit form with ajax jQuery
$('#newColumnForm').on('submit', function(e) {

    const name = $('#newColumnModal #name').val();
    const color = $('#newColumnModal #color').val();
    const board_id = {{ $board->id }};

    e.preventDefault();
    $.ajax({
        url: '/columns',
        type: 'POST',
        data: {
            name: name,
            color: color,
            board_id: board_id,
        },
        headers: {
            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            'Accept': 'application/json',
        },
        success: function(response) {
            console.log(response);
            columnsReload();
            loadColumns();
            
            $('#newColumnModal').modal('hide');
        },
        error: function(xhr, status, error) {
            $('#newColumnModal .error-message-container').html('');
            const errorMessageElement = $('.error-message-container');
            errorMessageElement.append(`${xhr.responseJSON.error.name[0]}`);
            errorMessageElement.removeClass('d-none');
        }
    });
});
</script>