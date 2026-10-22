<div
    id="sns_menu"
    x-data="{
        open: false,
        activeDepartment: {{ ($firstDepartment = collect($categories)->first(fn ($category) => $category['has_products']))['entity_id'] ?? 'null' }},
        mobileDetail: false,

        selectDepartment(id) {
            this.activeDepartment = id;

            if (window.matchMedia('(max-width: 768px)').matches) {
                this.mobileDetail = true;
            }
        },

        closeMenu() {
            this.open = false;
            this.mobileDetail = false;
        }
    }"
    @keydown.escape.window="closeMenu()"
    @click.outside="closeMenu"
>
    <div class="inner">
        <div class="container">

            <ul class="menu" aria-label="Navegação de departamentos">

                <li class="departments-menu-item">
                    <button
                        type="button"
                        class="departments-trigger"
                        @click="open = !open; mobileDetail = false"
                        :aria-expanded="open"
                    >
                        <span class="departments-trigger-icon" aria-hidden="true">☰</span>
                        <span>Departamentos</span>
                    </button>
                </li>

                @foreach($categories as $category)
                    @if($category['has_products'])

                        <li class="menu-item">
                            <a
                                href="{{ url($category['slug_key']) }}"
                                class="menu-link"
                                @mouseenter="
                                    activeDepartment = {{ $category['entity_id'] }};
                                    open = true;
                                    mobileDetail = false
                                "
                            >
                                {{ $category['category'] }}
                            </a>
                        </li>

                    @endif
                @endforeach

            </ul>

            <div
                class="departments-panel"
                x-show="open"
                x-cloak
                x-transition.opacity.duration.150ms
                @mouseenter="open = true"
            >

                <div class="departments-list">

                    <div class="departments-list-header">
                        <span>Todos os departamentos</span>
                    </div>

                    @foreach($categories as $category)
                        @if($category['has_products'])

                            <button
                                type="button"
                                class="department-item"
                                :class="{ 'is-active': activeDepartment === {{ $category['entity_id'] }} }"
                                @mouseenter="selectDepartment({{ $category['entity_id'] }})"
                                @click="selectDepartment({{ $category['entity_id'] }})"
                            >
                                <span>{{ $category['category'] }}</span>

                                @if($category['has_children'])
                                    <span class="department-arrow" aria-hidden="true">›</span>
                                @endif
                            </button>

                        @endif
                    @endforeach

                </div>

                <div
                    class="departments-content"
                    :class="{ 'is-mobile-detail': mobileDetail }"
                >
                    <button
                        type="button"
                        class="departments-back"
                        @click="mobileDetail = false"
                    >
                        <span aria-hidden="true">‹</span>
                        <span>Voltar</span>
                    </button>

                    @foreach($categories as $category)
                        @if($category['has_products'])

                            <section
                                class="department-content"
                                x-show="activeDepartment === {{ $category['entity_id'] }}"
                            >

                                <div class="department-content-header">

                                    <a
                                        href="{{ url($category['slug_key']) }}"
                                        class="department-title"
                                    >
                                        {{ $category['category'] }}
                                    </a>

                                    <a
                                        href="{{ url($category['slug_key']) }}"
                                        class="department-see-all"
                                    >
                                        Ver departamento
                                    </a>

                                </div>

                                @if($category['has_children'])
                                    <div class="department-children">

                                        @foreach($category['children'] as $child)
                                            <a
                                                href="{{ url($child['slug_key']) }}"
                                                class="department-child-link"
                                            >
                                                {{ $child['category'] }}
                                            </a>
                                        @endforeach

                                    </div>
                                @else
                                    <p class="department-empty">
                                        Confira os produtos deste departamento.
                                    </p>
                                @endif

                            </section>

                        @endif
                    @endforeach

                </div>

            </div>

        </div>
    </div>
</div>
