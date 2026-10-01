@if($banners->where('banner_local', 'banner_main_top')->isNotEmpty())
    <div class="banner-main">
        <div class="swiper banner-swiper">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                    @if($banner->banner_local === 'banner_main_top')
                        <div class="swiper-slide">
                            <a
                                href="{{ $banner->banner_url ?? '#' }}"
                                class="banner-main-link"
                            >
                                <img
                                    src="{{ asset("storage/{$banner->image}") }}"
                                    alt="{{ $banner->image_alt }}"
                                    class="banner-main-image"
                                >
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            @if($banners->where('banner_local', 'banner_main_top')->count() > 1)
                <div class="swiper-pagination"></div>
            @endif
        </div>
    </div>
@endif
