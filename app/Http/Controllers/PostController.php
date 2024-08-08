<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{

    public function __construct()
    {
        // Applica il middleware auth solo alle azioni di creazione, modifica ed eliminazione
        $this->middleware('auth')->except(['index', 'show']);
    }
        public function index()
    {
        $posts = Post::with('tags')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'video' => 'mimes:mp4,mov,ogg|max:20480',
                'tags' => 'nullable|string'
            ]);

            $post = new Post([
                'title' => $validated['title'],
                'content' => $validated['content'],
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('post_images', 'public');
                $post->image = $imagePath;
                Log::info('Image saved: ' . $imagePath);
            }

            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('post_videos', 'public');
                $post->video = $videoPath;
            }

            $post->save();

            if ($request->has('tags')) {
                $tagNames = explode(',', $request->input('tags'));
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                    $tagIds[] = $tag->id;
                }
                $post->tags()->sync($tagIds);
            }


            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating post: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error creating post. Please try again.');
        }
    }

public function show(Post $post) {
    return view('posts.show', compact('post'));
}

public function destroy(Post $post)
{
    // Elimina l'immagine associata se esiste
    if ($post->image) {
        Storage::disk('public')->delete($post->image);
    }

    // Elimina il video associato se esiste
    if ($post->video) {
        Storage::disk('public')->delete($post->video);
    }

    // Elimina il post
    $post->delete();

    return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
}

public function indexByTag(Tag $tag)
{
    $posts = $tag->posts()->with('tags')->latest()->paginate(10);
    return view('posts.index', compact('posts', 'tag'));
}

public function search(Request $request)
{
    $query = $request->input('query');
    $posts = Post::where('title', 'like', "%$query%")
                 ->orWhere('content', 'like', "%$query%")
                 ->with('tags')
                 ->latest()
                 ->paginate(10);
    return view('posts.index', compact('posts', 'query'));
}

    // Implementa gli altri metodi (show, edit, update, destroy) secondo necessità
}
