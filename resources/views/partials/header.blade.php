<header class="border-bottom bg-white">
    <div class="container py-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <a
                class="text-decoration-none fw-semibold text-dark"
                href="{{ route('home') }}"
            >
                AmoPoint
            </a>

            @auth
                <form
                    action="{{ route('logout.perform') }}"
                    method="POST"
                >
                    @csrf
                    <button
                        class="btn btn-sm btn-outline-secondary"
                        type="submit"
                    >
                        Выход
                    </button>
                </form>
            @endauth
        </div>
    </div>
</header>
