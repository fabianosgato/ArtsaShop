<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Produtos Vendidos
        </h2>
    </header>
    <div class="flex items-center">
        <table class="w-full border-collapse">
            <thead class="border-b">
                <tr>
                    <th class="py-2 px-2"></th>
                    <th class="py-2 px-2 text-sm text-left">ASIN</th>
                    <th class="py-2 px-2 text-sm text-left">SKU</th>
                    <th class="py-2 px-2 text-sm text-left">Produto</th>
                    <th class="py-2 px-2 text-sm text-left">Qty</th>
                    <th class="py-2 px-2 text-sm text-left">Preço Marketplace</th>
                    <th class="py-2 px-2 text-sm text-left">Preço Final Marketplace</th>
                    <th class="py-2 px-2 text-sm text-left">Preço Venda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="hover:bg-gray-200">
                        <td class="py-2 px-2">
                            <img src="{{$product['image']}}" width="80">
                        </td>
                        <td class="py-2 px-2 text-gray-700 text-sm">
                            <a href="{{ route('wsdadm.catalog.products.edit', ['id' => $product['product_id']]) }}"><span class="text-blumine-500">{{$product['product_sku']}}</span></a>
                        </td>
                        <td class="py-2 px-2 text-gray-700 text-sm">
                            {{$product['product_sku']}}
                        </td>
                        <td class="py-2 px-2 text-gray-700 text-sm">
                            {{$product['product_name']}}
                        </td>
                        <td class="py-2 px-2 text-red-500 text-sm">
                            <strong>{{$product['qty_ordered']}}</strong>
                        </td>
                        <td class="py-2 px-2 text-gray-700 text-sm">
                            {{number_format($product['price'], 2, ',', '.')}}
                        </td>
                        <td class="py-2 px-2 text-gray-700 text-sm">
                            {{number_format($product['final_price'], 2, ',', '.')}}
                        </td>
                        <td class="py-2 px-2 text-gray-700 text-sm">
                            {{number_format($product['sales_price'], 2, ',', '.')}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>


</section>
