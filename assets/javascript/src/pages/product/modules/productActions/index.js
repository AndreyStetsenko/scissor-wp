export default function productActions() {
    $('.p-inp-num').each(function() {
        const num = $(this);

        num.find('.plus').on('click', () => {
            num.parent().find('input').val(+num.parent().find('input').val() + 1);
            num.parent().find('input').change();
        });

        num.find('.minus').on('click', () => {
            num.parent().find('input').val(+num.parent().find('input').val() - 1);
            num.parent().find('input').change();

            if (+num.parent().find('input').val() < 1) {
                num.parent().find('input').val(1);
            }
        });
    });

    $('.variable_inp').on('click', function() {
        const price = $(this).attr('data-price');
        // console.log($(this).attr('data-price'));
        $('#price').val(price);
    });
}
