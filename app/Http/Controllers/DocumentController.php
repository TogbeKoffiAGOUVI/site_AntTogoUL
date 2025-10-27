<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::all();
        return view('biblio.documents.index', [
            'documents' => $documents,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        $category = $request->category_id ? Category::find($request->category_id) : null;

        return view('biblio.documents.create', [
            'categories' => $categories,
            'category' => $category,
            'category_id' => $request->category_id,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation de la requête
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,epub,jpg,jpeg,png|max:50000', // Exemple de validation de fichier
            'category_id' => 'required|exists:categories,id',
        ]);

        $file = $request->file('file');

      
        $filePath = $request->file('file')->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('documents.index')->with('success', 'Le document a été ajouté avec succès.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('biblio.documents.show', [
            'document' => $document,
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Document $document)
    {
        $categories = Category::all();
        return view(
            'biblio.documents.edit',
            [
                'document' => $document,
                'categories' => $categories,
            ]
        );
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, Document $document)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('file')) {

            if ($document->file_path) {
                Storage::delete($document->file_path);
            }

            $validatedData['file_path'] = $request->file('file')->store('documents');
        }

        $document->update($validatedData);

        return redirect()->route('documents.index')->with('success', 'Mise à jour effectuée avec succès.');
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::delete($document->file_path);
        }

        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document supprimé avec succès.');
    }
}
