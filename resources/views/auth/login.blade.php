@extends('app')

@section('content')
    <div class="container d-flex align-items-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="justify-content-center col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 p-5">
                <h4 class="mb-0 text-white fs-1"><i class="bi bi-kanban"></i> Login TaskFlow</h4>
                <p class="text-white fs-6">Faça login para continuar</p>
            </div>
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-5">
                <div class="card p-2">
                    <div class="card-body">
                        
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
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
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('register') }}" class="text-dark mt-2">Cadastrar</a>
                                <button type="submit" class="btn btn-outline-primary btn-lg">Entrar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection