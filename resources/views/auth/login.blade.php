@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 480px; margin: 0 auto;">
        <h1 style="margin-bottom: 14px; font-size: 1.75rem;">Login</h1>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus />
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required />
            </div>

            <div class="field">
                <label>
                    <input type="checkbox" name="remember" /> Remember me
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="button">Login</button>
                <a href="{{ route('register') }}" class="button secondary">Create account</a>
            </div>
        </form>
    </div>
@endsection
