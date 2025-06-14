<div class="modal fade" id="deleteCardModal" tabindex="-1" aria-labelledby="deleteCardModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="deleteCardModalLabel">Deletar Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p>Tem certeza que deseja deletar a task?</p>
            </div>

            <div class="modal-footer border-0">
                <button type="button" onclick="deleteCard(event)" data-card-id="" class="btn btn-danger">
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
const deleteCard = async (event) => {
    event.preventDefault();
    event.stopImmediatePropagation();

    const cardId = $('#deleteCardModal').data('data-card-id');

    // remove the card from the database
    $.ajax({
        url: `/cards/${cardId}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        success: function(response) {
            $(`#card-${cardId}`).remove();
            $('#deleteCardModal').modal('hide');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    return;
}
</script>


