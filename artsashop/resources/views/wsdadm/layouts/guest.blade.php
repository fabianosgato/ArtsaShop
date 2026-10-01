<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>WsdAdmin</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('images/wsdadm/favicon.ico') }}" type="image/x-icon"/>
        <link rel="shortcut icon" href="{{ asset('images/wsdadm/favicon.ico') }}" type="image/x-icon"/>
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/wsdadm/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/wsdadm/favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/wsdadm/favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/wsdadm/favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/wsdadm/favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/wsdadm/favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/wsdadm/favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/wsdadm/favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/wsdadm/favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/wsdadm/favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/wsdadm/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/wsdadm/favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/wsdadm/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('images/wsdadm/favicon/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('images/wsdadm/favicon/ms-icon-144x144.png') }}">

        @vite(['resources/css/wsdadm/app.css'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sidebar-dark-primary sm:pt-0">
            <div>
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </div>

            <div class="w-full sm:max-w-md bg-white dark:bg-gray-800 overflow-hidden">
                {{ $slot }}
            </div>
        </div>
        @vite(['resources/js/wsdadm/app.js'])
    </body>
</html>
