<span class="posted_in">Categorias:
    @foreach($categoriesTree as $categoryTree)
        <a href="{{ $categoryTree['url'] }}" rel="tag">{{ $categoryTree['name'] }}</a>@if(!$categoryTree['last']), @endif
    @endforeach
</span>
