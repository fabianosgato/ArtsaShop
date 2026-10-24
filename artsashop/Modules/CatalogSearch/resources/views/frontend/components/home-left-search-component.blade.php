<aside class="sidebar" aria-label="Filtros">
    <form action="{{ route('catalogsearch.result') }}" method="get">
        <div class="filter-card">
            <div class="filter-title">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 7h16M7 12h10M10 17h4" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round"/>
                </svg>
                Otimizar busca
            </div>

            <div class="filter-group">
                <strong>Categoria</strong>

                @php
                    $selectedCategories = request()->input('exam-type');

                    if (is_string($selectedCategories)) {
                        $selectedCategories = [$selectedCategories];
                    }

                    $selectedCategories = is_array($selectedCategories)
                        ? $selectedCategories
                        : [];
                @endphp

                @foreach($categories as $category)
                    <label>
                        <span>{{ $category['category'] }}</span>

                        <input
                            name="exam-type[]"
                            value="{{ $category['entity_id'] }}"
                            type="checkbox"
                            data-category-filter="{{ $category['entity_id'] }}"
                            @checked(in_array(
                                (string) $category['entity_id'],
                                array_map('strval', $selectedCategories),
                                true
                            ))
                        />
                    </label>
                @endforeach
            </div>


            <div class="filter-group">
                <strong>Preço</strong>

                @php
                    $selectedPrice = request()->input('exam-prices');

                    if (!is_string($selectedPrice)) {
                        $selectedPrice = null;
                    }
                @endphp

                @foreach($prices as $price)

                    @php
                        $priceValue = $price['from'] . '-' . ($price['to'] ?? '');
                    @endphp

                    <label>
                        <span>{{ $price['label'] }}</span>

                        <input
                            name="exam-prices"
                            value="{{ $priceValue }}"
                            type="radio"
                            @checked($selectedPrice === $priceValue)
                        />
                    </label>

                @endforeach
            </div>

            <button
                type="submit"
                id="search-clinics"
                class="cart-action"
            >
                Filtrar
            </button>

        </div>
    </form>
</aside>
