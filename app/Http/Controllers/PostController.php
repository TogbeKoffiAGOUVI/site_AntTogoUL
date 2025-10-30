<?php

namespace App\Http\Controllers;

use App\Models\CategoryBlog;
use App\Models\Post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource (ADMIN VIEW: /admin/blog/posts).
     */
    public function index()
    {
        // On récupère tous les articles, peu importe leur statut, pour l'admin
        $posts = Post::with('category')->latest()->paginate(15);

        // Comme cette route est dans le bloc admin/blog, on définit le drapeau
        $is_admin_view = true;

        return view('blog.posts.index', compact('posts', 'is_admin_view'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // On suppose que le nom de la table pour CategoryBlog est 'category_blogs'
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
            'category_id'       => 'required|exists:category_blogs,id',
            // Le slug est nullable ici, nous gérons l'unicité après
            'slug'              => 'nullable|string|max:255|alpha_dash',
            'content'           => 'required',
            'excerpt'           => 'nullable|string|max:500',
            'thumbnail'         => 'nullable|image|max:5000',
            'main_media'        => 'nullable|file|max:5000000|mimes:jpg,jpeg,png,gif,mp4,mov,ogg,webm',
            'main_media_type'   => 'nullable|in:image,video',
            'status'            => 'required|in:draft,published,archived',
        ]);

        // 2. Logique de Slug (assure l'unicité pour la création)
        $baseSlug = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $uniqueSlug = $baseSlug;
        $counter = 1;

        // Boucle pour garantir que le slug est unique
        while (Post::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $baseSlug . '-' . $counter++;
        }
        $validated['slug'] = $uniqueSlug; // Mise à jour du slug dans les données validées


        // 3. Téléchargement et stockage des fichiers
        $data = $validated;
        $data['thumbnail_url'] = null;
        $data['main_media_url'] = null;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_url'] = $request->file('thumbnail')->store('posts', 'public');
        }

        if ($request->hasFile('main_media')) {
            $data['main_media_url'] = $request->file('main_media')->store('posts', 'public');
        }

        // Nettoyage des clés temporaires de fichiers
        unset($data['thumbnail'], $data['main_media']);

        // 4. Création de l'article (avec gestion d'erreur)
        try {
            Post::create($data);
            return redirect()->route('blog.posts.index')->with('success', 'Article **"' . $data['title'] . '"** créé avec succès !');
        } catch (\Exception $e) {
            // Si une erreur de DB survient (peu probable ici), renvoyer une erreur flash
            // En cas d'erreur de slug du à la race condition on est sûr que l'erreur s'affiche
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de l\'article. Veuillez vérifier le slug et réessayer.');
        }
    }

    /**
     * Display the specified resource (PUBLIC VIEW: /articles/{slug}).
     */
    public function show(Post $post)
    {
        // VÉRIFICATION DE SÉCURITÉ: L'article doit être publié pour être visible publiquement
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->increment('views_count');

        // --- MODIFICATION / AJOUT ICI : PRÉCHARGEMENT DES RELATIONS ---
        // On charge l'article en incluant ses relations 'comments'
        // Pour chaque commentaire, on inclut son 'user' (l'auteur) pour éviter le N+1
        $post->load(['comments.user']);

        // Note: L'Eager Loading des likes n'est pas nécessaire ici si l'on utilise des méthodes 
        // comme $post->likes()->where('user_id', Auth::id())->exists() dans la vue.

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
        // 1. Validation des champs (Ignorer le slug actuel pour l'unicité)
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:category_blogs,id',
            // Règle d'unicité avancée pour la mise à jour
            'slug'              => 'required|string|max:255|alpha_dash|unique:posts,slug,' . $post->id,
            'content'           => 'required',
            'excerpt'           => 'nullable|string|max:500',
            'thumbnail'         => 'nullable|image|max:5000',
            'main_media'        => 'nullable|file|max:5000000|mimes:jpg,jpeg,png,gif,mp4,mov,ogg,webm',
            'main_media_type'   => 'nullable|in:image,video',
            'status'            => 'required|in:draft,published,archived',
        ]);

        $data = $validated;

        try {
            // 2. Gestion des fichiers (Modification conservée, mais simplifiée)
            if ($request->hasFile('thumbnail')) {
                if ($post->thumbnail_url) {
                    Storage::disk('public')->delete($post->thumbnail_url);
                }
                $data['thumbnail_url'] = $request->file('thumbnail')->store('posts', 'public');
            }
            // Si le fichier n'est PAS mis à jour, $data ne contient pas 'thumbnail_url', ce qui est correct.

            if ($request->hasFile('main_media')) {
                if ($post->main_media_url) {
                    Storage::disk('public')->delete($post->main_media_url);
                }
                $data['main_media_url'] = $request->file('main_media')->store('posts', 'public');
            }

            // Nettoyage des champs de fichiers temporaires
            unset($data['thumbnail'], $data['main_media']);

            // 3. Mise à jour de l'article
            $post->update($data);

            return redirect()->route('blog.posts.index')->with('success', 'Article **"' . $post->title . '"** mis à jour avec succès !');
        } catch (\Exception $e) {
            // Capturer les erreurs inattendues de DB lors de la mise à jour
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de l-article. Veuillez réessayer.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $postTitle = $post->title;

        try {
            // 1. Suppression des fichiers associés
            if ($post->thumbnail_url) {
                Storage::disk('public')->delete($post->thumbnail_url);
            }
            if ($post->main_media_url) {
                Storage::disk('public')->delete($post->main_media_url);
            }

            // 2. Suppression de l'article
            $post->delete();

            return redirect()->route('blog.posts.index')->with('success', 'Article **"' . $postTitle . '"** supprimé avec succès !');
        } catch (QueryException $e) {
            // Cas peu probable pour un article, mais par sécurité
            return redirect()->route('blog.posts.index')
                ->with('error', 'Impossible de supprimer l\'article **"' . $postTitle . '"**. Une erreur de base de données est survenue.');
        } catch (\Exception $e) {
            // Erreur générale
            return redirect()->route('blog.posts.index')
                ->with('error', 'Une erreur inattendue est survenue lors de la suppression de l\'article **"' . $postTitle . '"**.');
        }
    }
}
