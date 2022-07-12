export default class Comments {
    constructor() {
        this.settings();
        this.bindEvents();
    }
    settings() {
        this.commentForm = document.getElementById('commentform');
    }
    bindEvents() {
        this.commentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            this.sendComment();
        });
    }
    sendComment() {
        const xhr = new XMLHttpRequest();

        xhr.open('POST', '/wp-comments-post.php');
        xhr.send();
    }
}
