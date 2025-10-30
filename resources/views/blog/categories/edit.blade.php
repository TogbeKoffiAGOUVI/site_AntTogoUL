@extends('layout.base')

@section('content')

    <main>
        <div>
            <h1>Modifier: {{ $category->name }}</h1>

            @if (session('success'))
                <div>
                    <strong>Succès :</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div>
                    <strong>Erreur :</strong> {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div>
                    <strong>Erreur de validation :</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('blog.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT') <div>
                    <label for="name">Nom de la rebrique </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                        placeholder="Ex: Anthropologie Sociale">
                    @error('name')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                        placeholder="Ex: anthropologie-sociale">
                    @error('slug')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" placeholder="Une courte description de cette catégorie.">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <a href="{{ route('blog.categories.index') }}">
                        Annuler
                    </a>
                    <button type="submit">
                        Mettre à jour la rebrique
                    </button>
                </div>
            </form>
        </div>
    </main>

@endsection
