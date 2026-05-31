@props(['title', 'subtitle' => ''])

@php
    $admin = Auth::guard('admin')->user();
@endphp

<header class="header">
    <div>
        <h1 class="title">{{ $title }}</h1>
        @if($subtitle)
            <p class="subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    
    <div class="actions">
        <div class="profile">
            <div class="user-details">
                <p class="name">{{ $admin->name ?? 'Admin' }}</p>
                <p class="email">{{ $admin->email ?? 'admin@boticanatural.es' }}</p>
            </div>
            <div class="avatar">{{ substr($admin->name ?? 'A', 0, 1) }}</div>
        </div>
    </div>
</header>
