<?php

namespace App\Http\Controllers;

use App\Models\CategoryBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryBlog::orderBy('name')->paginate(10);
        return view('blog.categories.index', compact('categories'));
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
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name); // Création du slug à partir du nom
        CategoryBlog::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);

        return redirect()->route('blog.categories.index')->with('success', 'La catégorie "' . $request->name . '" a été créée avec succès.');
    }


    /**
     * Display the specified resource.
     * * Maintenant, charge les articles associés pour les afficher dans la vue de la catégorie.
     */
    public function show(CategoryBlog $category)
    {
        // 1. Récupère les posts associés à cette catégorie.
        // 2. Eager-load la relation 'category' sur les posts (même si déjà filtré, bonne pratique).
        // 3. Trie par les plus récents et ajoute la pagination.
        $posts = $category->posts()
            ->with('category')
            ->latest()
            ->paginate(15);


        return view('blog.categories.show', compact('category', 'posts'));
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
        //  Validation des données (ignorer l'unicité pour la catégorie actuelle)
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // 2. Mise à jour du slug si le nom a changé
        $slug = Str::slug($request->name);

        // 3. Mise à jour des données
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);


        return redirect()->route('blog.categories.index')->with('success', 'La catégorie "' . $request->name . '" a été mise à jour.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryBlog $category)
    {
        // NOTE: Assurez-vous d'avoir configuré la suppression en cascade 
        // ou la mise à jour des clés étrangères pour les posts liés.
        $categoryName = $category->name;
        $category->delete();
        return redirect()->route('blog.categories.index')->with('success', 'La catégorie "' . $categoryName . '" a été supprimée.');
    }
}
