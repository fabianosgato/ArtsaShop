<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel='stylesheet' id='{{app('currentStore')->code}}-shop-styles' href='{{ asset('css/frontend/styles.css') }}' type='text/css' media='all' />
    <link rel='stylesheet' id='{{app('currentStore')->code}}-shop-styles' href='{{ asset('css/frontend/responsive.css') }}' type='text/css' media='all' />
    <link rel='stylesheet' id='{{app('currentStore')->code}}-shop-theme' href='{{ asset('css/frontend/theme/buttons.css') }}' type='text/css' media='all' />

    @inertiaHead
    @vite([
        'resources/css/frontend/app.css',
        'resources/js/frontend/app.ts'
    ])
    @routes
</head>
<body>
    @inertia
</body>
</html>
