<x-frontend.app-layout>
    <div class="dy-drawer">
        <div class="dy-drawer-content">
            <div class="grid grid-cols-1 gap-6">
                <x-frontend.catalog-product-list
                    title="Bikes Elétricas"
                    :products="$featuredTwo"
                />
            </div>

            <x-cms::frontend.cms-banner-component bannerLocal="banner_middle_home" limit="1" />

            <div class="grid grid-cols-1 gap-6">
                <x-frontend.catalog-product-list title="Patinetes Elétricos" :products="$featuredThree"/>
            </div>

        </div>
    </div>
</x-frontend.app-layout>
