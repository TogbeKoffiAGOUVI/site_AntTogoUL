<?php

namespace App\Http\Controllers;

use App\Models\CategoryBlog;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(15);
        return view('blog.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoryBlog::all(['id', 'name']);
        return view('blog.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation des champs classiques et des fichiers
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|unique:posts,slug|max:255|alpha_dash',
            'category_id'       => 'required|exists:categories,id',
            'content'           => 'required',
            'excerpt'           => 'nullable|string|max:500',
            // Règle de validation pour le fichier (max 5MB, formats image)
            'thumbnail'         => 'nullable|image|max:5000',
            // Règle de validation pour le média (max 10MB, formats image/vidéo)
            'main_media'        => 'nullable|file|max:10000|mimes:jpg,jpeg,png,gif,mp4,mov,ogg,webm',
            'main_media_type'   => 'nullable|in:image,video',
            'status'            => 'required|in:draft,published,archived',
        ]);

        // 2. Traitement du slug si non fourni
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Initialisation des chemins de fichiers
        $thumbnailPath = null;
        $mainMediaPath = null;

        // 3. Téléchargement et stockage du fichier miniature
        if ($request->hasFile('thumbnail')) {
            // Stocke dans storage/app/public/posts et retourne le chemin relatif
            $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
        }

        // 4. Téléchargement et stockage du média principal
        if ($request->hasFile('main_media')) {
            $mainMediaPath = $request->file('main_media')->store('posts', 'public');
        }

        // 5. Préparation des données pour la création
        $data = array_merge($validated, [
            // On remplace les champs de fichier par leur chemin stocké
            'thumbnail_url'  => $thumbnailPath,
            'main_media_url' => $mainMediaPath,
        ]);

        // Suppression des clés de fichier qui ne sont pas des colonnes de la DB
        unset($data['thumbnail'], $data['main_media']);


        Post::create($data);
        return redirect()->route('blog.posts.index')->with('success', 'Article créé avec succès !');
    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->increment('views_count');
        return view('blog.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = CategoryBlog::all(['id', 'name']);
        return view('blog.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // 1. Validation des champs
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            // Ignorer le slug actuel pour l'unicité
            'slug'              => 'required|string|max:255|alpha_dash|unique:posts,slug,' . $post->id,
            'category_id'       => 'required|exists:categories,id',
            'content'           => 'required',
            'excerpt'           => 'nullable|string|max:500',
            // Validation des fichiers pour la mise à jour
            'thumbnail'         => 'nullable|image|max:5000',
            'main_media'        => 'nullable|file|max:10000|mimes:jpg,jpeg,png,gif,mp4,mov,ogg,webm',
            'main_media_type'   => 'nullable|in:image,video',
            'status'            => 'required|in:draft,published,archived',
        ]);

        // Initialiser les données de mise à jour avec les champs validés
        $data = $validated;

        // 2. Gestion de la miniature (Thumbnail)
        if ($request->hasFile('thumbnail')) {
            // A. Supprimer l'ancienne miniature si elle existe
            if ($post->thumbnail_url) {
                Storage::disk('public')->delete($post->thumbnail_url);
            }
            // B. Télécharger la nouvelle miniature
            $data['thumbnail_url'] = $request->file('thumbnail')->store('posts', 'public');
        } else {
            // Assurer que le champ n'est pas inclus dans la mise à jour s'il n'y a pas de fichier
            unset($data['thumbnail']);
        }

        // 3. Gestion du média principal
        if ($request->hasFile('main_media')) {
            // A. Supprimer l'ancien média si elle existe
            if ($post->main_media_url) {
                Storage::disk('public')->delete($post->main_media_url);
            }
            // B. Télécharger le nouveau média
            $data['main_media_url'] = $request->file('main_media')->store('posts', 'public');
        } else {
            // Assurer que le champ n'est pas inclus dans la mise à jour s'il n'y a pas de fichier
            unset($data['main_media']);
        }

        // 4. Nettoyage des champs de fichiers temporaires
        unset($data['thumbnail'], $data['main_media']);

        // 5. Mise à jour de l'article
        $post->update($data);

        return redirect()->route('blog.posts.index')->with('success', 'Article mis à jour avec succès !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Optionnel : Supprimer les fichiers associés lors de la suppression de l'article
        if ($post->thumbnail_url) {
            Storage::disk('public')->delete($post->thumbnail_url);
        }
        if ($post->main_media_url) {
            Storage::disk('public')->delete($post->main_media_url);
        }

        $post->delete();

        return redirect()->route('blog.posts.index')->with('success', 'Article supprimé avec succès !');
    }
}
