var debug = false;//process.env.NODE_ENV !== "production";
var webpack = require('webpack');

/*
 * 
 */
module.exports = {
    context: __dirname,
    // devtool: debug ? "inline-sourcemap" : null,
    entry: {
        main: "./js/app/main.js"
    },

    resolve: {
        extensions: ['', '.js', '.ejs']
    },

    module: {
        loaders: [
            // .ejs Underscore/Lodash templates
            {test: /\.ejs$/, loader: 'ejs-loader'}
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


