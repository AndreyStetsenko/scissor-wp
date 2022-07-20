import axios from 'axios';
import Qs from 'qs';

export default class Auth {
    constructor() {
        this.settings();
        this.bindEvents();
    }
    settings() {
        this.ajaxurl = document.querySelector('input[name="ajax_url"]').value;
        this.nonce = document.querySelector('input[name="ajax_nonce"]').value;
        this.dropFilter = document.getElementById('dropFilter');
        this.filterItem = this.dropFilter?.querySelectorAll('.item');
        this.filterResult = document.getElementById('filterResult');
    }
    bindEvents() {
        this.filterItem?.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();

                this.catID = item.getAttribute('data-id');

                this.filterEvent(this.catID);
            });
        });
    }
    filterEvent(catID) {
        const formData = {
            action: 'ajax_filter_opt',
            security: this.nonce,
            catID
        };

        // console.log(formData);

        axios.post(this.ajaxurl, Qs.stringify(formData))
            .then(async(response) => {
                console.log(response);
                this.filterDone(response);
            })
            .catch((err) => {
                console.log(err);
            });
    }
    productItem(el) {
        const item = `
        <div class="col-md-3 product-first item product-opt">
            <a href="${el.link}" class="item-img">
                ${el.img}
            </a>
            <div class="item-body">
                <h4 class="item-title">${el.title}</h4>
                <div class="item-reviews">
                    <div class="stars">
                    ${el.stars}
                    </div>
                    <span class="item-reviews-title">${el.reviews} reviews</span>
                </div>
                <span class="item-price">${el.price}</span>
                <div class="item-btn mt-2">
                    <a href="${el.link}" class="btn btn-black">Добавить в коризну</a>
                </div>
            </div>
        </div>
        `;

        return item;
    }
    filterDone(response) {
        this.filterResult.innerHTML = '';

        response.data.forEach((el) => {
            this.filterResult.innerHTML += this.productItem(el);
        });
    }
    filterError() {

    }
}
