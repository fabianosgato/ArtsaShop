<x-frontend.app-layout layout="2columns-product">
    <div class="product-view">

        <div class="product-name">
            <h1>{{ $product['name'] }}</h1>
        </div>

        <div class="product-essential">
            <form action="{{ route('checkout.addTo') }}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                <input type="hidden" name="qty" value="1">
                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex flex-col lg:flex-row gap-8">

                    <div class="product-img-box lg:w-5/12 w-full">
                        <x-catalog::product-image-component :product="$product" />
                    </div>
                    <div class="product-shop lg:w-7/12 w-full">
                        <div class="short-description">
                            {!! $product['short_description'] !!}
                        </div>
                        <div class="is-divider"></div>

                        @if($product['status_key'] == 'in-stock')
                        <x-catalog::product-prices-component :product="$product"  />
                        @endif

                        <div class="product-brand mt-4">
                            <a href="{{ url($product['brand_key']) }}"><strong>{{$product['brand_name']}}</strong> - Ver todos os produtos desta marca</a>
                        </div>

                        <div class="actions mt-6">
                        @if($product['status_key'] == 'in-stock')
                        <div class="add-to-cart">
                            <button type="submit" id="product-addtocart-button" class="button btn-cart" data-original-title="Adicionar ao carrinho" rel="tooltip"><span><span>Adicionar ao carrinho</span></span></button>
                            <ul class="add-to-links mt-3">
                                <li class="add-to-favorites">
                                    <x-catalog::product-wishlist-component productId="{{$product['product_id']}}" />
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="p-4 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-lg" role="alert">

                            <div class="flex items-start gap-3">

                                <svg class="flex-shrink-0 mt-1" width="24" height="24" role="img" aria-label="Warning:">
                                    <use xlink:href="#exclamation-triangle-fill"/>
                                </svg>

                                <div class="flex-1">
                                    <p class="font-semibold text-base">
                                        Produto indisponível no momento
                                    </p>

                                    <p class="text-sm mt-1">
                                        Este item está temporariamente fora de estoque, mas podemos verificar disponibilidade, prazos ou até uma alternativa para você.
                                    </p>
                                </div>
                            </div>

                        </div>
                        @endif
                        </div>

                        <div class="advisored mt-6">
                            <h3 style="text-align: center;"><strong>Ambiente de demonstração!</strong></h3>
                            <p>O ArtsaShop é um projeto de demonstração de uma plataforma de e-commerce. Os produtos apresentados nesta loja são utilizados exclusivamente para testes e apresentação das funcionalidades do sistema.</p>
                            <p><strong>Atenção:</strong> Nenhuma compra realizada será efetivamente processada ou aprovada. Os dados e produtos exibidos neste ambiente têm finalidade exclusivamente demonstrativa.</p>
                        </div>

                        <div class="product_meta mt-6">
                            <div class="sku_wrapper">
                                <span class="sku">{{ $product['sku'] }}</span>
                            </div>
                            <x-catalog::frontend.product-categories-component :catalogProduct="$product" />
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if($product['video_url'] != '')
            <div class="embed-container mt-8">
                <div class="aspect-video w-full">
                    <iframe
                        class="w-full h-full"
                        src="{{ str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $product['video_url']) }}"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        @endif

        <div class="product-tabs-content mt-12" x-data="{ tab: 'description' }">

            <div class="product-collateral">

                <div class="flex border-b mb-6">
                    <button @click="tab='description'"
                            :class="tab === 'description' ? 'border-b-2 border-black font-semibold' : ''"
                            class="px-4 py-2">
                        Descrição do produto
                    </button>

                    <button @click="tab='additional'"
                            :class="tab === 'additional' ? 'border-b-2 border-black font-semibold' : ''"
                            class="px-4 py-2">
                        Informações adicionais
                    </button>

                    <button @click="tab='reviews'"
                            :class="tab === 'reviews' ? 'border-b-2 border-black font-semibold' : ''"
                            class="px-4 py-2">
                        Reviews
                    </button>
                </div>

                {{-- DESCRIÇÃO --}}
                <div x-show="tab === 'description'">
                    <div class="std">
                        {!! nl2br($product['description']) !!}
                    </div>
                </div>

                {{-- INFORMAÇÕES ADICIONAIS --}}
                <div x-show="tab === 'additional'" x-cloak>
                    <h2 class="mb-6">Informações adicionais</h2>

                    @foreach([
                        'Peso' => $product['weight'],
                        'Altura' => $product['height'],
                        'Length' => $product['length'],
                        'Comprimento' => $product['width']
                    ] as $label => $value)

                        <div class="flex flex-col sm:flex-row justify-between border-b py-3">
                            <div>{{ $label }}</div>
                            <div>{{ $value }}</div>
                        </div>

                    @endforeach
                </div>

                {{-- REVIEWS --}}
                <div x-show="tab === 'reviews'" x-cloak>
                    <div class="box-collateral box-reviews" id="customer-reviews">

                        <div class="flex flex-col md:flex-row gap-10">

                            <div class="md:w-1/2">
                                <h2>Opiniões do cliente</h2>
                                <dl></dl>
                            </div>

                            <div class="md:w-1/2">
                                <div id="review-form" class="form-add">
                                    <div class="page-title title-buttons">
                                        <h3>Escrever uma avaliação</h3>
                                    </div>
                                    <p class="review-nologged">
                                        Apenas usuarios registrados pode escrever reviews.
                                        Por favor, <a href="customer/account/login">Entre</a> ou
                                        <a href="customer/account/create/">Registre-se</a>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div class="product-collateral mt-16">
        <x-catalog::related-products-component attributeSetId="{{$product['attribute_set_id']}}" />
    </div>
</x-frontend.app-layout>
