@if($banners)
    <div class="lg:col-span-9">
        <div class="overflow-hidden">
            @foreach($banners as $banner)
                <a href="{{ $banner->banner_url ?? '#' }}" class="block relative group">
                    <img
                        src="{{ asset("storage/{$banner->image}") }}"
                        alt="{{ $banner->image_alt }}"
                        class="w-full "
                    >
                </a>
            @endforeach
        </div>
    </div>
@endif
