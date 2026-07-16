@extends('layouts.guest')

@section('title', 'Admin Login - Kantin Kanvanesa')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h4>Masuk administrator</h4>
        <p>Kelola menu, lihat bobot AHP, dan pantau ranking SAW dari panel admin.</p>
    </div>
    <div class="auth-body">
        @if(session('error'))
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="admin_username">Username admin</label>
                <div class="input-group">
                    <input type="text" name="admin_username" id="admin_username"
                        class="form-control @error('admin_username') is-invalid @enderror"
                        value="{{ old('admin_username') }}"
                        placeholder="Masukkan username" autofocus required>
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    @error('admin_username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label" for="admin_password">Password</label>
                <div class="input-group">
                    <input type="password" name="admin_password" id="admin_password"
                        class="form-control @error('admin_password') is-invalid @enderror"
                        placeholder="Masukkan password" required>
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    @error('admin_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-shield-lock"></i>Masuk sebagai admin
            </button>
        </form>
    </div>
    <div class="auth-footer">
        Panel khusus administrator Kantin Kanvanesa.
    </div>
</div>
@endsection
