<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Inventory System') }}</title>
        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>
    <body>
        <div class="container">
            @include('layouts.Topbar')

            <div class="sidebar-wrapper">
                @include('layouts.sidebar')
                <div class="main-content">
                    @if(isset($pageTitle))
                        <h1>{{ $pageTitle }}</h1>
                    @endif
                    @if(session('success'))
                        <div class="flash">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="errors">
                            <strong>There were some problems with your input.</strong>
                            <ul style="margin: 12px 0 0 18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
