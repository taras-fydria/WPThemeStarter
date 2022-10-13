const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

module.exports = new BrowserSyncPlugin({
    host: 'localhost',
    port: 3000,
    proxy: 'http://mytheme.local/',
    injectCss: true
})
