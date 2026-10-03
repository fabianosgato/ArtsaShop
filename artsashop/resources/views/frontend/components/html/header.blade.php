<div id="sns_header" class="header">
    <div class="container">
        <div class="header-content">

            {{-- Logo --}}
            <div id="logo">
                @if(request()->routeIs('index.home'))
                    <h1 class="m-0">
                        <a href="{{ route('index.home') }}" class="logo">
                            <img
                                src="{{ asset('images/frontend/logo.webp') }}"
                                alt="{{ $currentStore->store_name }}"
                                width="120"
                                height="47"
                                loading="lazy"
                            />
                        </a>
                    </h1>
                @else
                    <a href="{{ route('index.home') }}" class="logo">
                        <img
                            src="{{ asset('images/frontend/logo.webp') }}"
                            alt="{{ $currentStore->store_name }}"
                            width="120"
                            height="47"
                            loading="lazy"
                        />
                    </a>
                @endif
            </div>

            {{-- Busca --}}
            <div class="header-search">
                @include('frontend.components.catalogsearch.form-mini')
            </div>

            {{-- Carrinho --}}
            <div class="header-cart">
                <x-checkout::top-cart-component />
            </div>

        </div>
    </div>
</div>
