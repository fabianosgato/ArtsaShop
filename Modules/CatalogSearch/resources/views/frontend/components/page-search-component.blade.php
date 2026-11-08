<section class="search-band">
    <div class="shell">
        <form class="compact-search"
              action="{{ route('catalogsearch.result') }}"
              method="GET"
              id="search-form"
              role="search"
              x-data="searchBox()"
        >
            <label class="field">
                <span>Filtros</span>
                <input
                    name="q"
                    id="exam-query"
                    value="{{ request('q') }}"
                    aria-label="O que buscar"
                    placeholder="O que você está procurando?"
                    autocomplete="off"
                />
            </label>

            <label class="field">
                <span>Categorias</span>
                <select id="exam-type" name="exam-type" aria-label="Tipo de exame">
                    <option value="">Todos</option>
                    @foreach($categories as $category)
                        @if($catalogCategory->parent_id == $category['entity_id'])
                            <option value="{{ $category['entity_id'] }}" selected>{{ $category['category'] }}</option>
                        @else
                            <option value="{{ $category['entity_id'] }}">{{ $category['category'] }}</option>
                        @endif
                    @endforeach
                </select>
            </label>
            <button class="button" type="submit">Atualizar busca</button>
        </form>
    </div>
</section>
