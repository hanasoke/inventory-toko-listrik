
@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <h2>Data Kategori</h2>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    + Tambah Kategori
                </a>
            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="GET" class="row g-2 mb-3">
                <div class="col-sm-8 col-md-5">
                    <input type="search" name="search" class="form-control"
                        placeholder="Cari nama kategori..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary">Cari</button>
                    <a href="{{ route('categories.index') }}"
                        class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Jumlah Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description ?: '-' }}</td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('categories.edit', $category) }}"
                                                class="btn btn-sm btn-warning">Edit</a>

                                            <form method="POST"
                                                action="{{ route('categories.destroy', $category) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
