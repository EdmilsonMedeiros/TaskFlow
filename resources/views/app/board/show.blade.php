@extends('app._layout.index')
@section('content')

<div class="container-fluid p-5">
    <div class="row border-bottom border-1 mb-4">
        <div class="col-10">
            <div class="d-flex gap-3">
                <h3 class="text-start board-name">{{ $board->name }}</h3>
                <a href="#" class="text-decoration-none text-light-gray mt-2" onclick="onBoardEdit(event)"><i class="bi bi-pencil-square"></i></a>
            </div>
            <p class="text-muted board-description">{{ $board->description }}</p>
        </div>
        <div class="col-2 d-flex justify-content-end">
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between gap-2 mb-2">
        <div>
            <a href="#" id="manageMembersLink" class="fs-5 text-decoration-none text-muted" data-bs-toggle="modal" data-bs-target="#manageMembersModal"><i class="bi bi-person-plus"></i> Membros</a>
        </div>
        <div>
            <a href="#" class="fs-5 text-decoration-none text-muted" onclick="onNewColumn(event)"><i class="bi bi-plus"></i>Nova categoria</a>
        </div>
    </div>

    <div class="row flex-nowrap columns-div overflow-auto">

    </div>
</div>

@include('app._components.modals.new_column', ['board' => $board])
@include('app._components.modals.edit_board', ['board' => $board])
@include('app._components.modals.manage_members', ['board' => $board])
@include('app._components.modals.show_card', ['board' => $board])
@include('app._components.modals.edit_column', ['board' => $board])
@include('app._components.modals.delete_column')
@include('app._components.modals.delete_card')

