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
                            <a class="nav-link" href="{{ route('frontend.index') }}">Blogs</a>
                        </li>

                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <button onclick="toggleLang('en')">EN</button>
                            <button onclick="toggleLang('np')">NP</button>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <!-- Blog Detail Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <article class="blog-post">
                            <!-- Blog Images -->
                            @if (!empty($blog->images))
                                <div class="mb-4">
                                    <div class="row g-2">
                                        @foreach ($blog->images as $image)
                                            <div class="col-md-12">
                                                <img src="{{ $image }}" class="img-fluid rounded shadow-sm"
                                                    alt="Blog Image">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Blog Title -->
                            <h1 id="en-text" class="display-5 fw-bold text-dark mb-3">{{ $blog->title_en }}</h1>
                            <h2 id="np-text" class="display-6 fw-bold text-secondary mb-4" style="display: none;">{{ $blog->title_np }}</h2>
                          


                            <!-- Meta Information -->
                            <div class="d-flex align-items-center mb-4 text-muted">
                                <span class="me-3"><i class="fas fa-user"></i> By Admin</span>
                                <span class="me-3"><i class="fas fa-calendar"></i>
                                    {{ $blog->created_at->format('M d, Y') }}</span>
                               
                            </div>

                            <!-- Blog Description -->
                            <div class="blog-content">
                                <p id="en-description" class="lead">{{ $blog->description_en }}</p>

                                <p id="np-description" class="lead" style="display: none;">{{ $blog->description_np }}</p>

                            </div>
                        </article>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="sticky-top" style="top: 20px;">
                            <!-- Recent Blogs -->
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-clock"></i> Recent Blogs</h5>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        @forelse($recentBlogs as $recentBlog)
                                            <a href="{{ route('frontend.blog.show', $recentBlog->slug) }}"
                                                class="text-decoration-none text-dark">
                                                <li class="list-group-item border-0">
                                                    <div class="d-flex">
                                                        @if (!empty($recentBlog->images))
                                                            <img src="{{ $recentBlog->images[0] }}" class="me-3 rounded"
                                                                alt="Blog Image"
                                                                style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="me-3 bg-secondary rounded d-flex align-items-center justify-content-center text-white"
                                                                style="width: 60px; height: 60px;">
                                                                <i class="fas fa-image"></i>
                                                            </div>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">
                                                                @if ($recentBlog->slug)
                                                                    <a href="{{ route('frontend.blog.show', $recentBlog->slug) }}"
                                                                        class="text-decoration-none text-dark">{{ Str::limit($recentBlog->title_en, 40) }}</a>
                                                                @else
                                                                    {{ Str::limit($recentBlog->title_en, 40) }}
                                                                @endif
                                                            </h6>
                                                            <small
                                                                class="text-muted">{{ $recentBlog->created_at->format('M d, Y') }}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </a>
                                        @empty
                                            <li class="list-group-item text-center text-muted">
                                                No recent blogs available.
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
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

        .blog-content p {
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush
@push('scripts')
    <script>
        function toggleLang(lang) {
            document.getElementById('en-text').style.display = (lang === 'en') ? 'block' : 'none';
            document.getElementById('np-text').style.display = (lang === 'np') ? 'block' : 'none';
            document.getElementById('en-description').style.display = (lang === 'en') ? 'block' : 'none';
            document.getElementById('np-description').style.display = (lang === 'np') ? 'block' : 'none';
        }
    </script>
@endpush
