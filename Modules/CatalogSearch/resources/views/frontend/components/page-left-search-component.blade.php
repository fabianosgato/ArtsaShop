<aside class="block-layered-nav">
    <div class="filter-head">
        <h2>Filtros</h2>
    </div>
    <form
        action="{{ $searchAction }}"
        method="GET"
        class="search-panel" id="search-form"
        role="search"
        x-data="searchBox()"
    >
        @if(isset($category['id']))
            <input type="hidden" name="category" value="{{ $category }}">
        @endif

        @if($categories)
        <fieldset class="filter-group">
            <legend>Categoria</legend>
            <ol>
                @foreach($categories as $category)
                <li><a href="{{ url($category['slug_key']) }}" class="check-row"><span>{{ $category['category'] }}</span></a></li>
                @endforeach
            </ol>
        </fieldset>
        @endif

        <fieldset class="filter-group">
            <legend>Preço</legend>
            <ol>
            @foreach($prices as $price)
                <li><label class="check-row"><input name="prices[]" value="{{$price['from']}}-{{ $price['to'] ?? ''}}" type="checkbox" /> <span>{{ $price['label'] }}</span></label></li>
            @endforeach
            </ol>
        </fieldset>

        <fieldset class="filter-group">
            <button  class="btn btn-forms" type="submit">Atualizar busca</button>
        </fieldset>
    </form>
</aside>
