export default function headerAnim() {
    // Сразу создаём переменные
    const navbar = document.getElementById('navbar');
    const active_class = 'sticky';

    /**
     * Слушаем событие прокрутки
     */
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 200) {
            navbar.classList.add(active_class);
        } else {
            navbar.classList.remove(active_class);
        }
    });
}
