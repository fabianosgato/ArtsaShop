<!DOCTYPE html>
<html lang="pt-br">
<head>
    @include('frontend.components.html.head')
</head>
<body>
<section id="sns_wrapper">
    @include('frontend.components.html.sns_topheader')
    @include('frontend.components.html.sns_header')
    @include('frontend.components.catalog.navigation')
    <x-frontend.breadcrumbs-component />
    {{--<x-frontend.banners-component />--}}

    <div id="sns_content">
        <div class="container">
            <div class="py-0">
                {{ $slot }}
            </div>
        </div>
    </div>
    @include('frontend.components.html.footer')
    @include('frontend.components.html.before_body_end')
</section>
</body>
</html>
