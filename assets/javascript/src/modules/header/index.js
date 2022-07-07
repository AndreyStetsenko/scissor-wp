// import 'jquery';
import '@popperjs/core';
import 'bootstrap';
import helpers from './modules/helpers';
import VideoBanner from './modules/videoBanner';
import lazyload from './modules/lazyload';
import language from './modules/language';
import SearchHeader from './modules/searchHeader';
import headerAnim from './modules/headerAnim';

export default function header() {
    helpers();
    new VideoBanner();
    lazyload();
    language();
    new SearchHeader();
    headerAnim();

    window.addEventListener('error', (e) => {
        const { message, filename, lineno, colno, error } = e;
        console.log([message, filename, lineno, colno, error]);
    });
}
