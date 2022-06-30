import header from '../../modules/header';
import sliderProductPhoto from './modules/sliderProductPhoto';
import productActions from './modules/productActions';

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
        sliderProductPhoto();
        productActions();
    }
}

new Static();
