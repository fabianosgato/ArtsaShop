@if (!empty($categories))

    @foreach($categories as $category)
        <li class="category-node nav-item level-{{ $level }}">
            @if(empty($category['children']))
                <a class="nav-link" wire:click.prevent="dispatch('category-selected', { categoryId:{{ $category['id'] }} })" href="#">{{ $category['name'] }}</a>
            @else
                <details>
                    <summary class="nav-link"><span wire:click.prevent="dispatch('category-selected', { categoryId:{{ $category['id'] }} })">{{ $category['name'] }}</span></summary>
                    <ul class="nav nav-treeview">
                        <x-catalog::wsdadm.category-tree
                            :categories="$category['children']"
                            :level="$level + 1"
                        />
                    </ul>
                </details>
            @endif
        </li>
    @endforeach
@endif
