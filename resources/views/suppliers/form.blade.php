
@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="mb-4">{{ $pageTitle }}</h3>

                <form method="POST"
                    action="{{ $supplier->exists
                        ? route('suppliers.update', $supplier)
                        : route('suppliers.store') }}">
                    @csrf

                    @if ($supplier->exists)
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode Supplier</label>
                            <input type="text" name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $supplier->code) }}"
                                maxlength="30" required>

                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $supplier->name) }}"
                                maxlength="150" required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Kontak</label>
                            <input type="text" name="contact_person"
                                class="form-control @error('contact_person') is-invalid @enderror"
                                value="{{ old('contact_person', $supplier->contact_person) }}"
                                maxlength="100">

                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $supplier->phone) }}"
                                maxlength="30">

                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $supplier->email) }}"
                                maxlength="150">

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Supplier</label>
                            <textarea name="address" rows="4"
                                class="form-control @error('address') is-invalid @enderror"
                                placeholder="Masukkan alamat pemasok">{{ old('address', $supplier->address) }}</textarea>

                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <button type="submit" class="btn btn-primary">
                        Simpan Supplier
                    </button>

                    <a href="{{ route('suppliers.index') }}"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
