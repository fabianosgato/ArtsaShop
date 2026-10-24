<section class="search-wrap" aria-label="Busca de exames">
    <div class="shell">
        <form
            action="{{ route('catalogsearch.result') }}"
            method="GET"
            class="search-panel" id="search-form"
            role="search"
            x-data="searchBox()"
        >
            <label class="field">
                <span class="field-label">O que</span>
                <input
                    type="text"
                    name="q"
                    id="exam-query"
                    value="{{ request('q') }}"
                    aria-label="O que buscar"
                    placeholder="O que você está procurando?"
                    autocomplete="off"
                />
            </label>

            <div class="field location-field">
                <label class="field-label" for="exam-location">Onde</label>
                <input id="exam-location" name="exam-location" type="text" value="{{ request('exam-location') }}" placeholder="Sua Cidade" aria-label="Local" />
{{--                <button class="use-location-button" type="button" data-action="use-current-location">Usar localização atual</button>--}}
            </div>

            <label class="field">
                <span class="field-label">Calendário</span>
                <input id="exam-date" name="exam-date" type="date" value="{{ request('exam-date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" aria-label="Data do exame" />
            </label>

            <label class="field">
                <span class="field-label">Tipo</span>
                <select id="exam-type" name="exam-type" aria-label="Tipo de exame">
                    <option value="">Todos</option>
                    @foreach($categories as $category)
                        @if(request('exam-type') == $category['entity_id'])
                            <option value="{{ $category['entity_id'] }}" selected>{{ $category['category'] }}</option>
                        @else
                            <option value="{{ $category['entity_id'] }}">{{ $category['category'] }}</option>
                        @endif

                    @endforeach
                </select>
            </label>

            <button class="search-button" type="submit" aria-label="Buscar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="m21 21-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" />
                </svg>
            </button>
        </form>

    </div>
</section>
