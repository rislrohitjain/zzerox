@extends('layouts.admin')

@section('title', 'Manage Users & Roles - Zerox Admin')
@section('page_title', 'Users & RBAC Roles')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm bg-white p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-people text-primary me-2"></i> System Users</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Assigned Roles</th>
                            <th>Change Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="fw-bold">{{ $user->name }}</td>
                                <td><code>{{ $user->email }}</code></td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge {{ $role->name === 'admin' ? 'bg-danger' : 'bg-primary' }}">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role_id" class="form-select form-select-sm" style="width: 130px;">
                                            @foreach($roles as $r)
                                                <option value="{{ $r->id }}" {{ $user->hasRole($r->name) ? 'selected' : '' }}>{{ $r->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-dark">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-white p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-person-plus text-primary me-2"></i> Create New Partner Account</h5>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Operator Name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="operator2@zzerox.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Role Assignment</label>
                    <select name="role_id" class="form-select" required>
                        @foreach($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->name }} - {{ $r->description }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> Create User</button>
            </form>
        </div>
    </div>
</div>
@endsection