<script>
    // limit the card title length by 100 characters
    const limitCardTitleLength = (event) => {
        const cardTitle = event.target.textContent;
        const cursorPosition = event.target.selectionStart;

        if(cardTitle.length >= 100) {
            // Mantém apenas os primeiros 99 caracteres
            event.target.textContent = cardTitle.substring(0, 100);
            
            // Restaura a posição do cursor para o final do texto
            const range = document.createRange();
            const sel = window.getSelection();
            range.setStart(event.target.childNodes[0], 100);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }

    const boardId = {{ $board->id }};

    // Get the columns
    const loadColumns = async () => {
        $.ajax({
            url: `/columns/${boardId}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            success: function(response) {
                response.forEach(column => {
                    $('.columns-div').append(`
                        <div class="col-3 column-div border-end border-1 overflow-auto" id="column-${column.id}">
                            <div class="colum-header p-1 d-flex justify-content-between align-items-center">
                                <h5 class="" id="name" data-color="${column.color}" style="color: ${column.color};">${column.name.substring(0, 18) + (column.name.length > 18 ? '...' : '')}</h5>
                                <div class="colum-header-actions">
                                    <a href="#" class="fs-5 text-decoration-none text-light-gray" data-column-id="${column.id}" onclick="onEditColumnModal(${column.id}, event)"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="fs-5 text-decoration-none text-light-gray" onclick="onDeleteColumn(${column.id}, event)"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>

                            <button class="btn text-start col-12 mt-2 bg-light text-muted border-0" onclick="newCard(${column.id}, event)">
                                <i class="bi bi-plus"></i>
                                Adicionar task
                            </button>

                            <div class="cards-div">
                                ${column.cards.map(card => `
                                    <div class="card mt-2 w-100" id="card-${card.id}">
                                        <div class="card-body d-flex justify-content-between gap-2">
                                            <div class="d-flex align-items-center gap-2 w-100">
                                                <div class="drag-handle">
                                                    <i class="bi bi-grip-vertical"></i>
                                                </div>
                                                <div class="open-card d-flex flex-column w-100" onclick="openCard(${card.id}, event)">
                                                    <span class="card-title w-100 text-decoration-none text-dark">${card.title.substring(0, 30) + (card.title.length > 30 ? '...' : '')}</span>
                                                    <span class="card-assigned-user w-100 text-decoration-none text-muted text-start">
                                                        <i class="bi bi-person-fill"></i>
                                                        ${card.assigned_user_id ? card.assigned_user.name : 'Não atribuído'}</span>
                                                </div>
                                            </div>
                                            <div class="card-actions card-actions-delete h-100">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Deletar" class="fs-5 text-decoration-none text-light-gray" onclick="onDeleteCard(${card.id}, event)"><i class="bi bi-trash"></i></a>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Avançar" class="fs-5 text-decoration-none text-light-gray" onclick="nextColumn(${card.id}, event)"><i class="bi bi-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>  
                        </div>
                    `);
                });

                // Inicializa o drag and drop após carregar as colunas
                initializeDragAndDrop();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    };

    loadColumns();

    // Move o card para a próxima coluna
    const nextColumn = async (cardId, event) => {
        $.ajax({
            url: `/cards/cardNext/${cardId}`,
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            success: async function(response) {
                console.log(response);
                
                await $('#showCardModal .column-div-show').html('');

                await $('#showCardModal .column-div-show').append(`
                    <span class="w-100 text-decoration-none text-start fs-6" style="color: ${response.column.color};">
                        <a href="#" class="fs-5 text-decoration-none text-light-gray mt-1" onclick="previousColumn(${cardId}, event)"><i class="bi bi-arrow-left"></i></a>
                        ${response.column.name}
                        <a href="#" class="fs-5 text-decoration-none text-light-gray mt-1" onclick="nextColumn(${cardId}, event)"><i class="bi bi-arrow-right"></i></a>
                    </span>
                `);

                columnsReload();
                loadColumns();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    // Move o card para a coluna anterior
    const previousColumn = async (cardId, event) => {
        event.preventDefault();
        event.stopImmediatePropagation();

        $.ajax({
            url: `/cards/cardPrevious/${cardId}`,
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            success: async function(response) {
                console.log(response);

                await $('#showCardModal .column-div-show').html('');

                await $('#showCardModal .column-div-show').append(`
                    <span class="w-100 text-decoration-none text-start fs-6" style="color: ${response.column.color};">
                        <a href="#" class="fs-5 text-decoration-none text-light-gray mt-1" onclick="previousColumn(${cardId}, event)"><i class="bi bi-arrow-left"></i></a>
                        ${response.column.name}
                        <a href="#" class="fs-5 text-decoration-none text-light-gray mt-1" onclick="nextColumn(${cardId}, event)"><i class="bi bi-arrow-right"></i></a>
                    </span>
                `);

                columnsReload();
                loadColumns();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

        return;
    }

    // Edit column
    const onEditColumnModal = async (columnId, event) => {

        const column = await $('#column-' + columnId);

        $('#editColumnModal').modal('show');
        $('#editColumnModal').data('data-column-id', columnId);
        $('#editColumnModal #name').val(column.find('#name').text());
        $('#editColumnModal #color').val(column.find('#name').attr('data-color'));

        return;
    }

    // Reload the columns div content
    const columnsReload = async () => {
        $('.columns-div').html('');
    }

    // Delete column
    const onDeleteColumn = async (id, event) => {
        $('#deleteColumnModal').modal('show');
        $('#deleteColumnModal').data('data-column-id', id);
    }

    // store card
    const storeCard = async (columnId, event) => {
        // log the card title with jQuery
        const columnElement = $(`#column-${columnId}`);
        const card = columnElement.find('#card-0');
        const cardTitle = card.find('.card-title').text();
        console.log(cardTitle);

        // store the card
        $.ajax({
            url: `/cards`,
            type: 'POST',
            data: {
                title: cardTitle,
                column_id: columnId,
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            success: function(response) {
                console.log(response);
                columnsReload();
                loadColumns();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    // new card
    const newCard = async (columnId, event) => {
        console.log(columnId);

        const columnElement = $(`#column-${columnId}`);

        // check if there is a card with id 0
        const card = columnElement.find('#card-0');
        
        if(card.length > 0) {
            return columnElement.find('.card-title').focus();
        }

        // crate a model html element
        const cardModel = `
            <div class="card mt-2" id="card-${0}">
                <div class="card-header d-flex justify-content-between">
                    <p class="card-header-title">Nova task</p>
                    <div class="card-actions">
                        <a href="#" class="fs-5 text-decoration-none text-danger" onclick="deleteNewCard(${columnId}, event)"><i class="bi bi-x"></i></a>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between gap-2">
                    <p class="card-title p-1 w-75 text-decoration-none text-muted" contenteditable="true" oninput="limitCardTitleLength(event)">Card title</p>
                    <div class="card-actions">
                        <a href="#" class="fs-5 text-decoration-none text-primary" onclick="storeCard(${columnId}, event)"><i class="bi bi-check-lg"></i></a>
                    </div>
                </div>
            </div>
        `;

        columnElement.append(cardModel);
        // add cursor to the card title in text final position
        columnElement.find('.card-title').focus();

        return;
    }

    // delete card
    const onDeleteCard = async (cardId, event) => {
        $('#deleteCardModal').modal('show');
        $('#deleteCardModal').data('data-card-id', cardId);
    }

    // delete new card
    const deleteNewCard = async (columnId, event) => {
        const columnElement = $(`#column-${columnId}`);
        columnElement.find('#card-0').remove();
    }

    // open card
    const openCard = async (cardId, event) => {
        $.ajax({
            url: `/cards/${cardId}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            success: async function(response) {
                await $('#showCardModal #title').val(response.title);
                await $('#showCardModal #description').val(response.description);
                await $('#showCardModal').data('card-id', response.id);
                await $('#showCardModal .column-div-show').html('');

                await $('#showCardModal .column-div-show').append(`
                    <span class="w-100 text-decoration-none text-start fs-6" style="color: ${response.column.color};">
                        <a href="#" class="fs-5 text-decoration-none text-light-gray mt-1" onclick="previousColumn(${cardId}, event)"><i class="bi bi-arrow-left"></i></a>
                        ${response.column.name}
                        <a href="#" class="fs-5 text-decoration-none text-light-gray mt-1" onclick="nextColumn(${cardId}, event)"><i class="bi bi-arrow-right"></i></a>
                    </span>
                `);

                if (response.assigned_user_id) {
                    $('#showCardModal .assigned-user-div').html('');
                    $('#showCardModal .assigned-user-div').append(`
                        <span class="w-100 text-decoration-none text-muted text-start fs-6">
                            <i class="bi bi-person-fill"></i>
                            ${response.assigned_user.name ?? 'Não atribuído'}
                        </span>
                    `);
                }

                $('#showCardModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

        return; 
    }

    // move card to new position or column
    const moveCard = async (cardId, columnId, position) => {
        $.ajax({
            url: `/cards/${cardId}/move`,
            type: 'PUT',
            data: {
                column_id: columnId,
                position: position,
            },

            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            success: function(response) {
                // columnsReload();
                // loadColumns();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    }

    // move column to new position
    const moveColumn = async (columnId, position) => {
        $.ajax({
            url: `/columns/${columnId}/move`,
            type: 'PUT',
            data: {
                position: position,
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            success: function(response) {
                console.log(response);
                columnsReload();
                loadColumns();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    }

    // Inicializa o drag and drop
    const initializeDragAndDrop = () => {
        $('.column-div').draggable({
            axis: 'x', // Restringe o movimento apenas no eixo X (horizontal)
            handle: '.colum-header', // Define o elemento que será usado para arrastar a coluna
            cursor: 'move', // Define o cursor do mouse como uma seta de movimento
            revert: true, // Restringe o movimento apenas no eixo X (horizontal)
            start: function(event, ui) {
                $(this).addClass('dragging'); // Adiciona a classe 'dragging' quando o arrastar começa
            },
            stop: function(event, ui) {
                $(this).removeClass('dragging'); // Remove a classe 'dragging' quando o arrastar termina
            }
        });

        $('.columns-div').droppable({
            accept: '.column-div', // Define que apenas elementos com a classe 'column-div' podem ser soltos
            drop: function(event, ui) {
                const droppedColumn = ui.draggable; // Obtém o elemento que está sendo arrastado
                const targetColumn = $(event.target); // Obtém o elemento alvo onde o elemento arrastado será solto
                
                const columns = $('.column-div').toArray(); // Obtém todos os elementos com a classe 'column-div'
                const newPosition = columns.indexOf(droppedColumn[0]); // Obtém a posição do elemento arrastado na lista de colunas
                
                const columnId = droppedColumn.attr('id').split('-')[1]; // Obtém o ID da coluna arrastada
                moveColumn(columnId, newPosition); // Move a coluna para a nova posição
            }
        });

        // Nova implementação para os cards
        $('.cards-div').sortable({
            connectWith: '.cards-div', // Define que os cards podem ser arrastados entre si
            items: '.card', // Define que apenas elementos com a classe 'card' podem ser arrastados
            handle: '.drag-handle', // Define o elemento que será usado para arrastar o card
            placeholder: 'card-placeholder', // Define o placeholder que será usado para indicar a posição do card
            forcePlaceholderSize: true, // Força o tamanho do placeholder a ser o mesmo do card
            opacity: 0.8, // Define a opacidade do placeholder
            revert: true, // Restringe o movimento apenas no eixo X (horizontal)
            tolerance: 'pointer', // Define a tolerância para o arrastar
            start: function(event, ui) {
                ui.placeholder.height(ui.item.height() * 2); // Define a altura do placeholder
                ui.item.addClass('dragging'); // Adiciona a classe 'dragging' quando o arrastar começa
            },
            stop: function(event, ui) {
                ui.item.removeClass('dragging'); // Remove a classe 'dragging' quando o arrastar termina
            },
            update: function(event, ui) {
                if (!ui.item) return; // Verifica se o item existe
                
                const cardId = ui.item.attr('id').split('-')[1]; // Obtém o ID do card
                const newColumnId = ui.item.closest('.column-div').attr('id').split('-')[1]; // Obtém o ID da coluna onde o card foi solto
                const newPosition = ui.item.index(); // Obtém a posição do card na coluna
                
                moveCard(cardId, newColumnId, newPosition); // Move o card para a nova posição e coluna
            }
        }).disableSelection(); // Desabilita a seleção de texto no card
    };  

    // Edit board
    const onBoardEdit = (event) => {
        event.preventDefault();
        event.stopImmediatePropagation();

        $('#editBoardModal').modal('show');
    }

    // New column
    const onNewColumn = (event) => {
        event.preventDefault();
        event.stopImmediatePropagation();
        
        $('#newColumnModal').modal('show');
    }

</script>

@endsection

{{--  --}}