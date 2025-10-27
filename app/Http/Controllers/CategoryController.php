<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view(
            'biblio.categories.index',
            [
                'categories' => $categories
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'biblio.categories.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => "required|string|max:255|unique:categories"
            ]
        );

        Category::create(
            [
                'name' => $request->name
            ]
        );

        return redirect()->route('categories.index')->with('success', 'La rubrique est créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::with('documents')->findOrFail($id);
        $documents = $category->documents;
        return view(
            'biblio.categories.show',
            compact('category', 'documents')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view(
            'biblio.categories.edit',
            compact('category')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            ]
        );

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Rubrique mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->documents()->delete();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Rubrique supprimée avec succès.');
    }
}
