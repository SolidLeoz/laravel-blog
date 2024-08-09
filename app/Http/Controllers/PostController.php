<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'mimes:mp4,mov,ogg|max:20480',
            'tags' => 'nullable|string'
        ]);

        $post = new Post([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if ($request->hasFile('image')) {
            $result = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'blog_images',
                'public_id' => 'post_' . time() . '_' . uniqid(),
            ]);
            $post->image = $result->getSecurePath();
        }

        if ($request->hasFile('video')) {
            $result = Cloudinary::uploadVideo($request->file('video')->getRealPath(), [
                'folder' => 'blog_videos',
                'public_id' => 'post_' . time() . '_' . uniqid(),
            ]);
            $post->video = $result->getSecurePath();
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
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'mimes:mp4,mov,ogg|max:20480',
            'tags' => 'nullable|string'
        ]);

        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                $this->deleteCloudinaryAsset($post->image);
            }
            $result = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'blog_images',
            ]);
            $post->image = $result->getSecurePath();
        }

        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($post->video) {
                $this->deleteCloudinaryAsset($post->video);
            }
            $result = Cloudinary::uploadVideo($request->file('video')->getRealPath(), [
                'folder' => 'blog_videos',
            ]);
            $post->video = $result->getSecurePath();
        }

        $post->save();

        // Update tags
        if ($request->has('tags')) {
            $tagNames = explode(',', $request->input('tags'));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
{
    try {
        // Delete image from Cloudinary if exists
        if ($post->image) {
            Log::info('Attempting to delete image: ' . $post->image);
            $this->deleteCloudinaryAsset($post->image);
        }

        // Delete video from Cloudinary if exists
        if ($post->video) {
            Log::info('Attempting to delete video: ' . $post->video);
            $this->deleteCloudinaryAsset($post->video);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    } catch (\Exception $e) {
        Log::error('Error deleting post: ' . $e->getMessage());
        return redirect()->route('posts.index')->with('error', 'An error occurred while deleting the post.');
    }
}

private function deleteCloudinaryAsset($url)
{
    $publicId = $this->getPublicIdFromUrl($url);
    Log::info('Attempting to delete Cloudinary asset with public ID: ' . $publicId);
    
    if ($publicId) {
        try {
            $result = Cloudinary::destroy($publicId);
            Log::info('Cloudinary deletion result: ' . json_encode($result));
            
            if ($result['result'] === 'ok') {
                Log::info('Asset deleted successfully from Cloudinary: ' . $publicId);
            } else {
                Log::error('Failed to delete asset from Cloudinary: ' . $publicId . '. Result: ' . json_encode($result));
            }
        } catch (\Exception $e) {
            Log::error('Error deleting asset from Cloudinary: ' . $e->getMessage());
        }
    } else {
        Log::warning('Could not extract public ID from URL: ' . $url);
    }
}

private function getPublicIdFromUrl($url)
{
    $parsedUrl = parse_url($url);
    if (!isset($parsedUrl['path'])) {
        return null;
    }

    $pathParts = explode('/', trim($parsedUrl['path'], '/'));
    
    // Rimuovi il nome del cloud (solitamente il primo elemento)
    array_shift($pathParts);
    
    // Rimuovi 'image' o 'video' e 'upload' dal percorso
    $pathParts = array_values(array_diff($pathParts, ['image', 'video', 'upload']));
    
    // Rimuovi la versione (inizia con 'v' seguito da numeri)
    if (isset($pathParts[0]) && preg_match('/^v\d+$/', $pathParts[0])) {
        array_shift($pathParts);
    }

    // Il public ID è il resto del percorso
    $publicId = implode('/', $pathParts);
    
    // Rimuovi l'estensione del file se presente
    $publicId = preg_replace('/\.[^.]+$/', '', $publicId);

    return $publicId;
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

public function show(Post $post) {
    return view('posts.show', compact('post'));
}
}


