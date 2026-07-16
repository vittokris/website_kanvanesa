@extends('layouts.guest')

@section('title', 'Daftar Akun - Kantin Kanvanesa')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h4>Buat akun penilai</h4>
        <p>Gunakan satu akun untuk menilai menu berdasarkan rasa, tampilan, harga, porsi, dan gizi.</p>
    </div>
    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="user_name">Nama lengkap</label>
                <div class="input-group">
                    <input type="text" name="user_name" id="user_name"
                        class="form-control @error('user_name') is-invalid @enderror"
                        value="{{ old('user_name') }}"
                        placeholder="Contoh: Ahmad Fauzi" required autofocus>
                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="user_username">Username</label>
                <div class="input-group">
                    <input type="text" name="user_username" id="user_username"
                        class="form-control @error('user_username') is-invalid @enderror"
                        value="{{ old('user_username') }}"
                        placeholder="Contoh: ahmad123" required>
                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                    @error('user_username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="user_password">Password</label>
                <div class="input-group">
                    <input type="password" name="user_password" id="user_password"
                        class="form-control @error('user_password') is-invalid @enderror"
                        placeholder="Minimal 6 karakter" required>
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    @error('user_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label" for="user_password_confirmation">Konfirmasi password</label>
                <div class="input-group">
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password" required>
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                </div>
            </div>

            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-person-check"></i>Daftar
            </button>
        </form>
    </div>
    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </div>
</div>
@endsection
