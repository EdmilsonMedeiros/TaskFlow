@extends('app._layout.index')

@section('content')
<div class="container-fluid p-5">
    <div class="row border-bottom border-1 mb-4">
        <div class="col-6">
            <div class="d-flex gap-3">
                <h3 class="text-start board-name">Perfil</h3>
            </div>
            <p class="text-muted board-description">Atualize suas informações de perfil</p>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> </a>
            </div>
        </div>
    </div>

    <div class="justify-content-start gap-2 col-12 col-xs-12 col-md-6">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input class="form-control form-control-lg" type="text" name="name" value="{{ auth()->user()->name }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control form-control-lg" type="email" name="email" value="{{ auth()->user()->email }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input class="form-control form-control-lg" type="password" name="password" value="">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                <input class="form-control form-control-lg" type="password" name="password_confirmation" value="">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-pencil-square"></i> Atualizar</button>
        </form>
    </div>

</div>
@endsection
