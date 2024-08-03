<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        $recentPosts = Post::with('tags')
            ->latest()
            ->take(5)  // Prende i 5 post più recenti
            ->get();

        return view('home', compact('recentPosts'));
    }

    public function adminDashboard()
    {
        $this->middleware('auth');
        $postCount = Post::count();
        $tagCount = Tag::count();
        return view('admin.dashboard', compact('postCount', 'tagCount'));
    }
}