<ul class="px-0 py-2">
    @foreach($categories as $category)
        @include('frontend.components.catalog.navigation.vertical-menu-node', ['category' => $category])
    @endforeach
</ul>
