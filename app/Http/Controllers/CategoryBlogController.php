<?php

namespace App\Http\Controllers;

use App\Models\CategoryBlog;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryBlogController extends Controller
{
    /**
     * Display a listing of the resource (ADMIN VIEW: /admin/blog/categories).
     */
    public function index()
    {

        $categories = CategoryBlog::withCount('posts')->orderBy('name')->paginate(10); // Récupère les catégories avec leurs posts associés (pour compter les articles dans la vue)

        $is_admin_view = true;

        return view('blog.categories.index', compact('categories', 'is_admin_view'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation de base
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:category_blogs,slug', // <-- Validation sur le slug
            'description' => 'nullable|string',
        ]);

        // 2. Logique de Slug (assure l'unicité)
        // Utilise le slug fourni, ou le nom si le slug est vide
        $baseSlug = $request->input('slug') ? Str::slug($request->input('slug')) : Str::slug($request->input('name'));
        $uniqueSlug = $baseSlug;
        $counter = 1;

        // Boucle pour garantir que le slug n'existe pas déjà
        while (CategoryBlog::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $baseSlug . '-' . $counter++;
        }

        // 3. Tentative de Création (avec gestion d'erreur)
        try {
            CategoryBlog::create([
                'name' => $request->name,
                'slug' => $uniqueSlug, // <-- Utilisation du slug unique
                'description' => $request->description,
            ]);

            return redirect()->route('blog.categories.index')
                ->with('success', 'La rubrique de blog **"' . $request->name . '"** a été créée avec succès.');
        } catch (QueryException $e) {
            // Retourne une erreur DB inattendue
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur de base de données est survenue. Le nom de la rebrique ou le slug est peut-être déjà utilisé.');
        }
    }


    /**
     * Display the specified resource (PUBLIC VIEW: /rubrique/{slug}).
     */
    public function show(CategoryBlog $category)
    {
        // 1. Récupère les articles PUBLIÉS associés à cette catégorie. (Ajout du filtre de statut)
        $posts = $category->posts()
            ->with('category')
            ->where('status', 'published')
            ->latest()
            ->paginate(15);

        // 2. Définir le drapeau sur FAUX pour afficher le rendu PUBLIC de la catégorie
        $is_admin_view = false;

        // La vue 'blog.categories.show' affichera la liste des articles de cette catégorie
        return view('blog.categories.show', compact('category', 'posts', 'is_admin_view'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryBlog $category)
    {
        return view('blog.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryBlog $category)
    {
        // 1. Validation (Ignorer le slug de la catégorie actuelle pour l'unicité)
        $request->validate([
            'name' => 'required|string|max:255',
            // Unicité du slug, en ignorant l'ID de la catégorie actuelle
            'slug' => 'nullable|string|max:255|unique:category_blogs,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // 2. Logique de Slug (assure l'unicité lors de la MAJ)
        $newSlug = $request->input('slug') ? Str::slug($request->input('slug')) : Str::slug($request->input('name'));

        // Seulement si le slug généré est différent du slug actuel (si l'utilisateur l'a modifié)
        if ($newSlug !== $category->slug) {
            $uniqueSlug = $newSlug;
            $counter = 1;

            // Vérifie l'existence du slug en ignorant la catégorie actuelle
            while (CategoryBlog::where('slug', $uniqueSlug)->where('id', '!=', $category->id)->exists()) {
                $uniqueSlug = $newSlug . '-' . $counter++;
            }
            $data['slug'] = $uniqueSlug;
        } else {
            $data['slug'] = $category->slug; // Conserver l'ancien slug
        }

        // 3. Tentative de Mise à Jour (avec gestion d'erreur)
        try {
            $category->update([
                'name' => $request->name,
                'slug' => $data['slug'],
                'description' => $request->description,
            ]);

            return redirect()->route('blog.categories.index')
                ->with('success', 'La rubrique de blog **"' . $request->name . '"** a été mise à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de la rebrique. Veuillez vérifier vos données.');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryBlog $category)
    {
        $categoryName = $category->name;

        try {
            $category->delete();

            return redirect()->route('blog.categories.index')
                ->with('success', 'La rubrique **"' . $categoryName . '"** a été supprimée avec succès.');
        } catch (QueryException $e) {
            // Gère l'erreur de clé étrangère (si des articles sont toujours attachés)
            return redirect()->route('blog.categories.index')
                ->with('error', 'Impossible de supprimer la rubrique **"' . $categoryName . '"** car elle contient encore des articles.');
        }
    }
}
