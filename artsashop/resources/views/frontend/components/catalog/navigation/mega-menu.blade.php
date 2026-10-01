<div id="sns_menu" x-data="{ activeMenu: null }">
    <div class="inner">

        <div
            class="container"
            @mouseleave="activeMenu = null"
        >

            <ul class="menu">
                @foreach($categories as $category)
                    @if($category['has_products'])

                        <li class="menu-item">

                            <a
                                href="{{ url($category['slug_key']) }}"
                                class="menu-link"
                                @mouseenter="activeMenu = {{ $category['entity_id'] }}"
                            >
                                {{ $category['category'] }}
                            </a>

                        </li>

                    @endif
                @endforeach
            </ul>


            {{-- Mega Menus --}}
            @foreach($categories as $category)
                @if($category['has_products'] && $category['has_children'])

                    <div
                        class="mega-menu"
                        x-show="activeMenu === {{ $category['entity_id'] }}"
                    >
                        <div class="mega-menu-grid">

                            @foreach($category['children'] as $child)

                                <a
                                    href="{{ url($child['slug_key']) }}"
                                    class="mega-menu-link"
                                >
                                    {{ $child['category'] }}
                                </a>

                            @endforeach

                        </div>
                    </div>

                @endif
            @endforeach

        </div>

    </div>
</div>
