@php
    $firstImage = collect($productImages)->first();
@endphp
<div
    x-data="productGallery(@js(
        collect($productImages)->map(fn($img) => [
            'large' => $img['454x454'],
            'thumb' => $img['80x80'],
            'full'  => $img['image'],
            'alt' => $img['alt']
        ])->values()
    ))"
    class="w-full"
>

    {{-- SLIDER PRINCIPAL --}}
    <div class="relative">

        <div class="product-image relative overflow-hidden"
             @mouseenter="showLens"
             @mouseleave="hideLens"
             @mousemove="moveLens"
             @touchstart="touchStart"
             @touchend="touchEnd"
        >

            {{-- BOTÃO LIGHTBOX --}}
            <button
                type="button"
                @click="openLightbox()"
                class="absolute top-3 right-3 z-20 w-11 h-11 rounded-full bg-white/95 backdrop-blur shadow-lg border border-gray-200 flex items-center justify-center transition hover:scale-105 hover:bg-white"
                aria-label="Expandir imagem"
            >
                <i class="fa-solid fa-up-right-and-down-left-from-center text-gray-700 text-sm"></i>
            </button>

            {{-- IMAGEM --}}
            <img
                src="{{ $firstImage['454x454'] }}"
                x-bind:src="activeImage.large"
                class="w-full block select-none object-contain cursor-zoom-in"
                draggable="false"
                alt="{{ $firstImage['alt'] }}"
                fetchpriority="high"
                width="454"
                height="454"
            >

            {{-- LENTE DO ZOOM --}}
            <div x-show="lensVisible"
                 class="absolute pointer-events-none border border-gray-400 cloud-zoom-lens"
                 :style="`
                    width:250px;
                    height:250px;
                    left:${lensX}px;
                    top:${lensY}px;
                    background: rgba(255,255,255,0.2);
                 `">
            </div>
        </div>

        {{-- ZOOM WINDOW --}}
        <div x-show="lensVisible"
             class="absolute top-0 left-full ml-6 w-[400px] h-[400px] border bg-no-repeat cloud-zoom-lens"
             :style="backgroundStyle">
        </div>

        {{-- SETA ESQUERDA --}}
        <button
            type="button"
            @click="prev"
            x-show="activeIndex > 0"
            class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/95 shadow-lg border border-gray-200 flex items-center justify-center hover:bg-white transition"
            aria-label="Imagem anterior"
        >
            <span class="text-2xl leading-none">‹</span>
        </button>

        {{-- SETA DIREITA --}}
        <button
            type="button"
            @click="next"
            x-show="activeIndex < images.length - 1"
            class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/95 shadow-lg border border-gray-200 flex items-center justify-center hover:bg-white transition"
            aria-label="Próxima imagem"
        >
            <span class="text-2xl leading-none">›</span>
        </button>


    </div>

    {{-- THUMBNAILS --}}
    <div class="more-views mt-4 overflow-hidden">
        <div class="flex gap-3 overflow-x-auto pb-2">
            <template x-for="(image, index) in images" :key="index">
                <div
                    @click="setImage(index)"
                    role="button"
                    tabindex="0"
                    class="flex-shrink-0 border cursor-pointer"
                    :class="index === activeIndex ? 'border-black' : 'border-gray-300'"
                >
                    <img
                        :src="image.thumb"
                        class="w-20 h-20 object-cover select-none"
                        draggable="false"
                        :alt="image.alt"
                        width="80"
                        height="80"
                    >
                </div>
            </template>
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div
        x-show="lightboxOpen"
        x-transition.opacity
        x-cloak
        @keydown.escape.window="closeLightbox()"
        class="fixed inset-0 z-[9999] bg-black/95"
    >

        {{-- ÁREA CLICK FORA --}}
        <div
            class="absolute inset-0"
            @click="closeLightbox()"
        ></div>

        {{-- BOTÃO FECHAR --}}
        <button
            type="button"
            @click="closeLightbox()"
            class="absolute top-5 right-5 z-30 w-12 h-12 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition"
            aria-label="Fechar lightbox"
        >
            <span class="text-3xl leading-none">&times;</span>
        </button>

        {{-- SETA ESQUERDA --}}
        <button
            type="button"
            x-show="activeIndex > 0"
            @click="prev()"
            class="absolute left-5 top-1/2 -translate-y-1/2 z-30 w-14 h-14 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition"
            aria-label="Imagem anterior"
        >
            <span class="text-4xl leading-none">‹</span>
        </button>

        {{-- SETA DIREITA --}}
        <button
            type="button"
            x-show="activeIndex < images.length - 1"
            @click="next()"
            class="absolute right-5 top-1/2 -translate-y-1/2 z-30 w-14 h-14 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition"
            aria-label="Próxima imagem"
        >
            <span class="text-4xl leading-none">›</span>
        </button>

        {{-- CONTEÚDO --}}
        <div
            class="relative z-20 flex items-center justify-center w-full h-full p-6 lg:p-12"
            @touchstart="touchStart($event)"
            @touchend="touchEnd($event)"
        >

            <img
                :src="activeImage.full"
                :alt="activeImage.alt"
                class="max-w-full max-h-full object-contain rounded-2xl transition duration-300 ease-out"
            >

        </div>

        {{-- CONTADOR --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30">
            <div
                class="px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white text-sm font-medium">
                <span x-text="activeIndex + 1"></span>
                /
                <span x-text="images.length"></span>
            </div>
        </div>

    </div>

</div>
