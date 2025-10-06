<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('formerStudents.index', [
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('formerStudents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:students,email', // ou former_students
            'field_of_student' => 'nullable|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'graduate' => 'required|string|max:255', // ou 'boolean' si c'est un booléen
            'promotion' => 'nullable|string|max:255',
            'social_media' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        $file = $request->file('photo');
        if ($file)
            $path = $file->store('students', 'public');

        Student::create([
            'photo' => $file ? $path : null,
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'telephone' => $validatedData['telephone'],
            'email' => $validatedData['email'],
            'field_of_student' => $validatedData['field_of_student'],
            'speciality' => $validatedData['speciality'],
            'graduate' => $validatedData['graduate'],
            'promotion' => $validatedData['promotion'],
            'social_media' => $validatedData['social_media'],
            'biography' => $validatedData['biography'],
        ]);

        return redirect()->route('formerStudents.index')->with('success', 'Etudiant(e) ajouté(e) avec succès');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        return view('formerStudents.show', [
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        return view('formerStudents.edit', [
            'student' => $student,
        ]);
    }



    // StudentController.php

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validation des données
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:students,email,' . $id,
            'field_of_student' => 'nullable|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'graduate' => 'required|string|max:255',
            'promotion' => 'nullable|string|max:255',
            'social_media' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $student = Student::findOrFail($id);

        if ($request->hasFile('photo')) {

            if ($student->photo) {

                Storage::disk('public')->delete($student->photo);
            }

            $path = $request->file('photo')->store('students', 'public');
            $validatedData['photo'] = $path;
        } else {
            unset($validatedData['photo']);
        }

        $student->update($validatedData);

        return redirect()->route('formerStudents.index')->with('success', 'Mise à jour effectuée avec succès');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        //supprimer l'ancienne photo si celà existe

        if ($student->photo && file_exists(public_path('photo_profils/' . $student->photo))) {
            unlink(public_path('photo_profils/' . $student->photo));
        }


        $student->delete();

        return redirect()->route('formerStudents.index')->with('success', 'suppression effectuée avec succès');
    }
}
