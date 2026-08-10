@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 520px; margin: 0 auto;">
        <h1 style="margin-bottom: 14px; font-size: 1.75rem;">Register</h1>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="field">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus />
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required />
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required />
            </div>

            <div class="form-actions">
                <button type="submit" class="button">Create account</button>
                <a href="{{ route('login') }}" class="button secondary">Already have an account?</a>
            </div>
        </form>
    </div>
@endsection
