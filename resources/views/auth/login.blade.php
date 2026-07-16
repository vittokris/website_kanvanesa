@extends('layouts.guest')

@section('title', 'Login - Kantin Kanvanesa')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h4>Masuk pengguna</h4>
        <p>Lanjutkan untuk memberi penilaian dan melihat ranking menu terbaru.</p>
    </div>
    <div class="auth-body">
        @if(session('error'))
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="user_username">Username</label>
                <div class="input-group">
                    <input type="text" name="user_username" id="user_username"
                        class="form-control @error('user_username') is-invalid @enderror"
                        value="{{ old('user_username') }}"
                        placeholder="Masukkan username" autofocus required>
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    @error('user_username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label" for="user_password">Password</label>
                <div class="input-group">
                    <input type="password" name="user_password" id="user_password"
                        class="form-control @error('user_password') is-invalid @enderror"
                        placeholder="Masukkan password" required>
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    @error('user_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-box-arrow-in-right"></i>Masuk
            </button>
        </form>
    </div>
    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</div>
@endsection
