// Importar Swiper
import Swiper from 'swiper/bundle';

// import styles bundle
import 'swiper/css/bundle';
import './plugins/masks'
import './plugins/validators'
import './scripts'

// =============================
// Slider Products
// =============================
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.product-swiper').forEach(container => {

        const wrapper = container.querySelector('.products-grid');

        // Remove grid classes para evitar conflito com Swiper
        wrapper.classList.remove(
            'grid',
            'grid-cols-2',
            'sm:grid-cols-2',
            'lg:grid-cols-4',
            'gap-6'
        );

        new Swiper(container, {
            slidesPerView: 1,
            spaceBetween: 16,
            loop: true,
            speed: 400,

            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },

            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                }
            },
        });

    });

    // =============================
    // BANNER SWIPER (DESKTOP + MOBILE)
    // =============================
    const banner = document.querySelector('.banner-swiper');

    if (banner) {

        const slidesCount = banner.querySelectorAll('.swiper-slide').length;

        new Swiper(banner, {
            slidesPerView: 1.1,
            spaceBetween: 12,
            loop: slidesCount > 1,
            speed: 500,

            autoplay: slidesCount > 1 ? {
                delay: 4500,
                disableOnInteraction: false,
            } : false,

            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            breakpoints: {
                768: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                }
            }
        });
    }


});
