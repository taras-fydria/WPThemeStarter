const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const miniCssExtract = require('./miniCssExtract')
const browserSync = require('./browserSync.config')


module.exports = (env, argv) => {
    return {
        mode: argv.mode,
        watch: argv.mode === 'development',
        entry: path.resolve('src', 'index.js'),
        output: {
            filename: 'app.js',
            path: path.resolve('dist')
        },
        module: {
            rules: [
                {
                    test: /\.s[ac]ss$/i,
                    use: [
                        // Creates `style` nodes from JS strings
                        MiniCssExtractPlugin.loader,
                        "css-loader",
                        // Compiles Sass to CSS
                        {
                            loader: "sass-loader",
                            options: {
                                // Prefer `dart-sass`
                                implementation: require.resolve("sass"),
                            },
                        },
                    ],
                },
            ]
        },
        plugins: [miniCssExtract, browserSync],
        optimization: {
            minimizer: [
                // For webpack@5 you can use the `...` syntax to extend existing minimizers (i.e. `terser-webpack-plugin`), uncomment the next line
                // `...`,
                new CssMinimizerPlugin(),
            ],
            minimize: argv.mode === 'production'
        },
        
    }
}
