
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Laporan Pembelian</h3>
    <p class="text-muted">
        Filter transaksi berdasarkan tanggal dan supplier.
    </p>

    <form method="GET"
          action="{{ route('reports.purchases') }}"
          class="card card-body mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date"
                       name="start_date"
                       value="{{ request('start_date') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date"
                       name="end_date"
                       value="{{ request('end_date') }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Supplier</label>
                <select name="supplier_id" class="form-select">
                    <option value="">Semua supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            @selected(request('supplier_id') == $supplier->id)>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('reports.purchases') }}"
                   class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="card mb-3">
        <div class="card-body">
            <div class="text-muted">Total pembelian sesuai filter</div>
            <h4>
                Rp{{ number_format((float) $totalPurchase, 0, ',', '.') }}
            </h4>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Daftar Transaksi Pembelian</span>
            <button onclick="window.print()"
                    class="btn btn-sm btn-outline-primary">
                Cetak Laporan
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Faktur</th>
                        <th>Supplier</th>
                        <th>Petugas</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->purchase_date->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('purchases.show', $purchase) }}">
                                    {{ $purchase->invoice_number }}
                                </a>
                            </td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>{{ $purchase->user->name }}</td>
                            <td class="text-end">
                                Rp{{ number_format((float) $purchase->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada transaksi pada filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $purchases->links() }}
    </div>
</div>

<style>
@media print {
    nav, form, .btn, button {
        display: none !important;
    }

    body {
        background: white !important;
    }
}
</style>
@endsection
