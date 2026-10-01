@props([
    'categories' => [],
    'level' => 0,
])

<ul class="dy-menu nav nav-pills flex-column category level-{{ $level }}">
    @foreach ($categories as $category)
        <li class="category-node nav-item level-{{ $level }}">
            @if (empty($category['children']))
            <a href="#"
               wire:click.prevent="dispatch('category-selected', { categoryId:{{ $category['id'] }} })"
               class="nav-link text-sky-50 category-link">
                {{ $category['name'] }}
            </a>
            @else
                <details class="nav-item">
                    <summary class="nav-link"><span wire:click.prevent="dispatch('category-selected', { categoryId:{{ $category['id'] }} })">{{ $category['name'] }}</span></summary>
                    <ul class="nav nav-treeview">
                        @if (!empty($category['children']))
                            <x-catalog::wsdadm.category-tree
                                :categories="$category['children']"
                                :level="$level + 1"
                            />
                        @endif
                    </ul>
                </details>
            @endif
        </li>
    @endforeach
</ul>
