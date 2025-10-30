<?php

namespace App\Http\Controllers;

use App\Models\CategoryBlog; 
use App\Models\Post; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class BlogController extends Controller
{
    
    public function index()
    {
        
        $articles = Post::with('category')
            ->where('status', 'published') 
            ->latest() 
            ->paginate(12); 

        
        $categories = CategoryBlog::withCount(['posts' => function ($query) {
            $query->where('status', 'published'); // Compte seulement les articles publiés
        }])
            ->orderBy('posts_count', 'desc') 
            ->orderBy('name', 'asc') 
            ->get();

        
        $is_admin_view = false;

        return view('blog.categories.index', compact('articles', 'categories', 'is_admin_view'));
    }

    
}
