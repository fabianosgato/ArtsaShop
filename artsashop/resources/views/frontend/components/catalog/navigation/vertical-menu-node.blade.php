@if($category['has_products'])
    <li class="{{ $category['level'] == 0 ? 'border-b border-gray-200 py-2' : '' }}">
        @if($category['has_children'])
            <details @if($category['is_open']) open @endif>
                <summary class="rounded-none px-1 {{ $category['level'] == 0 ? 'py-2' : 'py-1' }} pr-[2px]">
                    @if($category['level'] == 0)
                        <a class="text-blumine-900 text-[18px] sm:text-[18px]" href="{{ url($category['slug_key']) }}"> {{ $category['category'] }} </a>
                    @elseif($category['level'] == 1)
                        <a class="text-blumine-800 text-[16px] sm:text-[16px] py-0.5" href="{{ url($category['slug_key']) }}"> {{ $category['category'] }} </a>
                    @else
                        <a class="text-blumine-800 text-[14px] sm:text-[14px] py-0.5" href="{{ url($category['slug_key']) }}"> {{ $category['category'] }} </a>
                    @endif

                </summary>

                <ul>
                    @foreach($category['children'] as $child)
                        @include('frontend.components.catalog.navigation.vertical-menu-node', ['category' => $child])
                    @endforeach

                </ul>
            </details>
        @else
            @if($category['level'] == 0)
                <a class="rounded-none px-1 py-1 pr-[2px] text-blumine-900 text-[18px] sm:text-[18px]" href="{{ url($category['slug_key']) }}"> {{ $category['category'] }} </a>
            @elseif($category['level'] == 1)
                <a class="rounded-none px-1 py-1 pr-[2px] text-blumine-800 text-[16px] sm:text-[16px] py-0.5" href="{{ url($category['slug_key']) }}"> {{ $category['category'] }} </a>
            @else
                <a class="rounded-none px-1 py-1 pr-[2px] text-blumine-700 text-[14px] sm:text-[14px] py-0.5" href="{{ url($category['slug_key']) }}"> {{ $category['category'] }} </a>
            @endif
        @endif
    </li>
@endif

