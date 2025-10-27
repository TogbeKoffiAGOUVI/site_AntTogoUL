## Copilot instructions for AnthropologieTogo

Purpose: give an AI code assistant the minimal, concrete context needed to make safe, accurate changes in this Laravel app.

Quick facts
- Framework: Laravel 12 (PHP ^8.2). See `composer.json`.
- Frontend: Vite + Tailwind; npm scripts in `package.json` (`dev`, `build`).
- Tests: PHPUnit configured in `phpunit.xml` to use an in-memory SQLite DB for fast CI runs.

Important workflows (concrete commands)
- Install & dev (Windows PowerShell):
  - composer install; copy `.env.example` to `.env`; `php artisan key:generate`
  - `php artisan migrate` (creates DB tables)
  - `npm install` then `npm run dev` (starts Vite)
- Run tests: `composer test` or `php artisan test` (phpunit.xml sets DB env to :memory:)
- Make storage public (serving user-uploaded files): `php artisan storage:link` (uses `public` disk per `config/filesystems.php`).

Project architecture & patterns (what to know)
- Typical Laravel MVC layout under `app/` and `resources/views/`:
  - Controllers: `app/Http/Controllers/*` (resourceful controllers used widely; see `routes/web.php`).
  - Models: `app/Models/*` are Eloquent models. Look for `$fillable` arrays to learn writable fields.
  - Views use Blade and a shared layout `resources/views/layout/base.blade.php` (most views `@extends('layout.base')`).
- Routing & auth:
  - `routes/web.php` registers resource routes for `formerStudents`, `researchers`, `documents`, `categories`.
  - Guest-only pages use `App\Http\Middleware\GuestMiddleware` (redirects authenticated users to route `home`).
  - Auth-protected actions are wrapped in `auth` middleware; e.g. `POST /profile/upload-photo` -> `ProfileController@updateProfilePhoto`.
- File uploads & storage conventions:
  - `config/filesystems.php` defines `public` disk mapped to `storage/app/public` and served at `/storage`.
  - Controller code uses `Storage::disk('public')` (see `app/Http/Controllers/ProfileController.php`) and model field `profile_photo_path` on `User` (`app/Models/User.php`).
  - Always run `php artisan storage:link` on new environments so `public` disk files are accessible.

Examples to follow (concrete code pointers)
- Update profile photo: `routes/web.php` and `app/Http/Controllers/ProfileController.php`.
  - Validate `profile_photo` input, store via `$request->file('profile_photo')->store('profile-photos', 'public')`, update `User::$fillable['profile_photo_path']`.
- Documents & categories: `app/Models/Document.php` has `$fillable = ['title','description','file_path','category_id']` and `category()` relation; controllers use resourceful CRUD routes.

Testing & CI notes
- PHPUnit config (`phpunit.xml`) sets DB to SQLite in-memory; tests assume no external DB. Use factories under `database/factories` for test data.

Conventions & gotchas
- Resource controllers: prefer using `Route::resource(...)` patterns found in `routes/web.php` rather than custom route definitions unless necessary.
- Blade layout: most pages `@extends('layout.base')`; search for `@section('content')` to find page bodies.
- Migrations: timestamps in `database/migrations` use recent dates; be careful when re-ordering migrations locally. Use `php artisan migrate:fresh --seed` if you need a clean DB.
- Local dev uses `composer` scripts: `composer run dev` will concurrently run `php artisan serve`, queue listener and vite (`dev` script in `composer.json`).

Where to look first when changing features
- Routes & middleware: `routes/web.php`, `app/Http/Middleware/*`.
- Controller logic: `app/Http/Controllers/*`.
- Model shape/relations: `app/Models/*` (check `$fillable` and relations like `Document::category`).
- Views & assets: `resources/views/**` and `resources/css`, `resources/js` (vite will rebuild on `npm run dev`).

If you make changes that affect file serving
- Ensure uploaded files use the `public` disk and that `storage:link` exists; update `config/filesystems.php` only if you understand how URLs are generated (`env('APP_URL').'/storage'`).

If unsure, ask for:
- Which environment should new migrations run against (local dev vs staging)?
- Should uploaded files be persisted to S3 (config present) or remain on local `public` disk?

End.
