<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class LikeController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Post $post)
    {
        $user = Auth::user();

        // Vérifie si l'utilisateur a déjà liké cet article
        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {

            $like->delete();
            $action = 'unliked';
        } else {

            $post->likes()->create(['user_id' => $user->id]);
            $action = 'liked';
        }

        $newCount = $post->likes()->count();

        return response()->json([
            'success' => true,
            'action' => $action,
            'new_count' => $newCount,
        ]);
    }
}
