<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Scholarchive</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="icon" href="{{ asset('images/lg.png') }}" type="image/png">
</head>
<body class="admin-dark">
    <div class="admin-layout">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main --}}
        <div class="main-content">
            {{-- Topbar --}}
            @include('components.topbar')

            {{-- Page Content --}}
            <div class="page-content">
                @if(session('error'))
                    <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#f87171;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:18px;height:18px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9-.75a9 9 0 1118 0 9 9 0 01-18 0zm9 3.75h.008v.008H12v-.008z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}?v={{ time() }}"></script>
</body>
</html>
