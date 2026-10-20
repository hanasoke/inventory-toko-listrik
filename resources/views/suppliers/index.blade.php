
@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h2 class="mb-1">Data Supplier</h2>
        <p class="text-secondary mb-0">
            Kelola data pemasok toko alat listrik.
        </p>
    </div>

    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        + Tambah Supplier
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="GET" action="{{ route('suppliers.index') }}"
    class="row g-2 mb-3">
    <div class="col-12 col-md-6">
        <input type="search" name="search"
            class="form-control"
            placeholder="Cari kode, nama, telepon, atau email..."
            value="{{ request('search') }}">
    </div>

    <div class="col-auto">
        <button class="btn btn-outline-primary">Cari</button>
        <a href="{{ route('suppliers.index') }}"
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
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td>{{ $supplier->code }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact_person ?: '-' }}</td>
                        <td>{{ $supplier->phone ?: '-' }}</td>
                        <td>{{ $supplier->email ?: '-' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form method="POST"
                                    action="{{ route('suppliers.destroy', $supplier) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Data supplier belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $suppliers->links() }}
</div>
@endsection
