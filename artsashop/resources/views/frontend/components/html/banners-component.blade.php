<div class="banner-marketplace">
    <div class="container">
        {{--BANNER PRINCIPAL--}}
        <x-cms::frontend.cms-banner-component bannerLocal="banner_main_top" limit="5" />

        {{-- MINI BANNERS (ESTILO SHOPEE)--}}
        <div class="hidden lg:flex lg:col-span-3 flex-col gap-4">
        <x-cms::frontend.cms-banner-component bannerLocal="banner_main_upper" limit="1" />
        <x-cms::frontend.cms-banner-component bannerLocal="banner_main_bottom" limit="1" />
        </div>
    </div>
</div>
