@extends('app')

@section('content')
<div class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="logo mb-3"><i class="bi bi-kanban"></i> TaskFlow</h1>
                <p class="subtitle mb-4">Gestor de Tarefas Kanban</p>
                <p class="description mb-5" style="font-size: 14px;">
                    Organize suas tarefas de forma visual e eficiente. Gerencie projetos, 
                    acompanhe o progresso e colabore com sua equipe usando o método Kanban.
                </p>
                <div class="justify-content-center align-items-center">
                    <div class="d-flex justify-content-center align-items-center gap-5">
                        <a href="/register" class="text-white fw-bold fs-5">Cadastrar-se</a>
                        <div>
                            <a href="/login" class="btn btn-light login-btn-custom text-white">Fazer Login</a>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-0 mb-5 g-4">
                    <div class="col-md-4">
                        <div class="card feature-card h-100 p-4 text-center">
                            <div class="card-body">
                                <div class="feature-icon mb-3">📋</div>
                                <h5 class="card-title">Organização Visual</h5>
                                <p class="card-text opacity-75">Quadros Kanban intuitivos para visualizar o fluxo de trabalho</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card h-100 p-4 text-center">
                            <div class="card-body">
                                <div class="feature-icon mb-3">👥</div>
                                <h5 class="card-title">Colaboração</h5>
                                <p class="card-text opacity-75">Trabalhe em equipe com atribuição de tarefas</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card feature-card h-100 p-4 text-center">
                            <div class="card-body">
                                <div class="feature-icon mb-3">📊</div>
                                <h5 class="card-title">Acompanhamento</h5>
                                <p class="card-text opacity-75">Monitore o progresso dos projetos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
