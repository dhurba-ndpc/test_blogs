@extends('backend.layout.main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Blog Form</h5>
        </div>
        <div class="card-body">

            @session('status')
                <div class="alert alert-success">{{ session('status') }}</div>
            @endsession

            <form method="POST" action="{{ isset($blog) ? route('blog.update', $blog->id) : route('blog.store') }}"
                enctype="multipart/form-data">
                @csrf
                @isset($blog)
                    @method('PUT')
                @endisset

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title_en" class="form-label">Title (English)</label>
                            <input type="text" class="form-control" id="title_en" name="title_en"
                                value="{{ old('title_en', $blog->title_en ?? '') }}" placeholder="Enter English title">
                            @error('title_en')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title_np" class="form-label">Title (Nepali)</label>
                            <input type="text" class="form-control" id="title_np" name="title_np"
                                value="{{ old('title_np', $blog->title_np ?? '') }}" placeholder="Enter Nepali title">
                            @error('title_np')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description_en" class="form-label">Description (English)</label>
                            <textarea class="form-control" id="description_en" name="description_en" rows="4"
                                placeholder="Enter English description">{{ old('description_en', $blog->description_en ?? '') }}</textarea>
                            @error('description_en')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description_np" class="form-label">Description (Nepali)</label>
                            <textarea class="form-control" id="description_np" name="description_np" rows="4"
                                placeholder="Enter Nepali description">{{ old('description_np', $blog->description_np ?? '') }}</textarea>
                            @error('description_np')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Images</label>
                    <input class="form-control" type="file" id="images" name="images[]" accept="image/*">
                    @error('images')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text">You can choose one or more images. A preview will appear below.</div>
                </div>

                <div id="image-preview" class="row g-3 mt-3">
                    @isset($blog)
                        @if(!empty($blog->images))
                            @foreach($blog->images as $src)
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="card h-100 border-secondary">
                                        <img src="{{ $src }}" class="card-img-top img-fluid" alt="Existing image">
                                        <div class="card-body p-2">
                                            <p class="card-text small text-truncate mb-0">Existing image</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-secondary py-2 mb-0">
                                    No existing images available.
                                </div>
                            </div>
                        @endif
                    @endisset
                </div>

                <div class="col-lg-12">
                     <input id="status_id" name="status" type="checkbox" value="1" {{ isset($blog->status) && $blog->status == '1' ? 'checked' : '' }}>
                      <label for="status_id">Check the button to Publish post.</label>
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="btn btn-primary">{{ isset($blog) ? 'Update Blog' : 'Save Blog' }}</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                const imagesInput = document.getElementById('images');
                const previewContainer = document.getElementById('image-preview');

                function renderPreviews(files) {
                    if (!previewContainer) {
                        return;
                    }
                    previewContainer.innerHTML = '';
                    Array.from(files).forEach(file => {
                        if (!file.type.startsWith('image/')) {
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const wrapper = document.createElement('div');
                            wrapper.className = 'col-12 col-sm-6 col-md-4';
                            wrapper.innerHTML = `
                                <div class="card h-100 border-secondary">
                                    <img src="${event.target.result}" class="card-img-top img-fluid" alt="Preview">
                                    <div class="card-body p-2">
                                        <p class="card-text small text-truncate mb-0">${file.name}</p>
                                    </div>
                                </div>
                            `;
                            previewContainer.appendChild(wrapper);
                        };
                        reader.readAsDataURL(file);
                    });
                }

                function initPreview() {
                    if (!imagesInput || !previewContainer) {
                        return;
                    }

                    imagesInput.addEventListener('change', function() {
                        renderPreviews(this.files);
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initPreview);
                } else {
                    initPreview();
                }
            })();
        </script>


 
    @endpush
@endsection
