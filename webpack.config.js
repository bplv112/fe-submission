var path    = require( 'path' ),
	webpack = require( 'webpack' )
	;

// As Webpack only understands JS, we'll use this plugin to extract the CSS to a file
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );

// If there's an error, the console will beep
const SystemBellPlugin = require( 'system-bell-webpack-plugin' );

const config = {
	source: {},
	output: {}
};

// Full path of main files that need to be ran through the bundler
config.source.scss   = './assets/scss/fes-admin.scss';
config.source.js     = './assets/js/src/fes-admin.js';

// Path where the scss & js should be compiled to
config.output.scssDirectory = 'assets/css/';
config.output.jsDirectory   = 'assets/js/';

// File names of the compiled scss & js
config.output.scssFileName = 'fes-admin.min.css';
config.output.jsFileName   = 'fes-admin.min.js';

// The path where the Shared UI fonts & images should be sent. (relative to config.output.jsFileName)
config.output.imagesDirectory = '../images/';
config.output.fontsDirectory  = '../fonts/';

var scssConfig = Object.assign( {}, {
	entry: {
		'fes-admin': config.source.scss,
	},
	output: {
		filename: '[name].min.css',
		path: path.resolve( __dirname, config.output.scssDirectory )
	},
	module: {
		rules: [{
			test: /\.scss$/,
			exclude: /(node_modules|bower_components)/,
			use: ExtractTextPlugin.extract({
				fallback: 'style-loader',
				use: [{
					loader: 'css-loader',
					options: {
						sourceMap: false
					}
				}, {
					loader: 'postcss-loader',
					options: {
						sourceMap: false,
						plugins: []
					}
				}, {
					loader: 'resolve-url-loader'
				}, {
					loader: 'sass-loader',
					options: {
						sourceMap: false
					}
				}]
			})
		}, {
			test: /\.(png|jpg|gif)$/,
			use: {
				loader: 'file-loader', // Instructs webpack to emit the required object as file and to return its public URL.
				options: {
					name: '[name].[ext]',
					outputPath: config.output.imagesDirectory
				}
			}
		}, {
			test: /\.(woff|woff2|eot|ttf|otf|svg)$/,
			use: {
				loader: 'file-loader', // Instructs webpack to emit the required object as file and to return its public URL.
				options: {
					name: '[name].[ext]',
					outputPath: config.output.fontsDirectory
				}
			}
		}]
	},
	//devtool: 'nosources-source-map',
	plugins: [
		new SystemBellPlugin(),
		new ExtractTextPlugin({
			filename: '../css/[name].min.css'
		})
	],
	watchOptions: {
		poll: 500
	}
} );

var jsConfig = Object.assign( {}, {
	entry: config.source.js,
	output: {
		filename: config.output.jsFileName,
		path: path.resolve( __dirname, config.output.jsDirectory )
	},
	module: {
        rules: [{
			test: /\.js$/,
			exclude: /(node_modules|bower_components)/,
			use: {
				loader: 'babel-loader',
				options: {
					presets: ['@babel/env']
				}
			}
		}]
	},
	//devtool: 'source-map',
	plugins: [
		new SystemBellPlugin(),
		// Automatically load modules instead of having to import or require them everywhere.
	]
} );

module.exports = [ scssConfig, jsConfig ];
