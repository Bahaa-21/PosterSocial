<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'image' => ['nullable', 'image', 'max:5120'],
            'published_at' => ['nullable', 'date'],
        ]);

        $slugBase = Str::slug($validated['title']);
        $slug = $slugBase ?: Str::random(10);
        $original = $slug;
        $i = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i;
            $i++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'slug' => $slug,
            'image' => $imagePath,
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'published_at' => filled($validated['published_at'] ?? null)
                ? Carbon::parse($validated['published_at'])
                : null,
        ]);

        return redirect()->route('posts.show', $post->id)->with('status', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user', 'comments', 'likes')->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'image' => ['nullable', 'image', 'max:5120'],
            'published_at' => ['nullable', 'date'],
        ]);

        $slugBase = Str::slug($validated['title']);
        $slug = $slugBase ?: Str::random(10);
        $original = $slug;
        $i = 1;
        while (Post::where('slug', $slug)->where('_id', '!=', $post->id)->exists()) {
            $slug = $original . '-' . $i;
            $i++;
        }

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            if (!empty($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'slug' => $slug,
            'image' => $imagePath,
            'category_id' => $validated['category_id'],
            'published_at' => filled($validated['published_at'] ?? null)
                ? Carbon::parse($validated['published_at'])
                : null,
        ]);

        return redirect()->route('posts.show', $post->id)->with('status', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if (!empty($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post deleted successfully.');
    }
}
