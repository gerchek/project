const mix = require('laravel-mix');
const path = require('path')
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin')
const TerserWebpackPlugin = require('terser-webpack-plugin')
const webpack = require('webpack')

const isDev = process.env.NODE_ENV === 'development'
const isProd = !isDev

const filename = ext => isDev ? `[name].${ext}` : `[name].[hash].${ext}`

const optimization = () => {
    const config = {
        splitChunks:{
            chunks:'all'
        },
    }

    if(isProd)
        config.minimizer = [
            new CssMinimizerPlugin(),
            new TerserWebpackPlugin()
        ]

    return config
}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js', )
    .js('resources/js/404.js', 'public/js')
    .js('resources/js/500.js', 'public/js')
    .js('resources/js/contacts.js', 'public/js')
    .js('resources/js/docs.js', 'public/js')
    .js('resources/js/events.js', 'public/js')
    .js('resources/js/events_single.js', 'public/js')
    .js('resources/js/gallery.js', 'public/js')
    .js('resources/js/gallery_single.js', 'public/js')
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/leaders.js', 'public/js')
    .js('resources/js/management.js', 'public/js')
    .js('resources/js/partners.js', 'public/js')
    .js('resources/js/prices.js', 'public/js')
    .js('resources/js/schedule.js', 'public/js')
    .js('resources/js/search.js', 'public/js')
    .js('resources/js/services.js', 'public/js')
    .js('resources/js/sport_single.js', 'public/js')
    .js('resources/js/thanks.js', 'public/js')
    .js('resources/js/vacancy.js', 'public/js')
    // .copyDirectory('resources/images', 'public/images')
    // .copyDirectory('resources/fonts', 'public/fonts')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .sass('resources/css/404.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/500.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/contacts.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/docs.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/events.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/events_single.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/gallery.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/gallery_single.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/index.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/leaders.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/partners.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/prices.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/schedule.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/search.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/services.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/sport_single.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/thanks.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })
    .sass('resources/css/vacancy.scss', 'public/css', {
        sassOptions: {
            includePaths: ["node_modules"]
        }
    })

mix.webpackConfig({
    context: path.resolve(__dirname, 'resources'),
    output: {
        filename: filename('js'),
        path: path.resolve(__dirname, 'public'),
    },
    resolve: {
        extensions:['.js','.json','png'],
        alias:{
            '@':path.resolve(__dirname, 'resources')
        }
    },
    optimization: optimization(),
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        })
    ],
    module:{
        rules:[
            {
                test:/\.(png|svg|jpg|gif)$/,
                type:'asset/resource',
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /jquery-mousewheel/,
                use:[{
                    loader: 'imports-loader',
                    options: {
                        wrapper: 'window',
                        additionalCode: 'var define = false;',
                    },
                }
                ]
            },
            {
                test: /malihu-custom-scrollbar-plugin/,
                use:[{
                    loader: 'imports-loader',
                    options: {
                        wrapper: 'window',
                        additionalCode: 'var define = false;'
                    },
                }
                ]
            }
        ]
    }
});

mix.sourceMaps();
mix.options({
    processCssUrls: false,
})

// if (mix.inProduction()) {
//     mix.version();
// }

// mix.disableNotifications();
