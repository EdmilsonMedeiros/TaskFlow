<style>
    .error-message-container {
        background-color: #e9a8af;
        color: #FFF;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="manageMembersModal" tabindex="-1" aria-labelledby="manageMembersModalLabel" aria-hidden="true" data-bs-backdrop="static" data-board-id="">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header border-0">
            <h1 class="modal-title fs-5" id="manageMembersModalLabel">Gerenciar Membros</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <h5 class="fs-6">Membros</h5>
            <hr>
            <div class="board-users-container overflow-auto mb-3 p-2" style="height: 300px;">

            </div>
            <div class="card-id text-danger p-2 mb-4 w-100 rounded-1 error-message-container d-none">
                {{-- Errro messages --}}
            </div>
            <form id="manageMembersForm" action="" method="POST">
                @csrf
                <div class="mb-3 d-flex justify-content-between gap-1">
                    <div class="w-100">
                        <input placeholder="Adicione com o e-mail" type="text" class="form-control form-control-lg" id="email" name="email" value="">
                    </div>
                    <div>
                        <button type="submit" form="manageMembersForm" class="btn btn-primary btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" title="Adicionar membro">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer border-0">

        </div>

        </div>
    </div>
</div>


<script>
    const getBoardUsers = async () => {
        $.ajax({
            url: "{{ route('board.users', ['id' => $board->id]) }}",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: async function(response) {
                // limpa o container
                $('.board-users-container').html('');

                $('.board-users-container').html(response);

                $('#manageMembersLink').html(`
                    <i class="bi bi-person-plus"></i> Membros (${response.length})
                `);


                response.forEach(user => {
                    const boardUserCard = `
                    <div class="d-flex justify-content-between" id="board-user-card-${user.id}">
                        <p class="p-2 m-1 bg-light w-100">${user.email}</p>
                        <div>
                            <button class="btn btn-outline-danger btn-sm mt-2" onclick="removeUserFromBoard(${user.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    `;
                    $('.board-users-container').append(boardUserCard);
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        getBoardUsers();
    });

    function removeUserFromBoard(userId) {
        console.log('userId', userId);
        const boardId = parseInt("{{ $board->id }}");

        if(!confirm('Tem certeza que deseja remover este membro do board?')) {
            return;
        }

        $.ajax({
            url: "/boards/" + boardId + "/users/" + userId,
            type: "DELETE",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            success: function(response) {
                console.log('removeUserFromBoardResponse', response);
                $('#board-user-card-' + userId).remove();
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    console.log(xhr.responseJSON.error);
                    let errorMessage = '';
                    if (xhr.responseJSON.error.userId) {
                        errorMessage += xhr.responseJSON.error.userId[0] + ' ';
                    }
                    if (xhr.responseJSON.error.boardId) {
                        errorMessage += xhr.responseJSON.error.boardId[0];
                    }
                    $('.card-id').html(errorMessage.trim());
                    $('.card-id').removeClass('d-none');
                } else {
                    console.log('An unexpected error occurred.');
                }
            }
        });
    }

    // ADD USER TO BOARD
    $('#manageMembersForm').submit(function(e) {
        e.preventDefault();
        let email = $('#email').val();

        $.ajax({
            url: "/boards/addUser",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({email: email, board_id: '{{ $board->id }}'}),
            success: async function(response) {
                console.log('addUserToBoardResponse', response);
                $('#email').val('');
                await getBoardUsers();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                $('.card-id').html(xhr.responseJSON.error.email[0]);
                $('.card-id').removeClass('d-none');
            }
        });
    });
</script>
