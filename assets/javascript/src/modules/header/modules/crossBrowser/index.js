import device from 'current-device';

const { detect } = require('detect-browser');

export default function crossBrowser() {
    const browser = detect();
    if (browser) {
        device.noConflict();
        const browserName = browser.name;
        // const browserVersion = browser.name + '-' + browser.version.slice(0, 2);
        const browserOs = browser.os.split(' ')[0].toLowerCase();
        // const browserOs = browser.os.split(' ').join('-').toLowerCase();
        // $('body').addClass(`${browserName} ${browserVersion} ${browserOs}`);
        $('body').addClass(`${browserName} ${browserOs}`);
        $('html').addClass(`${browserName}`);
    }
}
