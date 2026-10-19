@extends('layouts.app')

@section('title', 'Data Produk')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <h2>Data Produk Alat Listrik</h2>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    + Tambah Produk
                </a>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="GET" class="row g-2 mb-3">
                <div class="col-12 col-md-5">
                    <input type="search" name="search" class="form-control"
                        placeholder="Cari kode, nama, atau kategori..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-8 col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected((string) request('category_id') === (string) $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary">Filter</button>
                    <a href="{{ route('products.index') }}"
                        class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $loop->index }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>Rp {{ number_format((float) $product->purchase_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}</td>
                                    <td>{{ number_format($product->stock) }} {{ $product->unit }}</td>
                                    <td>
                                        @if ($product->stock <= $product->min_stock)
                                            <span class="badge text-bg-danger">Stok Menipis</span>
                                        @else
                                            <span class="badge text-bg-success">Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="btn btn-sm btn-warning">Edit</a>

                                            <form method="POST"
                                                action="{{ route('products.destroy', $product) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                                    <td colspan="9" class="text-center py-4">
                                        Produk tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
