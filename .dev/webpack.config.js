var debug = process.env.NODE_ENV == "development";
var webpack = require('webpack');

/*
 * 
 */
module.exports = {

    context: __dirname,

    devtool: debug ? "inline-sourcemap" : null,

    entry: {
        main: "./js/app/main.js"
    },

    resolve: {
        extensions: ['', '.js']
    },

    module: {
        loaders: [
        ]
    },
    output: {
        path: __dirname,
        filename: "../public/js/calculator.js"
    },
    plugins: debug ? [] : [
        new webpack.optimize.DedupePlugin(),
        new webpack.optimize.OccurenceOrderPlugin(),
        new webpack.optimize.UglifyJsPlugin({mangle: true, sourcemap: false})
    ],
};


