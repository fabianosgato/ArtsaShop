<div class="form-search">
    <form
        action="{{ route('catalogsearch.result') }}"
        method="GET"
        role="search"
        x-data="searchBox()"
    >
        <div class="search-container">

            <div class="search-input-wrapper">

                <input
                    type="text"
                    name="q"
                    x-model="query"
                    @input.debounce.400ms="search()"
                    @focus="open = products.length > 0"
                    @click.away="open = false"
                    value="{{ request('q') }}"
                    placeholder="O que você está procurando?"
                    autocomplete="off"
                    class="search-input"
                >

                <div class="search-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"
                        />
                    </svg>
                </div>

            </div>

            {{-- Resultados --}}
            <div
                x-show="open"
                x-transition
                class="search-results"
            >

                <template x-if="loading">
                    <div class="search-message">
                        Buscando resultados...
                    </div>
                </template>

                <template x-if="!loading && products.length === 0">
                    <div class="search-message">
                        Nenhum produto encontrado.
                    </div>
                </template>

                <template x-for="product in products" :key="product.url">

                    <a
                        :href="product.url"
                        class="search-result"
                    >
                        <img
                            :src="product.image"
                            :alt="product.name"
                            class="search-result-image"
                        >

                        <span
                            x-text="product.name"
                            class="search-result-name"
                        ></span>
                    </a>

                </template>

                <template x-if="total > 5">

                    <a
                        :href="resultsUrl"
                        class="search-results-all"
                    >
                        Ver todos os produtos
                    </a>

                </template>

            </div>

        </div>
    </form>
</div>
