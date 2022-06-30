export default function helpers() {
    $('a').each(function() {
        if ($(this).hasClass('online-mss-btn')) {
            $(this).addClass('btn');
            $(this).addClass('btn_accreditation');
        }
        if ($(this).html().indexOf('<img') !== -1) {
            $(this).addClass('inside-photo');
        }
    });

    $('.editor-content a').each(function() {
        if ($(this).attr('target') === '_blank' && !$(this).hasClass('inside-photo') && !$(this).hasClass('npa-page_pdf-link')) {
            $(this).html(`<span>${$(this).html()}</span><span class="icon"></span>`);
        }
    });
}
