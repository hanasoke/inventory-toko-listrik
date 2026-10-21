
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Detail Pembelian</h3>
            <p class="text-muted mb-0">
                Faktur: {{ $purchase->invoice_number }}
            </p>
        </div>
        <a href="{{ route('purchases.index') }}"
           class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <strong>Supplier</strong>
                    <div>{{ $purchase->supplier->name }}</div>
                </div>
                <div class="col-md-4">
                    <strong>Tanggal Pembelian</strong>
                    <div>{{ $purchase->purchase_date->format('d-m-Y') }}</div>
                </div>
                <div class="col-md-4">
                    <strong>Petugas</strong>
                    <div>{{ $purchase->user->name }}</div>
                </div>
                <div class="col-12">
                    <strong>Catatan</strong>
                    <div>{{ $purchase->notes ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Barang yang Dibeli</div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-end">Harga Beli</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchase->items as $item)
                        <tr>
                            <td>{{ $item->product->sku }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">
                                Rp{{ number_format((float) $item->unit_price, 2, ',', '.') }}
                            </td>
                            <td class="text-end">
                                Rp{{ number_format((float) $item->subtotal, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total Pembelian</th>
                        <th class="text-end">
                            Rp{{ number_format((float) $purchase->total, 2, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
