<div
    x-data="{ open: false }"
    @mouseenter="if (window.innerWidth >= 768) open = true"
    @mouseleave="if (window.innerWidth >= 768) open = false"
    class="top-cart-wrapper"
>

    {{-- BOTÃO --}}
    <div
        @click="if (window.innerWidth < 768) open = !open"
        class="top-cart-trigger"
    >
        <div class="top-cart-icon">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"
                />
            </svg>

            <span class="top-cart-label">
                Carrinho
            </span>

            {{-- Badge quantidade --}}
            <span id="top-cart-qtd" class="top-cart-qtd">
                {{ !empty($cart['items']) ? count($cart['items']) : 0 }}
            </span>

        </div>
    </div>


    {{-- DROPDOWN --}}
    <div
        x-show="open"
        x-transition.origin.top.right
        @click.away="open = false"
        x-cloak
        class="top-cart-content{{ count($cart['items']) == 0 ? ' hidden' : '' }}"
    >

        <div class="top-cart-inner">

            <div class="top-cart-items">

                <ol class="cart-sidebar">

                    @foreach($cart['items'] as $item)

                        <li class="cart-item">

                            <a
                                href="{{ url($item['product']['slug_key']) }}"
                                title="{{ $item['product']['name'] }}"
                                class="cart-item-image"
                            >
                                <img
                                    src="{{ $item['product']['image'] }}"
                                    alt="{{ $item['product']['name'] }}"
                                >
                            </a>

                            <div class="cart-item-details">

                                <p class="cart-item-name">
                                    <a href="{{ url($item['product']['slug_key']) }}">
                                        {{ $item['product']['name'] }}
                                    </a>
                                </p>

                                <span class="price">
                                    R$ {{ Number::format($item['subtotal'], 2, locale: 'pt_BR') }}
                                </span>

                            </div>

                        </li>

                    @endforeach

                </ol>

            </div>


            {{-- Subtotal --}}
            <div class="top-subtotal">
                <span>Subtotal</span>
                <span id="top-cart-subtotal-fmt">
                    R$ <span class="price">
                        {{ number_format($cart['subtotal'], 2, ',', '.') }}
                    </span>
                </span>
            </div>


            {{-- Ações --}}
            <div class="top-cart-actions">

                <a
                    href="{{ route('checkout.cart') }}"
                    class="top-cart-button top-cart-button-cart"
                >
                    Ver Carrinho
                </a>

                <a
                    href="{{ route('checkout.onepage.index') }}"
                    title="Finalizar compra"
                    class="top-cart-button top-cart-button-checkout"
                >
                    Finalizar compra
                </a>

            </div>

        </div>

    </div>

</div>
