@extends('app')

@section('content')
    <div class="container d-flex align-items-center" style="min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="justify-content-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 p-5">
                <h4 class="mb-0 text-white fs-1"><i class="bi bi-kanban"></i> Cadastro TaskFlow</h4>
                <p class="text-white fs-6">Crie sua conta para continuar</p>

                <div class="d-none d-lg-flex align-items-center" style="margin-top: 0px;">
                    <img src="{{ asset('images/kanban.png') }}" alt="TaskFlow" class="img-fluid rounded-2" style="margin-right: -200px;">
                    <img src="{{ asset('images/kanban2.png') }}" alt="TaskFlow" class="img-fluid rounded-2" style="width: 80%; margin-top: 300px; margin-left: -200px;">
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="card p-5">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmação de Senha</label>
                                <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('login') }}" class="text-dark mt-2">Já tem uma conta? <br><b>Entrar</b></a>
                                <button type="submit" class="btn btn-outline-primary btn-lg">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection