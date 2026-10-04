<!DOCTYPE html>
<html lang="pt-br">
<head>
    @include('frontend.components.html.head')
</head>
<body>
<section class="wrapper">
    @include('frontend.components.html.header-top')
    @include('frontend.components.html.header')
    @include('frontend.components.catalog.navigation')
    <x-frontend.breadcrumbs-component/>

    <div class="content">
        <div class="container">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <main class="lg:col-span-9">
                    {{ $slot }}
                </main>
                <aside class="lg:col-span-3">
                    @include('frontend.components.catalog.navigation.left')
                </aside>
            </div>
            {{-- Drawer container vazio --}}
            <div class="dy-drawer-side lg:hidden z-40 pt-[96px] h-[calc(100vh-96px)]">
                <label for="mobile-categories" class="dy-drawer-overlay"></label>
                <div id="mobile-menu-container" class="w-72 bg-white min-h-full border-r p-4"></div>
            </div>
        </div>

    </div>

    @include('frontend.components.html.footer')
    @include('frontend.components.html.before_body_end')

</section>
</body>
</html>
