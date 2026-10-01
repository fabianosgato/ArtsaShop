<meta charset="UTF-8">
<x-frontend.page-meta-component/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('images/ms-icon-144x144.png') }}">

{{-- Scripts Necessarios --}}
{{--<script>--}}
{{--    window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;--}}
{{--</script>--}}

<!-- Google Analytics -->
{{--<script async src="https://www.googletagmanager.com/gtag/js?id=G-5915NS7C5H"></script>--}}
{{--<script> window.dataLayer = window.dataLayer || [];--}}
{{--    function gtag() {--}}
{{--        dataLayer.push(arguments);--}}
{{--    }--}}
{{--    gtag('js', new Date());--}}
{{--    gtag('config', 'G-5915NS7C5H', {page_path: window.location.pathname,});--}}
{{--</script>--}}

@vite([
    'resources/css/frontend/app.css',
])

@livewireStyles

{{--<link rel='stylesheet' id='{{app('currentStore')->code}}-shop-styles' href='{{ asset('css/frontend/theme/assets/bootstrap/css/bootstrap.css') }}' type='text/css' media='all' />--}}
{{--<link rel='stylesheet' id='{{app('currentStore')->code}}-shop-styles' href='{{ asset('css/frontend/theme/assets/bootstrap/css/responsive.css') }}' type='text/css' media='all' />--}}
<link rel='stylesheet' id='{{app('currentStore')->code}}-shop-styles' href='{{ asset('css/frontend/styles.css') }}' type='text/css' media='all' />
<link rel='stylesheet' id='{{app('currentStore')->code}}-shop-theme' href='{{ asset('css/frontend/theme/theme-orange.css') }}' type='text/css' media='all' />
<link rel='stylesheet' id='{{app('currentStore')->code}}-shop-theme' href='{{ asset('css/frontend/theme/buttons.css') }}' type='text/css' media='all' />
{{--<link rel='stylesheet' id='{{app('currentStore')->code}}-shop-theme' href='{{ asset('css/frontend/theme/sns-responsive.css') }}' type='text/css' media='all' />--}}
