export default function language() {
    const headNav = $('.main-nav--nav');
    const currLang = headNav.find('.current-lang');
    const valCurrLang = currLang.find('a').html();

    $('#currLang').text(valCurrLang);
}
