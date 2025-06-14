<!-- Modal -->

<style>
    .error-message-container {
        background-color: #e9a8af;
        color: #FFF;
    }
</style>

<div class="modal fade" id="showCardModal" tabindex="-1" aria-labelledby="showCardModalLabel" aria-hidden="true" data-bs-backdrop="static" data-card-id="">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header border-0">
            <h1 class="modal-title fs-5" id="showCardModalLabel">Task</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="card-id text-danger p-2 mb-4 w-100 rounded-1 error-message-container d-none">
                {{-- Errro messages --}}
            </div>

            <div class="d-flex justify-content-start assigned-user-div mb-3">

            </div>

            <form id="showCardForm" action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control form-control-lg" id="title" name="title" value="" maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control form-control-lg" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="member" class="form-label">Atribuir a</label>
                    <select id="memberSelect" class="form-select form-select-lg" name="assigned_user_id">
                        <option value="" selected disabled>Selecione um membro</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="modal-footer border-0 d-flex justify-content-end">
            <button type="submit" form="showCardForm" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Atualizar
            </button>
        </div>

        </div>
    </div>
</div>


<script>
// Submit form with ajax jQuery
$('#showCardForm').on('submit', function(e) {
    const cardId = $('#showCardModal').data('card-id');

    e.preventDefault();
    $.ajax({
        url: `/cards/${cardId}`,
        type: 'PUT',
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            'Accept': 'application/json',
        },
        success: function(response) {
            columnsReload();
            loadColumns();

            $('#showCardModal').modal('hide');
        },
        error: function(xhr, status, error) {
            const errorMessageElement = $('.error-message-container');
            errorMessageElement.text(xhr.responseJSON.errors.title[0]);
            errorMessageElement.removeClass('d-none');
        }
    });
});

$(document).ready(function() {
    $.ajax({
        url: "{{ route('board.users', ['id' => $board->id]) }}",
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        success: async function(response) {
            $('#memberSelect').html('');
            $('#memberSelect').append(`<option value="" selected disabled>Selecione um membro</option>`);

            response.forEach(user => {
                $('#memberSelect')
                .append(`<option value="${user.id}">${user.name} - ${user.email}</option>`);
            });

            new TomSelect("#memberSelect", {
                placeholder: 'Selecione um membro',
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});

</script>