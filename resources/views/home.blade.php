{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama website (Statis)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">
                        Belanja Online Mudah & Terpercaya
                    </h1>
                    <p class="lead mb-4">
                        Temukan berbagai produk berkualitas dengan harga terbaik.
                        Gratis ongkir untuk pembelian pertama!
                    </p>
                    <a href="#" class="btn btn-light btn-lg">
                        <i class="bi bi-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="https://via.placeholder.com/400"
                         alt="Shopping" class="img-fluid" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Kategori Populer</h2>
            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center h-100">
                            <div class="card-body">
                                <img src="https://via.placeholder.com/80"
                                     alt="Category"
                                     class="rounded-circle mb-3"
                                     width="80" height="80"
                                     style="object-fit: cover;">
                                <h6 class="card-title mb-0">Nama Kategori</h6>
                                <small class="text-muted">0 produk</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Produk Unggulan</h2>
                <a href="#" class="btn btn-outline-primary">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Nama Produk</h5>
                            <p class="card-text text-primary fw-bold">Rp 0</p>
                            <a href="#" class="btn btn-primary btn-sm w-100">Tambah ke Keranjang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Promo Banner --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card bg-warning text-dark border-0" style="min-height: 200px;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3>Flash Sale!</h3>
                            <p>Diskon hingga 50% untuk produk pilihan</p>
                            <a href="#" class="btn btn-dark" style="width: fit-content;">
                                Lihat Promo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-info text-white border-0" style="min-height: 200px;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3>Member Baru?</h3>
                            <p>Dapatkan voucher Rp 50.000 untuk pembelian pertama</p>
                            <a href="#" class="btn btn-light" style="width: fit-content;">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Terbaru --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Produk Terbaru</h2>
            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Nama Produk Baru</h5>
                            <p class="card-text text-primary fw-bold">Rp 0</p>
                            <a href="#" class="btn btn-primary btn-sm w-100">Tambah ke Keranjang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection