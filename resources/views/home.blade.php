@extends('layouts.app')

@section('title', config('app.name', 'Laravel'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="row g-3">
                <div class="col-md-6 col-xl-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="h6 text-uppercase text-secondary">Блок 1</h2>
                            <p class="mb-3">API-список персонажей.</p>
                            <a
                                class="btn btn-sm btn-outline-primary"
                                href="{{ route('characters') }}"
                            >
                                Открыть
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="h6 text-uppercase text-secondary">Блок 2</h2>
                            <p class="mb-3">Форма с динамической фильтрацией полей.</p>
                            <a
                                class="btn btn-sm btn-outline-primary"
                                href="{{ route('testlist') }}"
                            >
                                Открыть
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="h6 text-uppercase text-secondary">Блок 3</h2>
                            <p class="mb-3">Часовые визиты и распределение по городам.</p>
                            <a
                                class="btn btn-sm btn-outline-primary"
                                href="{{ route('statistics.index') }}"
                            >
                                Открыть
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
