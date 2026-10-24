@if($banners)
    @foreach($banners as $banner)
        @if(($banner->banner_local == 'banner_main_upper') || ($banner->banner_local == 'banner_main_bottom'))
            <a href="{{ $banner->banner_url ?? '#' }}"
               class="block relative overflow-hidden">
                <img
                    src="{{ asset("storage/{$banner->image}") }}"
                    alt="{{ $banner->image_alt }}"
                    class="w-full h-[160px]"
                >
            </a>
        @endif
    @endforeach
@endif
