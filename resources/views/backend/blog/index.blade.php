@extends('backend.layout.main')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0">Blog Listing</h5>
            <p class="text-muted mb-0">Manage all blog posts with English and Nepali content.</p>
        </div>
        <a href="{{ route('blog.create') }}" class="btn btn-primary">Create Blog</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(isset($blogs) && $blogs->count())
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title EN</th>
                                <th>Title NP</th>
                                <th>Description EN</th>
                                <th>Description NP</th>
                                <th>Images</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($blog->title_en ?? $blog->title, 50) }}</td>
                                    <td>{{ Str::limit($blog->title_np ?? '-', 50) }}</td>
                                    <td>{{ Str::limit($blog->description_en ?? $blog->description, 80) }}</td>
                                    <td>{{ Str::limit($blog->description_np ?? '-', 80) }}</td>
                                    <td>{{ is_array($blog->images) ? count($blog->images) : 0 }}</td>
                                    <td>
                                        <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                        <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this blog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(method_exists($blogs, 'links'))
            <div class="mt-3">{{ $blogs->links() }}</div>
        @endif
    @else
        <div class="card">
            <div class="card-body text-center">
                <p class="mb-0">No blog posts found yet. Use the Create Blog button to add one.</p>
            </div>
        </div>
    @endif
@endsection
