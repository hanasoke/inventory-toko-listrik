
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventory Toko Listrik')</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            Light Tools
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('products.index') }}">
                    Barang
                </a>
                <a class="nav-link" href="{{ route('categories.index') }}">
                    Kategori
                </a>
                <a class="nav-link" href="{{ route('stock-movements.index') }}">
                    Transaksi Stok
                </a>
                <a class="nav-link" href="{{ route('suppliers.index') }}">
                    Supplier
                </a>
            </div>

            <div class="ms-auto text-white">
                {{ auth()->user()->name }}
                <form method="POST" action="{{ route('logout') }}"
                    class="d-inline">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="container-fluid py-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
