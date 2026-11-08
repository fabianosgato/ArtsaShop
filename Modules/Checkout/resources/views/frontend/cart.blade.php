<x-frontend.app-layout layout="1column">
    <div class="cart">
        <div class="page-title title-buttons">
            <h1>Carrinho de compras</h1>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded bg-red-100 text-red-700 text-sm">
                {{ session('error') }}
            </div>
        @endif

    @if(count($cart['items']) > 0)
        <form action="{{ route('checkout.cart.updatePost') }}" method="post">
            <div class="max-w-10xl max-lg:max-w-4xl mx-auto p-1">
                <div class="grid lg:grid-cols-3 gap-4 relative mt-6">

                    {{-- bloco do carrinho --}}
                    <div class="lg:col-span-2 space-y-4">

                        @foreach($cart['items'] as $item)
                            <div class="p-6 bg-white shadow-sm border border-gray-300 relative product-item">
                                <div class="flex items-center max-sm:flex-col gap-4 max-sm:gap-6">
                                    {{-- imagem do produto --}}
                                    <div class="w-52 h-52 shrink-0">
                                        <a href="{{ url($item['product']['slug_key']) }}" title="{{$item['product']['name']}}">
                                            <img
                                                class="w-full h-full object-contain"
                                                src="{{$item['product']['image']}}" alt="{{$item['product']['name']}}"
                                            />
                                        </a>
                                    </div>

                                    {{-- Informações do produto --}}
                                    <div class="sm:border-l sm:pl-4 sm:border-gray-300 w-full">
                                        <h3 class="text-base">{{$item['product']['name']}}</h3>
                                        <ul class="mt-4 text-sm text-slate-500 font-medium space-y-2">
                                            <li>{{$item['product']['sku']}}</li>
                                            <li><span class="cart-price">Preço unitário: <span class="price">R$ {{ Number::format($item['price'], 2, locale: 'pt_BR') }}</span></span></li>
                                            <li><a href="{{ url($item['product']['slug_key']) }}" class="text-blumine-600">Ver Produto</a></li>
                                        </ul>
                                        <hr class="border-gray-300 my-4"/>

                                        <div class="flex items-center justify-between flex-wrap gap-4">
                                            <div class="flex items-center gap-4 cart-qty" data-product-id="{{ $item['product_id'] }}">
                                                <h4 class="text-sm font-semibold text-slate-900">Qtd:</h4>
                                                <button type="button" class="qty-decrease flex items-center justify-center w-[18px] h-[18px] bg-blue-600 outline-none rounded-sm cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-white" viewBox="0 0 124 124">
                                                        <path d="M112 50H12C5.4 50 0 55.4 0 62s5.4 12 12 12h100c6.6 0 12-5.4 12-12s-5.4-12-12-12z" data-original="#000000"></path>
                                                    </svg>
                                                </button>
                                                <span class="cart-item-qty font-semibold text-base leading-[16px]">{{ $item['qty'] }}</span>
                                                <button type="button"
                                                        class="qty-increase flex items-center justify-center w-[18px] h-[18px] bg-blue-600 outline-none rounded-sm cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2 fill-white"
                                                         viewBox="0 0 42 42">
                                                        <path
                                                            d="M37.059 16H26V4.941C26 2.224 23.718 0 21 0s-5 2.224-5 4.941V16H4.941C2.224 16 0 18.282 0 21s2.224 5 4.941 5H16v11.059C16 39.776 18.282 42 21 42s5-2.224 5-4.941V26h11.059C39.776 26 42 23.718 42 21s-2.224-5-4.941-5z"
                                                            data-original="#000000"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="flex items-center">
                                                <h4 class="text-base font-semibold text-slate-900">R$ {{ Number::format($item['subtotal'], 2, locale: 'pt_BR') }}</h4>
                                                <button type="button" class="btn-remove-item" data-product-id="{{ $item['product_id'] }}" >
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="w-3 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500 absolute top-3.5 right-3.5"
                                                         viewBox="0 0 320.591 320.591">
                                                        <path
                                                            d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                                                            data-original="#000000"></path>
                                                        <path
                                                            d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                                                            data-original="#000000"></path>
                                                    </svg>

                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach
                        <div class="mt-8 space-y-4">

                            <a href="{{ route('checkout.clear') }}" title="Limpar Carrinho" class="btn btn-default"><span><span>Limpar Carrinho</span></span></a>
                        </div>
                    </div>

                    <div class="bg-white h-max p-6 shadow-sm border border-gray-300 sticky top-0">
                        <h3 class="text-base font-semibold text-slate-900">Resumo do Pedido</h3>
                        <ul class="text-slate-500 font-medium text-sm divide-y divide-gray-300 mt-4">
                            <li class="flex flex-wrap gap-4 py-3">Subtotal <span class="ml-auto font-semibold text-slate-900">R$ {{ number_format($cart['subtotal'], 2, ',', '.') }}</span></li>
                            <li class="flex flex-wrap gap-4 py-3">Envio <span class="ml-auto font-semibold text-slate-900"> Grátis</span></li>
                            @if($cart['payment_method'] == 'pix')
                                <li class="flex flex-wrap gap-4 py-3 font-semibold text-slate-900">Sub-total <span class="ml-auto">R$ {{ number_format($cart['subtotal'], 2, ',', '.') }}</span></li>
                                <li class="flex flex-wrap gap-4 py-3 font-semibold text-slate-900">Desconto de 10% no PIX <span class="ml-auto"> - R$ {{ number_format($cart['discount_amount'], 2, ',', '.') }}</span></li>
                                <li class="flex flex-wrap gap-4 py-3 font-semibold text-slate-900">Total <span class="ml-auto">R$ {{ number_format($cart['grand_total'], 2, ',', '.') }}</span></li>
                            @else
                                <li class="flex flex-wrap gap-4 py-3 font-semibold text-slate-900">Total <span class="ml-auto">R$ {{ number_format($cart['subtotal'], 2, ',', '.') }}</span></li>
                            @endif
                        </ul>

                        <a href="{{ route('checkout.onepage.index') }}"
                           title="Finalizar compra"
                           class="mt-6 text-xl font-medium px-4 py-2.5 tracking-wide w-full btn btn-success btn-checkout"
                        >
                            Finalizar compra
                        </a>
                        <a href="{{ route('index.home') }}"
                           title="Continuar comprando"
                           class="mt-6 text-xl font-medium px-4 py-2.5 tracking-wide w-full btn btn-forms">
                                Continuar comprando
                        </a>
                    </div>

                </div>
            </div>

        </form>

    @else
        <div class="cart-empty">
            <p>Seu Carrinho está vazio no momento.</p>
            <p>Click <a href="{{ route('index.home') }}">aqui</a> para continuar a comprar.</p>
        </div>
    @endif
    </div>

</x-frontend.app-layout>
