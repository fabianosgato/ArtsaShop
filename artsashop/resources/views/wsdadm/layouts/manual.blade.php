<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WsdAdmin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

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

    @filamentStyles
    @livewireStyles

    <style type="text/css">

    </style>

</head>
<body>
<div class="wrapper">
    <div class="min-h-screen bg-wsadmin-950">

        @include('wsdadm.manual.aside')

        <div class="ml-64 min-w-0 bg-primary-50 dark:bg-blumine-800">

            <div class="flex">
                @include('wsdadm.layouts.navigation')
            </div>

            <main class="content-wrapper !ml-0 !w-auto">
                {{ $header }}
                {{ $slot }}
            </main>

        </div>

    </div>

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-{{ date('Y') }} <a href="https://adminlte.io">Examix</a>.</strong>
        Todos os direitos reservados.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 2.1.0
        </div>
    </footer>

    <div id="rightpad"></div>

</div>

@livewire('notifications')

<!-- 4. Scripts organizados antes do JS principal -->
@livewireScripts
@filamentScripts

<!-- 5. O Javascript do seu projeto fecha o carregamento -->
@vite(['resources/js/wsdadm/app.js'])

<wireui:scripts/>
</body>
</html>
