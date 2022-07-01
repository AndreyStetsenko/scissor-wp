import LazyLoad from 'vanilla-lazyload';

export default function lazyload() {
    new LazyLoad({
        // use_native: true,
        elements_selector: '.lazy',
        load_delay: 300,

        callback_load(el) {
            el.classList.add('is-loaded');
        },

        callback_error(el) {
            el.classList.add('is-error');
        }
    });
}
