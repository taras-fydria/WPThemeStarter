const mix = require("laravel-mix");
const path = require('path')
const themeConfig = require('./theme.json');
const urlAPI = require('url');
const URL = urlAPI.parse(themeConfig.siteUrl);

mix
    .options({
        processCssUrls: false,
        postCss: [
            require('postcss-sort-media-queries')({
                sort: 'mobile-first'
            })
        ],
        notifications: false,
    })
    .sourceMaps()
    .sass(path.join(__dirname, 'resources', 'scss', 'main.scss'), path.join(__dirname, 'dist', 'main.css'))
    .js(path.join(__dirname, 'resources', 'js', 'main.js'), path.join(__dirname, 'dist', 'main.js'))
    .react()
    .babelConfig({
        plugins: ['@babel/plugin-syntax-dynamic-import'],
    })
    .webpackConfig({
        externals: {
            'jquery': 'jQuery',
            '$': 'jQuery',
            'wp': 'wp',
            react: 'React',
            'react-dom': 'ReactDOM',
        },
        output: {
            chunkFilename: mix.inProduction() ? path.relative(__dirname, path.join('dist', 'chunks', '[name].js')) : path.relative(__dirname, path.join('temp', '[name].js')),
            publicPath: mix.inProduction() ? path.join(path.sep, 'wp-content', 'themes', themeConfig.themeName) + path.sep : 'auto'
        },
        devtool: mix.inProduction() ? false : 'inline-source-map'
    })
    .browserSync({
            proxy: themeConfig.siteUrl.toString(),
            files: ["./**/*.php", "./dist/**/*.*", './temp/**/**.*'],
            serveStatic: ["./"],
            reloadDelay: 1000,
            https: true,
            injectChanges: true,
            rewriteRules: [
                {
                    match: new RegExp(URL.path.toString().substring(1) + "wp-content/themes/" + themeConfig.themeName + "/temp", "g"),
                    fn: function (req, res, match) {
                        return "temp"
                    }
                },
                {
                    match: new RegExp(URL.path.toString().substring(1) + "wp-content/themes/" + themeConfig.themeName + "/dist", "g"),
                    fn: function (req, res, match) {
                        return "dist"
                    }
                },
            ],
        },
        {
            injectCss: true,
        });