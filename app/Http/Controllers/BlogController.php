<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('backend.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.blog.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_np' => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_np' => 'nullable|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Process the uploaded images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('blogs', 'public');
                $images[] = Storage::url($path);
            }
        }

        // Create the blog post
        $slug = Str::slug($request->title_en) . '-' . Str::random(6);
        $blog = Blog::create([
            'title_en' => $request->title_en,
            'title_np' => $request->title_np,
            'description_en' => $request->description_en,
            'description_np' => $request->description_np,
            'slug' => $slug,
            'status' => $request->status ?? '0',
            'images' => $images,
        ]);

        if ($blog) {
            return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
        }

        return redirect()->route('blog.index')->with('error', 'Failed to create blog.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        return view('backend.blog.form', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_np' => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_np' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blog = Blog::findOrFail($id);

        // Process the uploaded images
        $images = $blog->images ?? [];
        if ($request->hasFile('images')) {
            // Delete old images from storage
            if (!empty($blog->images)) {
                foreach ($blog->images as $imageUrl) {
                    $path = str_replace('/storage/', '', $imageUrl);
                    Storage::disk('public')->delete($path);
                }
            }
            // Reset images array and add new ones
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('blogs', 'public');
                $images[] = Storage::url($path);
            }
        }

        $slug = Str::slug($request->title_en) . '-' . Str::random(6);
        $blog->update([
            'title_en' => $request->title_en,
            'title_np' => $request->title_np,
            'description_en' => $request->description_en,
            'description_np' => $request->description_np,
            'status' => $request->status ?? '0',
            'slug' => $slug,
            'images' => $images,
        ]);

        if ($blog) {
            return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
        }

        return redirect()->route('blog.index')->with('error', 'Failed to update blog.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        // Delete associated images from storage
        if (!empty($blog->images)) {
            foreach ($blog->images as $imageUrl) {
                $path = str_replace('/storage/', '', $imageUrl);
                Storage::disk('public')->delete($path);
            }
        }

        $deleted = $blog->delete();

        if ($deleted) {
            return redirect()->route('blog.index')->with('success', 'Blog deleted successfully.');
        }
        return redirect()->route('blog.index')->with('error', 'Failed to delete blog.');
    }

    public function statusUpdate(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = $request->status;
        $blog->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }
}
