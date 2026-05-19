@extends('layouts.app')

@section('title', 'Статистика')

@section('content')
    @php
        $hourlyLabels = $hourlyLabels ?? [];
        $hourlyValues = $hourlyValues ?? [];
        $cityLabels = $cityLabels ?? [];
        $cityValues = $cityValues ?? [];
    @endphp

    <h1 class="h3 fw-semibold mb-4">Статистика посещений</h1>

    <div class="row g-3">
        <div class="col-12 col-lg-7">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Уникальные визиты по часам</h2>

                    <div class="ratio ratio-16x9" style="min-height: 320px;">
                        <canvas id="hourly-visits-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Распределение по городам</h2>

                    <div class="ratio ratio-1x1" style="min-height: 320px;">
                        <canvas id="city-distribution-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            (() => {
                const hourlyLabels = @json($hourlyLabels);
                const hourlyValues = @json($hourlyValues);
                const cityLabels = @json($cityLabels);
                const cityValues = @json($cityValues);
                const hourlyCanvas = document.getElementById('hourly-visits-chart');
                const cityCanvas = document.getElementById('city-distribution-chart');

                const safeLabels = Array.isArray(hourlyLabels) ? hourlyLabels.map(toLabel) : [];
                const safeHourlyValues = Array.isArray(hourlyValues) ? hourlyValues.map(toNumber) : [];
                const safeCityLabels = Array.isArray(cityLabels) ? cityLabels.map(toLabel) : [];
                const safeCityValues = Array.isArray(cityValues) ? cityValues.map(toNumber) : [];

                if (safeLabels.length > 0 && window.Chart) {
                    new Chart(hourlyCanvas, {
                        type: 'line',
                        data: {
                            labels: safeLabels,
                            datasets: [
                                {
                                    label: 'Уникальные визиты',
                                    data: safeHourlyValues,
                                    borderColor: '#0d6efd',
                                    backgroundColor: 'rgba(13, 110, 253, 0.12)',
                                    fill: true,
                                    tension: 0.35,
                                    pointRadius: 3,
                                    pointBackgroundColor: '#0d6efd',
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0,
                                    },
                                },
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                },
                            },
                        },
                    });
                }

                if (safeCityLabels.length > 0 && window.Chart) {
                    new Chart(cityCanvas, {
                        type: 'pie',
                        data: {
                            labels: safeCityLabels,
                            datasets: [
                                {
                                    data: safeCityValues,
                                    backgroundColor: [
                                        '#0d6efd',
                                        '#198754',
                                        '#fd7e14',
                                        '#dc3545',
                                        '#6f42c1',
                                        '#20c997',
                                        '#0dcaf0',
                                        '#ffc107',
                                    ],
                                    borderColor: '#ffffff',
                                    borderWidth: 2,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        },
                    });
                }

                function toLabel(value) {
                    return String(value ?? '').trim();
                }

                function toNumber(value) {
                    return Number(value ?? 0);
                }
            })();
        </script>
    @endpush
@endsection
