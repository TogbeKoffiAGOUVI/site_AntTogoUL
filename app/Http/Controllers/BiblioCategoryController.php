<?php

namespace App\Http\Controllers;

use App\Models\BiblioCategory;
use Illuminate\Http\Request;

class BiblioCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biblioCategories = BiblioCategory::all();

        return view(
            'biblio.categories.index',
            [
                'biblioCategories' => $biblioCategories
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
                'name' => "required|string|max:255|unique:biblio_categories"
            ]
        );

        BiblioCategory::create(
            [
                'name' => $request->name
            ]
        );

        return redirect()->route('biblio.categories.index')->with('success', 'La rubrique est créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $biblioCategory = BiblioCategory::with('documents')->findOrFail($id);
        $documents = $biblioCategory->documents;
        return view(
            'biblio.categories.show',
            compact('biblioCategory', 'documents')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BiblioCategory $biblioCategory)
    {
        return view(
            'biblio.categories.edit',
            compact('biblioCategory')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BiblioCategory $biblioCategory)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:categories,name,' . $biblioCategory->id,
            ]
        );

        $biblioCategory->update($request->all());
        return redirect()->route('biblio.categories.index')->with('success', 'Rubrique mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BiblioCategory $biblioCategory)
    {
        $biblioCategory->documents()->delete();
        $biblioCategory->delete();
        return redirect()->route('biblio.categories.index')->with('success', 'Rubrique supprimée avec succès.');
    }
}
