@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <p class="text-uppercase text-secondary small mb-2">Авторизация</p>
                        <h1 class="h3 fw-semibold mb-2">Вход в панель</h1>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form
                        action="{{ route('login.perform') }}"
                        method="POST"
                    >
                        @csrf

                        <div class="mb-3">
                            <label
                                class="form-label"
                                for="email"
                            >
                                Email
                            </label>
                            <input
                                id="email"
                                class="form-control"
                                type="email"
                                name="email"
                                value="{{ old('email', config('dashboard.admin.email')) }}"
                                autocomplete="email"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label
                                class="form-label"
                                for="password"
                            >
                                Пароль
                            </label>
                            <input
                                id="password"
                                class="form-control"
                                type="password"
                                name="password"
                                value="{{ old('password', config('dashboard.admin.password')) }}"
                                autocomplete="current-password"
                                required
                            >
                        </div>

                        <button
                            class="btn btn-primary w-100"
                            type="submit"
                        >
                            Войти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
