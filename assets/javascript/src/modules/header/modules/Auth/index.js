import axios from 'axios';
import Qs from 'qs';

export default class Auth {
    constructor() {
        this.settings();
        this.bindEvents();
    }
    settings() {
        this.authForm = document.querySelectorAll('form[data-auth]');
        this.ajaxurl = document.querySelector('input[name="ajax_url"]').value;
        this.nonce = document.querySelector('input[name="ajax_nonce"]').value;
    }
    bindEvents() {
        this.authForm.forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                this.formType = form.getAttribute('data-type');
                this.formMessage = form.querySelector('.alert');

                const formInputs = form.querySelectorAll('input');

                this.authEvent(formInputs);
            });
        });
    }
    authEvent(formInputs) {
        this.formMessage.classList.remove('alert-danger');
        this.formMessage.classList.remove('alert-success');
        this.formMessage.style.display = 'none';

        const obj = {};

        for (let n = 0; n < formInputs.length; n++) {
            obj[formInputs[n].name] = formInputs[n].value;
        }

        const formData = {
            action: 'wplb_ajax_request',
            security: this.nonce,
            type: this.formType,
            content: obj
        };

        axios.post(this.ajaxurl, Qs.stringify(formData))
            .then(async(response) => {
                if (response.data.status === true) {
                    this.authDone();
                } else {
                    this.authError(response.data.content);
                }
            })
            .catch((err) => {
                console.log(err);
            });
    }
    authDone() {
        this.formMessage.classList.remove('alert-danger');
        this.formMessage.classList.add('alert-success');
        this.formMessage.style.display = 'block';
        console.log(this.formType);

        if (this.formType === 'authorization') {
            this.formMessage.innerHTML = 'Вы авторизированы';
        } else {
            this.formMessage.innerHTML = 'Вы зарегистрированы';
        }

        setTimeout(() => {
            window.location.href = '/';
        }, 300);
    }
    authError(message) {
        console.log(message);
        this.formMessage.classList.add('alert-danger');
        this.formMessage.style.display = 'block';
        this.formMessage.innerHTML = message;
    }
}
