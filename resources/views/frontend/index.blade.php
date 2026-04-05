@extends('layouts.app')

@section('content')
    <style>
        .navbar.navbar-expand-md.navbar-light.bg-white.shadow-sm {
            display: none;
        }

        .py-4 {
            padding-top: 0 !important;
        }
    </style>
    <div class="container-fluid p-0">
        <!-- Menu Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('frontend.index') }}">NDPC Blogs</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('frontend.index') }}">Blogs</a>
                        </li>

                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section bg-dark text-white position-relative"
            style="background-image: url('https://via.placeholder.com/1920x600/4a5568/ffffff?text=Blog+Hero+Image'); background-size: cover; background-position: center; height: 60vh;">
            <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-black opacity-50"></div>
            <div class="container h-100 d-flex align-items-center justify-content-center position-relative">
                <div class="text-center">
                    <h1 class="display-4 fw-bold mb-3">Welcome to Our Blog</h1>
                    <p class="lead mb-4">Discover amazing stories, insights, and inspiration from our latest posts.</p>
                    <a href="#blogs" class="btn btn-primary btn-lg">Explore Blogs</a>
                </div>
            </div>
        </section>

        <!-- Blogs Section -->
        <section id="blogs" class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="display-5 fw-bold text-dark">Latest Blogs</h2>
                        <p class="text-muted">Stay updated with our newest articles and posts.</p>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($blogs as $blog)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm border-0">
                                @if (!empty($blog->images))
                                    <img src="{{ $blog->images[0] }}" class="card-img-top" alt="{{ $blog->title_en }}"
                                        style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white"
                                        style="height: 200px;">
                                        <i class="fas fa-image fa-3x"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">{{ $blog->title_en }}</h5>
                                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($blog->description_en, 100) }}
                                    </p>
                                    <div class="mt-auto">
                                        <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                                        @if($blog->slug)
                                            <a href="{{ route('frontend.blog.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm float-end">Read More</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-info">
                                <h4>No blogs available yet.</h4>
                                <p>Check back soon for new content!</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="row mt-5">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        body>nav.navbar {
            display: none;
        }

        .hero-section {
            background-attachment: fixed;
        }

        .overlay {
            z-index: 1;
        }

        .hero-section .container {
            z-index: 2;
        }

        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
    </style>
@endpush
