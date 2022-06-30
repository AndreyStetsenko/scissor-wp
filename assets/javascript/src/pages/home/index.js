import header from '../../modules/header';

/**
 * Static page
 */
class Static {
    /**
     * Static page constructor
     */
    constructor() {
        this.initModules();
    }
    /**
     * Static for init plugins
     */
    initModules() {
        header();
    }
}

new Static();
