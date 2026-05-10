@extends('app')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
@endpush

@section('navbar')
    <nav class="glass-nav">
        <div class="container nav-container">
            <!-- Brand -->
            <a href="/" class="nav-logo">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>LA BOTICA NATURAL</span>
            </a>

            <!-- Menu -->
            <ul class="nav-menu">
                <li><a href="/catalogo" class="nav-link">Catálogo</a></li>
                <li><a href="/catalogo" class="nav-link">Infusiones</a></li>
                <li><a href="/catalogo" class="nav-link">Cosmética</a></li>
                <li><a href="/catalogo" class="nav-link">Aceites</a></li>
            </ul>

            <!-- Actions -->
            <div class="nav-actions">
                <div class="search-container">
                    <input type="text" placeholder="Buscar..." class="search-input">
                    <i class="fas fa-search" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); opacity: 0.4; font-size: 0.75rem;"></i>
                </div>
                <a href="/perfil"><i class="far fa-user"></i></a>
                <a href="/carrito" style="position: relative;">
                    <i class="fas fa-shopping-bag"></i>
                    <span style="position: absolute; top: -8px; right: -8px; background: var(--brand-green); color: white; font-size: 10px; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">2</span>
                </a>
            </div>
        </div>
    </nav>
@endsection



@section('content')
    @yield('main_content')
@endsection