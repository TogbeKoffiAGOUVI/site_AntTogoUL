<?php

namespace App\Http\Controllers;

use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResearcherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $researchers = Researcher::all();
        return view('researchers.index', [
            'researchers' => $researchers,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('researchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:2048', // max 2MB
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'graduate' => 'required|string|max:255', // ou 'boolean' si c'est un booléen
            'searcherprofil' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'email' => 'required|email|unique:researchers,email', // ou former_students
        ]);

        $file = $request->file('photo');
        if ($file)
            $path = $file->store('researchers', 'public');

        Researcher::create([
            'photo' => $file ? $path : null,
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'graduate' => $validatedData['graduate'],
            'searcherprofil' => $validatedData['searcherprofil'],
            'telephone' => $validatedData['telephone'],
            'email' => $validatedData['email'],

        ]);

        return redirect()->route('researchers.index')->with('success', 'Chercheur ajouté avec succès');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $researcher = Researcher::find($id);
        return view('researchers.show', [
            'researcher' => $researcher,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $researcher = Researcher::find($id);
        return view('researchers.edit', [
            'researcher' => $researcher,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'photo',
    //         'firstname',
    //         'lastname',
    //         'graduate',
    //         'searcherprofil',
    //         'telephone',
    //         'email',

    //     ]);

    //      $researcher = Researcher::findOrFail($id);

    //     if ($request->hasFile('photo')) {

    //         if ($researcher->photo) {

    //             Storage::disk('public')->delete($researcher->photo);
    //         }

    //         $path = $request->file('photo')->store('researcher', 'public');
    //         $validatedData['photo'] = $path;
    //     } else {
    //         unset($validatedData['photo']);
    //     }

    //     $researcher->update($validatedData);

    //     return redirect()->route('researchers.index')->with('success', 'Mise à jour effectuée avec succès');
    // }
    {
        // 1. Validation des données
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'graduate' => 'required|string|max:255',
            'searcherprofil' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'graduate' => 'required|string|max:255',
            'email' => 'required|email|unique:researchers,email,' . $id,
        ]);

        $researcher = Researcher::findOrFail($id);

        if ($request->hasFile('photo')) {

            if ($researcher->photo) {

                Storage::disk('public')->delete($researcher->photo);
            }

            $path = $request->file('photo')->store('researchers', 'public');
            $validatedData['photo'] = $path;
        } else {
            unset($validatedData['photo']);
        }

        $researcher->update($validatedData);

        return redirect()->route('researchers.index')->with('success', 'Mise à jour effectuée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $researcher = Researcher::find($id);
        //supprimer l'ancienne photo si celà existe

        if ($researcher->photo && file_exists(public_path('photo_profils/' . $researcher->photo))) {
            unlink(public_path('photo_profils/' . $researcher->photo));
        }


        $researcher->delete();

        return redirect()->route('researchers.index')->with('success', 'suppression effectuée avec succès');
    }
}
