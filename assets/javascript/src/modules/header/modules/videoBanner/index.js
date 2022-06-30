export default class VideoBanner {
    constructor() {
        this.settings();
        this.bindEvents();
    }
    settings() {
        this.videoBanner = document.querySelector('.banner-video');
    }
    bindEvents() {
        if (this.videoBanner) {
            this.videoPlay = this.videoBanner.querySelector('.play');
            this.video = this.videoBanner.querySelector('video');

            this.videoPlay.addEventListener('click', () => {
                this.video.play();
                this.video.style.display = 'block';
            });
        }
    }
}
