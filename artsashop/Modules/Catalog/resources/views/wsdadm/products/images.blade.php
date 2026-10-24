<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    @foreach($images as $image)
        <div>
            <img class="h-auto max-w-full rounded-lg" src="{{$image['image_url']}}" alt="">
        </div>
    @endforeach
</div>
