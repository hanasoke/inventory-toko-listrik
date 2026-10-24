
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Laporan Inventaris</h3>
    <p class="text-muted">Ringkasan kondisi persediaan barang.</p>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted">Jenis Produk</div>
                    <h3>{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted">Total Unit</div>
                    <h3>{{ number_format($totalUnits) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted">Stok Minimum</div>
                    <h3 class="text-danger">{{ $lowStockCount }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted">Estimasi Nilai Stok</div>
                    <h5>
                        Rp{{ number_format((float) $inventoryValue, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Daftar Persediaan</span>
            <button onclick="window.print()"
                    class="btn btn-sm btn-outline-primary">
                Cetak Laporan
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th class="text-end">Stok</th>
                        <th class="text-end">Minimum</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ $product->unit }}</td>
                            <td class="text-end">{{ $product->stock }}</td>
                            <td class="text-end">{{ $product->min_stock }}</td>
                            <td>
                                @if ($product->stock <= $product->min_stock)
                                    <span class="badge text-bg-danger">
                                        Stok menipis
                                    </span>
                                @else
                                    <span class="badge text-bg-success">
                                        Aman
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    nav, .btn, button {
        display: none !important;
    }

    body {
        background: white !important;
    }
}
</style>
@endsection
