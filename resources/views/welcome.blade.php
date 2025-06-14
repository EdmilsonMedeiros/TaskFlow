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
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-center mt-1 mb-1">
                        <img src="{{ asset('images/kanban.png') }}" alt="TaskFlow" class="img-fluid rounded-1" style="width: 75%;">
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <a href="/register" class="text-white mt-3 fw-bold fs-5">Cadastrar</a>
                        <div>
                            <a href="/login" class="btn btn-light login-btn-custom text-white">Login</a>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5 mb-5 g-4">
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
