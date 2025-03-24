@extends('layouts.app')

@section('page-title', 'Conference Management')
@section('page-subtitle', 'View and manage all conference years')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Conference Years</h5>
                        <div>
                            <a href="{{ route('users.index') }}" class="btn btn-info btn-sm me-2">
                                <i class="fas fa-users me-1"></i> Manage Users
                            </a>
                            <a href="{{ route('conferences.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Add New Conference Year
                            </a>
                        </div>
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
                                    <th><i class="fas fa-calendar-day me-1"></i> Year</th>
                                    <th><i class="fas fa-signature me-1"></i> Name</th>
                                    <th><i class="fas fa-clock me-1"></i> Date Range</th>
                                    <th><i class="fas fa-map-marker-alt me-1"></i> Location</th>
                                    <th><i class="fas fa-check-circle me-1"></i> Status</th>
                                    <th><i class="fas fa-users-cog me-1"></i> Editors</th>
                                    <th><i class="fas fa-tools me-1"></i> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($conferences as $conference)
                                    <tr>
                                        <td>{{ $conference->year }}</td>
                                        <td>{{ $conference->name }}</td>
                                        <td>{{ $conference->start_date->format('M d, Y') }} - {{ $conference->end_date->format('M d, Y') }}</td>
                                        <td>{{ $conference->location }}</td>
                                        <td>
                                            <span class="badge bg-{{ $conference->is_active ? 'success' : 'secondary' }}">
                                                {{ $conference->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('conferences.editors.index', $conference) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-user-edit me-1"></i> Manage Editors
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('conferences.edit', $conference) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <form action="{{ route('conferences.destroy', $conference) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this conference year?')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i>
                                            <p class="text-muted">No conferences found. Start by adding a new conference year.</p>
                                            <a href="{{ route('conferences.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i> Add Conference Year
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
