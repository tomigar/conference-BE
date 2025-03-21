@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Conference Years</h5>
                        <a href="{{ route('conferences.create') }}" class="btn btn-primary btn-sm">Add New Conference Year</a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Year</th>
                                <th>Name</th>
                                <th>Date Range</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
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
                                        <a href="{{ route('conferences.edit', $conference) }}" class="btn btn-sm btn-info">Edit</a>

                                        <form action="{{ route('conferences.destroy', $conference) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this conference year?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No conferences found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
