<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="{{ $metaDescription ?? 'La Botica Natural — Productos botánicos artesanales, puros y sostenibles. Herbolario de confianza desde 1994.' }}">
<meta name="robots" content="index, follow">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural') }}">
<meta property="og:title" content="{{ $metaTitle ?? 'La Botica Natural — Herbolario Natural' }}">
<meta property="og:description" content="{{ $metaDescription ?? 'Productos botánicos artesanales, puros y sostenibles desde 1994.' }}">
@stack('meta')
<title>{{ $metaTitle ?? 'La Bótica Natural' }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="{{ asset('css/styleNavbarFooterAuth.css') }}" rel="stylesheet">
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/layout.js') }}"></script>
<link rel="icon" href="{{ asset('img/favicon.png') }}?v=1" type="image/png">