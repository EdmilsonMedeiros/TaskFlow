@extends('app._layout.index')

@section('content')
<div class="container-fluid p-5">

    <h3 class="text-start mb-4 fs-5 text-muted">Resumo das suas tasks</h3>
    <div class="row tasks-div mb-3">
        {{-- Show the tasks --}}
    </div>

    <h3 class="text-start mb-4 p-0 m-0">Todos os Quadros</h3>
    <div class="row p-2 mb-5">
        <div class="col-md-6 mt-2 d-flex">
            <i class="bi bi-search mt-2" style="margin-right: -25px; z-index: 1;"></i>
            <input type="text" class="form-control px-5 w-100" placeholder="Pesquisar" id="search-input" oninput="searchLoadBoards()">
        </div>
        <div class="col-md-6 mt-3 d-flex justify-content-end align-items-center">
            <a href="#" class="text-decoration-none fs-5 text-muted" onclick="onNewBoardModal(event)">
                <i class="bi bi-plus"></i> Novo Quadro
            </a>
        </div>
    </div>

    <div class="row board-card-div mt-3 p-2">
        {{-- Show the boards --}}
    </div>

    <div class="d-flex justify-content-center gap-2 mt-8 mb-2 fixed-bottom">
        <button class="btn btn-secondary" onclick="previousPage()"> <i class="bi bi-arrow-left"></i> </button>
        <span class="text-muted mt-2 pages-span fw-bold">1 de 10</span>
        <button class="btn btn-secondary" onclick="nextPage()"> <i class="bi bi-arrow-right"></i></button>
    </div>
</div>

@include('app._components.modals.delete_board')
@include('app._components.modals.new_board')

<script>

let typingTimer;
const typingInterval = 1000; // 15 seconds

let currentPage = 1;
let lastPage = 1;

const searchLoadBoards = () => {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(async () => {
        await boardsReload();
        await loadBoards();
    }, typingInterval);
}

const nextPage = async () => {
    currentPage++;

    if (currentPage > lastPage) {
        currentPage = lastPage;
    }

    await boardsReload();
    await loadBoards(currentPage);
}

const previousPage = async () => {
    currentPage--;

    if (currentPage < 1) {
        currentPage = 1;
    }

    await boardsReload();
    await loadBoards(currentPage);
}

const loadBoards = async (page = 1) => {
    $.ajax({
        url: '/boards',
        type: 'GET',
        data: {
            search: $('#search-input').val(),
            perPage: 6,
            page: page
        },
        headers: {
            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            'Accept': 'application/json',
        },
        success: async function(response) {
            console.log(response);
            if (response.data.length === 0) {
                $('#newBoardModal').modal('show');

                $('.board-card-div').append(`
                    <div class="card-body d-flex flex-column align-items-center justify-content-center mt-5">
                        <h5 class="card-title text-muted mb-3">Nenhum quadro encontrado</h5>
                    </div>
                `);
            }

            response.data.forEach(board => {
                $('.board-card-div').append(`
                    <div class="col-md-4 p-0">
                        <div class="card m-1">
                            <div class="card-body d-flex flex-column align-items-start">
                                <h5 class="card-title text-muted mb-3">${board.name}</h5>
                                <p class="card-text text-muted">${board.description || 'Sem descrição'}</p>

                                <div class="gap-2 ">
                                    <a href="/boards/${board.id}" class="btn btn-outline-secondary mt-2"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-outline-danger mt-2" onclick="onDeleteBoard(${board.id}, event)"><i class="bi bi-trash text-danger"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('.pages-span').text(`Página ${response.current_page} de ${response.last_page}`);
            lastPage = response.last_page;
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

const loadMyCards = async () => {
    $.ajax({
        url: '/cards',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': `{{ csrf_token() }}`,
            'Accept': 'application/json',
        },
        success: function(response) {

            console.log('response', response);

            if (response.length === 0) {
                return $('.tasks-div').append(`
                    <div class="card-body d-flex flex-column align-items-center justify-content-center mt-5">
                        <h5 class="card-title text-muted mb-3">Nenhuma task encontrada</h5>
                    </div>
                `);
            }

            response.forEach(card => {
                $('.tasks-div').append(`
                    <div class="col-md-4 p-0">
                        <div class="card m-1">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <h5 class="card-title text-muted mb-3">${card.title}</h5>
                                    <span class="text-muted fs-6">${new Date(card.created_at).toLocaleDateString('pt-BR')}</span>
                                </div>
                                <p class="card-text fw-bold" style="font-size: 12px; color: ${card.column.color};">${card.column.name}</p>
                            </div>
                        </div>
                    </div>
                `);
            });
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

$(document).ready(async function() {
    loadBoards();

    loadMyCards();
});

const boardsReload = async () => {
    $('.board-card-div').html('');
}

const onDeleteBoard = async (id, event) => {

    console.log('id___', id);
    event.preventDefault();
    event.stopImmediatePropagation();

    await $('#deleteBoardModal').data('data-board-id', id);
    await $('#deleteBoardModal').modal('show');
}

const onNewBoardModal = (event) => {
    event.preventDefault();
    event.stopImmediatePropagation();

    $('#newBoardModal').modal('show');
}

</script>
@endsection