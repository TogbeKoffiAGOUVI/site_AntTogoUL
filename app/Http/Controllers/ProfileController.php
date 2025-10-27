<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Assurez-vous d'importer le modèle User
use App\Models\ProfilePhoto; // Assurez-vous d'importer le modèle ProfilePhoto

class ProfileController extends Controller
{
    /**
     * Affiche toutes les photos de profil (simule l'index pour le profil de l'utilisateur connecté).
     * Correspond à la route GET /profiles -> profiles.index
     */
    public function index()
    {
        // Récupère la photo de profil de l'utilisateur connecté
        $user = Auth::user();
        
        // Retourne la vue d'index avec l'utilisateur (utilisé pour l'affichage)
        return view('profiles.index', compact('user'));
    }

    /**
     * Affiche le formulaire pour ajouter une nouvelle photo de profil.
     * Correspond à la route GET /profiles/create -> profiles.create
     */
    public function create()
    {
        // Affiche la vue qui contient le formulaire d'upload
        return view('profiles.create');
    }

    /**
     * Stocke la photo de profil soumise.
     * Correspond à la route POST /profiles -> profiles.store
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Validation : 'profile_photo' est le nom de champ attendu
        $request->validate([
            // Changement pour utiliser le nom de champ correct si vous l'avez corrigé
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $file = $request->file('profile_photo');
        
        // 2. Traitement de l'ancienne photo (si l'utilisateur en a déjà une)
        if ($user->profilePhoto) {
            // Supprimer l'ancienne photo du disque
            Storage::disk('public')->delete($user->profilePhoto->path);
            
            // Supprimer l'entrée de la base de données
            $user->profilePhoto->delete();
        }

        // 3. Stockage du nouveau fichier et création de l'entrée dans la BD
        $path = $file->store('profile-photos', 'public');
        
        $user->profilePhoto()->create([
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            // Ajoutez d'autres champs si nécessaire (mime_type, size)
        ]);

        return redirect()->route('profiles.index')->with('success', 'Photo de profil ajoutée avec succès.');
    }

    /**
     * Affiche une seule photo (non utilisé dans ce cas, mais requis par la ressource).
     * Correspond à la route GET /profiles/{profile} -> profiles.show
     */
    public function show(string $id)
    {
        // Redirige vers l'index pour simplifier l'accès au profil
        return redirect()->route('profiles.index');
    }

    /**
     * Affiche le formulaire d'édition (si vous voulez éditer d'autres données du profil).
     * Correspond à la route GET /profiles/{profile}/edit -> profiles.edit
     */
    public function edit(string $id)
    {
        // Vérifie si l'ID correspond à l'utilisateur connecté pour la sécurité
        if (Auth::id() != $id) {
            abort(403, 'Accès non autorisé.');
        }

        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }

    /**
     * Met à jour la photo (et potentiellement d'autres données).
     * Correspond à la route PUT/PATCH /profiles/{profile} -> profiles.update
     */
    public function update(Request $request, string $id)
    {
        // Cette méthode peut être utilisée pour mettre à jour d'autres données utilisateur,
        // mais pour la photo, la méthode store() est plus appropriée dans cette structure.
        
        // Dans ce contexte simplifié, nous redirigeons vers la logique 'store' ou laissons l'utilisateur
        // utiliser 'store' pour l'ajout/remplacement de photo, et utilisons 'update' pour d'autres champs.
        
        // Si vous utilisez 'update' pour la photo, copiez la logique de 'store' ici, 
        // en ajustant la validation pour que le fichier soit 'nullable' si vous mettez à jour d'autres champs.
        return redirect()->route('profiles.index')->with('success', 'Profil mis à jour.');
    }

    /**
     * Supprime la photo de profil.
     * Correspond à la route DELETE /profiles/{profile} -> profiles.destroy
     */
    public function destroy(string $id)
    {
        /** @var User $user */
        $user = Auth::user();

        // Vérification de sécurité
        if ($user->id != $id) {
            abort(403, 'Accès non autorisé.');
        }

        if ($user->profilePhoto) {
            // Suppression du fichier du disque
            Storage::disk('public')->delete($user->profilePhoto->path);
            
            // Suppression de l'entrée de la base de données
            $user->profilePhoto->delete();
        }

        return redirect()->route('profiles.index')->with('success', 'Photo de profil supprimée avec succès.');
    }
}