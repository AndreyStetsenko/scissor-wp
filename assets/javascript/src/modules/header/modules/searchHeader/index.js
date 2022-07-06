export default class SearchHeader {
    constructor() {
        this.settings();
        this.bindEvents();
    }
    settings() {
        this.btnSearchHeader = document.getElementById('btnSearchHeader');
        this.inputSearchHeader = document.getElementById('inputSearchHeader');
        this.containerSearchHeader = document.getElementById('containerSearchHeader');
        this.closeSearchHeader = document.getElementById('closeSearchHeader');
    }
    bindEvents() {
        this.btnSearchHeader.addEventListener('click', (e) => {
            this.openSearch(e);
        });

        this.closeSearchHeader.addEventListener('click', () => {
            this.closeSearch();
        });
    }
    openSearch(e) {
        if (this.btnSearchHeader.getAttribute('data-expended') === 'false') {
            e.preventDefault();
            e.stopPropagation();

            this.btnSearchHeader.setAttribute('data-expended', true);
            this.inputSearchHeader.focus();

            this.containerSearchHeader.classList.add('show');
        }
    }
    closeSearch() {
        this.btnSearchHeader.setAttribute('data-expended', false);

        this.containerSearchHeader.classList.remove('show');

        this.inputSearchHeader.value = '';
    }
}
