<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Conference Management System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }

        .hero-section {
            background-color: #0d6efd;
            padding: 4rem 0;
            color: white;
        }

        .feature-card {
            transition: transform 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .nav-link {
            font-weight: 500;
        }

        .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-calendar-alt me-2"></i>
            Conference Management
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="conferencesDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Conferences
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="conferencesDropdown">
                        <li><a class="dropdown-item" href="{{ route('conferences.index') }}">View All Conferences</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('conferences.create') }}">Add New Conference</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">Manage Users</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('users.create', ['role' => 'admin']) }}">Add
                                Administrator</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.create', ['role' => 'editor']) }}">Add
                                Editor</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Conference Management System</h1>
        <p class="lead mb-4">Efficiently manage your conference events, editors, and schedules in one place.</p>
        <a href="{{ route('conferences.index') }}" class="btn btn-light btn-lg px-4 me-md-2">Get Started</a>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Key Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-3">
                    <div class="card-body text-center">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="card-title">Conference Management</h5>
                        <p class="card-text">Create and manage conferences for different years with details like
                            location, dates, and descriptions.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-3">
                    <div class="card-body text-center">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h5 class="card-title">User Role Management</h5>
                        <p class="card-text">Add and manage administrators and editors with specific permissions and
                            access levels.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-3">
                    <div class="card-body text-center">
                        <div class="feature-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h5 class="card-title">Editor Assignment</h5>
                        <p class="card-text">Assign specific editors to conference years and manage their
                            responsibilities effectively.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="text-center mb-4">Quick Links</h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('conferences.index') }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        View All Conferences
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('conferences.create') }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Add New Conference
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('users.index') }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Users
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>Conference Management System</h5>
                <p class="small">A comprehensive solution for managing conferences, users, and more.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">&copy; {{ date('Y') }} Conference Management. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
