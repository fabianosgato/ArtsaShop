<aside class="flex flex-col main-sidebar">
    <div class="h-20">
        <a href="{{ route('wsdadm.dashboard') }}" class="brand-link">
            <img src="{{ asset('images/wsdadm/logo_menu.png') }}" alt="WsdAdm" class="brand-image">
        </a>
        <div class="flex pt-3.5">
            <nav class="flex-1 flex-col">
                <livewire:menu-builder-component />
            </nav>
        </div>
    </div>
</aside>
