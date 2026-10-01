<x-frontend.app-layout layout="2columns-right">
    <div class="cms-pages">
        <div class="page-title title-buttons">
            <h1>{{ $page['title'] }}</h1>
        </div>
        <div>
            {!! str($page['content'])->sanitizeHtml() !!}
        </div>
    </div>
</x-frontend.app-layout>
