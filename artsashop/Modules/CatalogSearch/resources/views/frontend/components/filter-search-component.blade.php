<section class="order-builder" id="montar-pedido" aria-label="Montar pedido de exames">
    <div class="shell builder-grid">

        <div class="builder-panel">

            {{-- Categorias de Exames --}}
            <div class="catalog-tabs" aria-label="Categorias do pedido">
                <button class="catalog-tab active" type="button" data-category-id="0">Categorias</button>
                @foreach($categories as $category)
                <button
                    class="catalog-tab"
                    data-category-id="{{ $category['entity_id'] }}"
                >
                    {{ $category['category'] }}
                </button>
                @endforeach
            </div>

            <div class="exam-menu" id="catalog-menu">

            </div>
        </div>

    </div>
</section>
