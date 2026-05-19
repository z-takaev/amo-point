<header class="border-bottom bg-white">
    <div class="container py-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <a
                href="{{ route('home') }}"
                class="text-decoration-none fw-semibold text-dark"
            >
                AmoPoint
            </a>

            @auth
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf
                    <button
                        type="submit"
                        class="btn btn-sm btn-outline-secondary"
                    >
                        Выход
                    </button>
                </form>
            @endauth
        </div>
    </div>
</header>
