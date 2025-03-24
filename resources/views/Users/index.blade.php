@extends('layouts.app')

@section('page-title', 'User Management')
@section('page-subtitle', 'Manage administrators and editors')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Administrators Section -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Administrators</h5>
                        <a href="{{ route('users.create', ['role' => 'admin']) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add New Administrator
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-user me-1"></i> Name</th>
                                    <th><i class="fas fa-envelope me-1"></i> Email</th>
                                    <th><i class="fas fa-calendar me-1"></i> Created At</th>
                                    <th><i class="fas fa-tools me-1"></i> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <form action="{{ route('users.destroy', $admin) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this administrator?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-user-slash fa-3x mb-3 text-muted"></i>
                                            <p class="text-muted">No administrators found. Add one to get started.</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Editors Section -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editors</h5>
                        <a href="{{ route('users.create', ['role' => 'editor']) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add New Editor
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-user me-1"></i> Name</th>
                                    <th><i class="fas fa-envelope me-1"></i> Email</th>
                                    <th><i class="fas fa-calendar me-1"></i> Created At</th>
                                    <th><i class="fas fa-tools me-1"></i> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($editors as $editor)
                                    <tr>
                                        <td>{{ $editor->name }}</td>
                                        <td>{{ $editor->email }}</td>
                                        <td>{{ $editor->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <form action="{{ route('users.destroy', $editor) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this editor?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-user-slash fa-3x mb-3 text-muted"></i>
                                            <p class="text-muted">No editors found. Add one to get started.</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('conferences.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Conferences
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
