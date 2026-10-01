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

    {{--<x-frontend.banners-component />--}}
    <div id="sns_content">
        <div class="container">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 px-2">
                <aside class="lg:col-span-3">
                    @include('customers::frontend.account.left')
                </aside>
                <main class="lg:col-span-9">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    @include('frontend.components.html.footer')
    @include('frontend.components.html.before_body_end')

</section>
</body>
</html>
