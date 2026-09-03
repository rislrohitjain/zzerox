@extends('layouts.admin')

@section('title', 'My Profile & Account Settings - Zerox Admin')
@section('page_title', 'My Admin Profile & Preferences')

@section('content')
<div class="row g-4">
    <!-- Left Column: User Profile Overview Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-white p-4 text-center">
            <div class="position-relative d-inline-block mx-auto mb-3">
                @if($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle border border-3 border-primary shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto border border-2 border-primary" style="width: 120px; height: 120px; font-size: 3rem; font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <h4 class="fw-bold text-dark m-0">{{ $user->name }}</h4>
            <small class="text-primary fw-bold d-block mb-2">{{ $user->designation ?? 'Zerox Administrator' }}</small>
            
            <div class="mb-3">
                @foreach($user->roles as $role)
                    <span class="badge {{ $role->name === 'admin' ? 'bg-danger' : 'bg-primary' }} text-uppercase px-3 py-1">{{ $role->name }}</span>
                @endforeach
            </div>

            <p class="text-muted small mb-3">{{ $user->bio ?? 'No bio summary added yet.' }}</p>

            <ul class="list-group list-group-flush text-start small mb-3">
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <span class="text-muted"><i class="bi bi-envelope me-2 text-primary"></i> Email:</span>
                    <strong class="text-dark">{{ $user->email }}</strong>
                </li>
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <span class="text-muted"><i class="bi bi-telephone me-2 text-success"></i> Phone / Mobile:</span>
                    <strong class="text-dark">{{ $user->phone ?? 'Not set' }}</strong>
                </li>
            </ul>

            <!-- Social Links Badges -->
            <div class="d-flex justify-content-center gap-2 pt-2 border-top">
                @if($user->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->whatsapp) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-circle" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                @endif
                @if($user->linkedin)
                    <a href="{{ $user->linkedin }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                @endif
                @if($user->twitter)
                    <a href="https://twitter.com/{{ ltrim($user->twitter, '@') }}" target="_blank" class="btn btn-sm btn-outline-info rounded-circle" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                @endif
                @if($user->telegram)
                    <a href="https://t.me/{{ ltrim($user->telegram, '@') }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" title="Telegram"><i class="bi bi-telegram"></i></a>
                @endif
                @if($user->facebook)
                    <a href="{{ $user->facebook }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" title="Facebook"><i class="bi bi-facebook"></i></a>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Profile Edit Form Tabs -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm bg-white p-4">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <ul class="nav nav-tabs fw-bold mb-4" id="profileTabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#basicTab"><i class="bi bi-person me-1"></i> Personal & Mobile Info</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#photoTab"><i class="bi bi-camera me-1"></i> Profile Photo Avatar</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#socialTab"><i class="bi bi-share me-1 text-info"></i> Social Networks</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#securityTab"><i class="bi bi-shield-lock me-1 text-danger"></i> Password & Security</a></li>
                </ul>

                <div class="tab-content" id="profileTabContent">
                    <!-- Tab 1: Personal & Mobile Info -->
                    <div class="tab-pane fade show active" id="basicTab">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bi bi-telephone text-success me-1"></i> Mobile / Telephone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="+91 98765 43210" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bi bi-briefcase text-primary me-1"></i> Designation / Job Title</label>
                                <input type="text" name="designation" class="form-control" placeholder="e.g. Senior Admin Officer" value="{{ old('designation', $user->designation) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Short Bio Summary</label>
                                <textarea name="bio" rows="3" class="form-control" placeholder="Write a short summary about your role and responsibilities...">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Profile Photo Avatar -->
                    <div class="tab-pane fade" id="photoTab">
                        <div class="p-3 border rounded bg-light mb-3 text-center">
                            <label class="form-label fw-bold d-block mb-2"><i class="bi bi-image text-primary me-1"></i> Upload Profile Photo Real Avatar</label>
                            <input type="file" name="avatar" class="form-control mb-3" accept="image/*">
                            <small class="text-muted d-block">Supported formats: JPG, PNG, WEBP. Max size: 5MB.</small>
                        </div>
                    </div>

                    <!-- Tab 3: Social Media Links -->
                    <div class="tab-pane fade" id="socialTab">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bi bi-whatsapp text-success me-1"></i> WhatsApp Mobile Number</label>
                                <input type="text" name="whatsapp" class="form-control" placeholder="+91 98765 43210" value="{{ old('whatsapp', $user->whatsapp) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bi bi-linkedin text-primary me-1"></i> LinkedIn Profile URL</label>
                                <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin', $user->linkedin) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bi bi-twitter-x text-dark me-1"></i> Twitter / X Handle</label>
                                <input type="text" name="twitter" class="form-control" placeholder="@username" value="{{ old('twitter', $user->twitter) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="bi bi-telegram text-info me-1"></i> Telegram Username</label>
                                <input type="text" name="telegram" class="form-control" placeholder="@username" value="{{ old('telegram', $user->telegram) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold"><i class="bi bi-facebook text-primary me-1"></i> Facebook Profile URL</label>
                                <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/username" value="{{ old('facebook', $user->facebook) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Password & Security -->
                    <div class="tab-pane fade" id="securityTab">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Current Password</label>
                                <input type="password" name="current_password" class="form-control" placeholder="••••••••">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="••••••••">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Save Profile Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
