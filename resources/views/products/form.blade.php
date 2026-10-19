@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h3 class="mb-4">{{ $pageTitle }}</h3>

                @if ($categories->isEmpty())
                    <div class="alert alert-warning">
                        Tambahkan kategori terlebih dahulu sebelum membuat produk.
                        <a href="{{ route('categories.create') }}">Buat kategori</a>
                    </div>
                @else
                    <form method="POST"
                        action="{{ $product->exists
                            ? route('products.update', $product)
                            : route('products.store') }}">
                        @csrf

                        @if ($product->exists)
                            @method('PUT')
                        @endif

                        @include('products._fields')

                        <button class="btn btn-primary">Simpan Produk</button>
                        <a href="{{ route('products.index') }}"
                            class="btn btn-secondary">Kembali</a>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
