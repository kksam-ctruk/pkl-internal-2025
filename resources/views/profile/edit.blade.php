{{-- resources/views/profile/edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <h2 class="h3 fw-bold mb-4 text-dark">
                Profil Saya
            </h2>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- 1. Avatar Information --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">Foto Profil</h6>
                </div>
                <div class="card-body p-4">
                    {{-- @include('profile.partials.update-avatar-form') --}}
                    @include('profile.partials.avatar')
                </div>
            </div>

            {{-- 2. Profile Information --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">Informasi Profil</h6>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- 3. Update Password --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">Update Password</h6>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- 4. Connected Accounts --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">Akun Terhubung</h6>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.connected-accounts')
                </div>
            </div>

            {{-- 5. Delete Account --}}
            <div class="card shadow-sm border-danger mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <h6 class="mb-0 fw-bold">Hapus Akun</h6>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection