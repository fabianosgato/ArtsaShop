<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @inertiaHead
    @viteReactRefresh
    @vite(['resources/css/frontend/app.css', 'resources/js/frontend/app.ts'])
</head>
<body>
    @inertia
</body>
</html>
