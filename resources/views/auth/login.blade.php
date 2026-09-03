@extends('layouts.app')

@section('title', 'Login - Zerox Pharmaceuticals Admin & Operator Portal')

@section('content')
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-zx border-0 shadow-lg p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock-fill text-info display-4 mb-2"></i>
                        <h3 class="fw-bold">Partner Login</h3>
                        <p class="text-muted small">Access Zerox management dashboard</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger p-2 small mb-3">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg" placeholder="admin@zzerox.com" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label text-muted small" for="remember">Remember login session</label>
                        </div>

                        <button type="submit" class="btn btn-auth-check btn-lg w-100 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                        </button>
                    </form>

                    <div class="mt-4 p-3 bg-light rounded text-center small text-muted">
                        <div><strong>Demo Credentials:</strong></div>
                        <div>Admin: <code>admin@zzerox.com</code> / <code>AdminPass@2026</code></div>
                        <div>Operator: <code>operator@zzerox.com</code> / <code>OperatorPass@2026</code></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
