@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Conference: {{ $conference->name }}</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('conferences.update', $conference) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', $conference->year) }}" required min="2000">
                                @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Conference Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $conference->name) }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $conference->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $conference->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $conference->location) }}" required>
                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $conference->description) }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $conference->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('conferences.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Conference</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
