@props(['title', 'subtitle' => ''])

<header class="header">
    <div>
        <h1 class="title">{{ $title }}</h1>
        @if($subtitle)
            <p class="subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    
    <div class="actions">
        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" placeholder="Buscar...">
        </div>
        
        <div class="profile">
            <div class="user-details">
                <p class="name">Admin</p>
                <p class="email">admin@herbolario.com</p>
            </div>
            <div class="avatar">A</div>
        </div>
    </div>
</header>
