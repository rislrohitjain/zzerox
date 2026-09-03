@extends('layouts.app')

@section('title', 'Partner Login | Zerox – Pharmaceuticals')

@section('content')
<section class="banner" style="min-height: 100px; background: #0f172a; color: #fff; padding: 35px 0;">
    <div class="container text-center">
        <h1 style="font-size: 26px; font-weight: 700; color: #c9a227; margin: 0;">Partner & Management Login</h1>
    </div>
</section>

<div class="container" style="padding: 60px 15px;">
    <div class="row" style="display: flex; justify-content: center;">
        <div class="col-md-5 col-xs-12">
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <img src="{{ asset(\App\Models\SiteSetting::get('site_logo_header', \App\Models\SiteSetting::get('site_logo', 'img/logo.png'))) }}" alt="Zerox" style="max-height: 50px; margin-bottom: 15px;">
                    <h2 style="font-size: 22px; font-weight: 700; color: #111; margin: 0 0 5px 0;">Portal Sign In</h2>
                    <p style="color: #666; font-size: 13px; margin: 0;">Enter your credentials to access Zerox administration panel.</p>
                </div>

                @if($errors->any())
                    <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 15px; border-radius: 6px; font-size: 13px; margin-bottom: 20px;">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #333; margin-bottom: 6px;">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@zzerox.com" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; outline: none;" onfocus="this.style.borderColor='#c9a227';" onblur="this.style.borderColor='#ccc';">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #333; margin-bottom: 6px;">Password</label>
                        <input type="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; outline: none;" onfocus="this.style.borderColor='#c9a227';" onblur="this.style.borderColor='#ccc';">
                    </div>

                    <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="remember" id="remember" style="width: 16px; height: 16px;">
                        <label for="remember" style="font-size: 13px; color: #555; margin: 0; cursor: pointer;">Remember login session</label>
                    </div>

                    <button type="submit" style="width: 100%; background: #c9a227; color: #000; font-weight: 700; font-size: 15px; padding: 12px; border: none; border-radius: 4px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#b89320';" onmouseout="this.style.background='#c9a227';">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Dashboard
                    </button>
                </form>

                <div style="margin-top: 30px; background: #f8f9fa; border: 1px solid #eee; border-radius: 6px; padding: 15px; font-size: 12px; color: #555; text-align: center;">
                    <div style="font-weight: 700; color: #333; margin-bottom: 5px;">Demo System Credentials:</div>
                    <div>Admin: <strong style="color: #000;">admin@zzerox.com</strong> / <code style="background: #e2e8f0; padding: 2px 5px; border-radius: 3px;">AdminPass@2026</code></div>
                    <div style="margin-top: 3px;">Operator: <strong style="color: #000;">operator@zzerox.com</strong> / <code style="background: #e2e8f0; padding: 2px 5px; border-radius: 3px;">OperatorPass@2026</code></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
