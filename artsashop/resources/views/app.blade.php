<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    @include('frontend.partials.head')
    @routes
    @viteReactRefresh
    @vite('resources/js/app.jsx')

    <x-inertia::head />
</head>
<body>
<section class="wrapper">
    <div class="content">
        <div class="container">
            <div class="grid-cols-1 gap-2 lg:grid-cols-1 px-2 justify-center">
                <main class="lg:col-span-9 py-6">
                <x-inertia::app />
                </main>
            </div>
        </div>
    </div>
</section>
</body>
</html>
