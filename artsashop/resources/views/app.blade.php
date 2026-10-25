<!DOCTYPE html>
<html>
<head>
    @include('frontend.partials.html.head')
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body>
<section class="wrapper">
@inertia
</section>
</body>
</html>
