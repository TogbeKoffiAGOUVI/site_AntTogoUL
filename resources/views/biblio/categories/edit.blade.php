@extends('layout.base')

@section('content')
    <div class="form-container">
        <h1 class="form-title">Modifier une rubrique</h1>

        <form action="{{ route('categories.update', $category->id) }}" method="post" class="post-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Titre</label>
                <input type="text" placeholder="" id="name" name="name" value="{{ old('name', $category->name) }}"
                    class="form-input" />
            </div>

            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <button type="submit" class="submit-button">Mettre à jour la rubrique</button>
        </form>
    </div>
@endsection
