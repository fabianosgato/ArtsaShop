<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">
        <div class="card card-primary">
            <div class="card-header">
                <h2>Meus Favoritos</h2>
            </div>
            <div class="card-body">
                @if($wishlistCatalogProducts)
                <ul class="products-grid row first last odd">
                    @foreach($wishlistCatalogProducts as $wishlistCatalogProduct)
                        <x-catalog::frontend.product-item-wishlist-component :catalogProduct="$wishlistCatalogProduct" />
                    @endforeach
                </ul>
                @else
                    Você ainda não possui nenhum produto favorito
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.link-wishlist', function (e) {
            e.preventDefault();

            const $button   = $(this);
            const productId = $button.data('product-id');

            if (!productId) {
                console.error('Product ID não encontrado.');
                return;
            }

            $.ajax({
                url: '{{ route('account.wishlist.remove') }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    // Remove o <li> do produto
                    const $productItem = $('#product-item-' + productId);

                    if ($productItem.length) {
                        $productItem.fadeOut(300, function () {
                            $(this).remove();
                        });
                    }
                },
                error: function (xhr) {
                    console.error('Erro ao remover dos favoritos', xhr.responseText);
                }
            });
        });
    </script>
</x-frontend.app-layout>
