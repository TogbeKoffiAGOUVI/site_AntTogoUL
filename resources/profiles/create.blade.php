@extends('layout.base')
@section('content')

    <h1>Ajouter une photo de profile</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profiles.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT') <input type="hidden" name="name" value="{{ Auth::user()->name }}">

        <div>
            <label for="profile_photo"><b>Photo :</b></label>
            <input type="file" placeholder="Ajouter une photo..." id="profile_photo" name="profile_photo" accept="image/*">
        </div>
        <button type="submit">Ajouter une photo</button>

    </form>
@endsection
