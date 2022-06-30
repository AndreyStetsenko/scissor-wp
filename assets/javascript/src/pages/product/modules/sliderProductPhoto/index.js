import Swiper, { Navigation, Pagination, Thumbs } from 'swiper';

export default function sliderProductPhoto() {
    const productThumbs = new Swiper('.ppage-slider-thumbs', {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        touchRatio: 0.2,
        slideToClickedSlide: true
    });

    const productGallery = new Swiper('.ppage-slider-main', {
        modules: [Navigation, Pagination, Thumbs],
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        thumbs: {
            swiper: productThumbs
        },
        on: {
            slideChange() {
                const activeIndex = this.activeIndex + 1;

                const nextSlide = document.querySelector(`.ppage-slider-thumbs .swiper-slide:nth-child(${activeIndex + 1})`);
                const prevSlide = document.querySelector(`.ppage-slider-thumbs .swiper-slide:nth-child(${activeIndex - 1})`);

                if (nextSlide && !nextSlide.classList.contains('swiper-slide-visible')) {
                    this.params.thumbs.swiper.slideNext();
                } else if (prevSlide && !prevSlide.classList.contains('swiper-slide-visible')) {
                    this.params.thumbs.swiper.slidePrev();
                }
            }
        }
    });

    return productGallery;
}
