@extends('layout.base')

@section('content')
    <div class="form-container">
        <h1 class="form-title">Créer une nouvelle rubrique</h1>

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="post-form">
            @csrf

            <label for="name" class="form-label">Titre</label>
            <input type="text" placeholder="" id="name" name="name" class="form-input" />

            <button type="submit" class="submit-button">Publier</button>
        </form>
    </div>
@endsection
