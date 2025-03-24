@extends('layouts.app')

@section('page-title', 'Add New ' . ucfirst($role))
@section('page-subtitle', 'Create a new ' . $role . ' account')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            @if($role == 'admin')
                                <i class="fas fa-user-shield me-2"></i>
                            @else
                                <i class="fas fa-user-edit me-2"></i>
                            @endif
                            Add New {{ ucfirst($role) }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf

                            <input type="hidden" name="role" value="{{ $role }}">

                            <div class="mb-3">
                                <label for="name" class="form-label"><i class="fas fa-user me-1"></i> Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fas fa-envelope me-1"></i> Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label"><i class="fas fa-lock me-1"></i> Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i> Password should be at least 8 characters long.
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-1"></i> Add {{ ucfirst($role) }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
