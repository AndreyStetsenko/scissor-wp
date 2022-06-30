import LazyLoad from 'vanilla-lazyload';

export default function lazyload() {
    const lazyLoadInstance = new LazyLoad({
        elements_selector: '.lazy',
        load_delay: 300,

        callback_load(el) {
            el.classList.add('is-loaded');
        },

        callback_error(el) {
            el.classList.add('is-error');
        }
    });

    lazyLoadInstance.update();
}
