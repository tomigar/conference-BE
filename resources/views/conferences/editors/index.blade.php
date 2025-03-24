@extends('layouts.app')

@section('page-title', 'Conference Editors')
@section('page-subtitle', 'Manage editors for ' . $conference->name . ' (' . $conference->year . ')')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Editor Management</h5>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title"><i class="fas fa-info-circle me-2"></i>Conference Details</h6>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p><strong><i class="fas fa-signature me-2"></i>Name:</strong> {{ $conference->name }}</p>
                                        <p><strong><i class="fas fa-calendar-day me-2"></i>Year:</strong> {{ $conference->year }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong><i class="fas fa-map-marker-alt me-2"></i>Location:</strong> {{ $conference->location }}</p>
                                        <p><strong><i class="fas fa-calendar-check me-2"></i>Dates:</strong> {{ $conference->start_date->format('M d, Y') }} - {{ $conference->end_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="mb-3"><i class="fas fa-user-check me-2"></i>Assigned Editors</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-user me-1"></i> Name</th>
                                    <th><i class="fas fa-envelope me-1"></i> Email</th>
                                    <th><i class="fas fa-calendar me-1"></i> Assigned On</th>
                                    <th><i class="fas fa-tools me-1"></i> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($editors as $editor)
                                    <tr>
                                        <td>{{ $editor->name }}</td>
                                        <td>{{ $editor->email }}</td>
                                        <td>{{ $editor->pivot->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <form action="{{ route('conferences.editors.destroy', ['conference' => $conference, 'editor' => $editor]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this editor from the conference?')">
                                                    <i class="fas fa-user-minus me-1"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-users-slash fa-3x mb-3 text-muted"></i>
                                            <p class="text-muted">No editors assigned to this conference yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title mb-3"><i class="fas fa-user-plus me-2"></i>Assign New Editor</h6>
                                @if(count($availableEditors) > 0)
                                    <form method="POST" action="{{ route('conferences.editors.store', $conference) }}" class="mb-0">
                                        @csrf
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-8">
                                                <label for="editor_id" class="form-label">Select Editor</label>
                                                <select class="form-select @error('editor_id') is-invalid @enderror" id="editor_id" name="editor_id" required>
                                                    <option value="">Choose an editor...</option>
                                                    @foreach($availableEditors as $editor)
                                                        <option value="{{ $editor->id }}">{{ $editor->name }} ({{ $editor->email }})</option>
                                                    @endforeach
                                                </select>
                                                @error('editor_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-plus-circle me-1"></i> Assign Editor
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        All available editors have been assigned to this conference or there are no editors created yet.
                                        <a href="{{ route('users.create', ['role' => 'editor']) }}" class="alert-link">
                                            <i class="fas fa-plus-circle me-1"></i> Add a new editor
                                        </a>.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('conferences.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Conferences
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
