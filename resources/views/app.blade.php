<!DOCTYPE html>
<html lang="es">
    <head>
        @include('head')
        @stack('style')
    </head>
    <body>
        @php
            $activePromo = \App\Models\Promotion::where('is_active', true)
                ->where('show_on_web', true)
                ->where(function($q) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                })
                ->where(function($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                })
                ->orderBy('discount', 'desc')
                ->first();
        @endphp

        @if($activePromo)
            <div class="promo-announcement-bar">
                <span class="promo-icon"><i class="fa-solid fa-gift"></i></span>
                <span>
                    ¡PROMO ACTIVA! <strong>{{ $activePromo->name }}</strong>: Usa el cupón <strong class="promo-code">{{ $activePromo->code }}</strong> y obtén un <strong>{{ number_format($activePromo->discount, 0) }}% de descuento</strong> en tu compra.
                </span>
            </div>
        @endif

        @yield('navbar')

        <main>
            @yield('content')
        </main>

        @include('components.footer')

        @stack('scripts')
    </body>
</html>
