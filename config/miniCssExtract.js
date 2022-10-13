const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = new MiniCssExtractPlugin({
    linkType: "text/css",
    filename: 'app.css',
})
