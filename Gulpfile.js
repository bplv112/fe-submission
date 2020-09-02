'use strict';

// Import `src` and `dest` from gulp for use in the task.
const { src, dest } = require( 'gulp' );

// ==================================================
// Supported Packages
var fs      = require( 'fs' ),
	pump    = require( 'pump' ),
	cleaner = require( 'del' )
	;

var gulp         = require( 'gulp' ),
	watch        = require( 'gulp-watch' ),
	sass         = require( 'gulp-sass' ),
	autoprefixer = require( 'gulp-autoprefixer' ),
	cleanCSS     = require( 'gulp-clean-css' ),
	clean        = require( 'gulp-clean' ),
	eslint       = require( 'gulp-eslint' ),
	uglify       = require( 'gulp-uglify-es' ).default,
	sourcemaps   = require( 'gulp-sourcemaps' ),
	concat       = require( 'gulp-concat' ),
	rename       = require( 'gulp-rename' ),
	replace      = require( 'gulp-replace' ),
	notify       = require( 'gulp-notify' ),
	wpPot        = require( 'gulp-wp-pot' ),
	zip          = require( 'gulp-zip' ),
	babel        = require( 'gulp-babel' )
	;

// Get package.json file
var pckg = JSON.parse( fs.readFileSync( './package.json' ) );

// ==================================================
// Variables
// List of browsers
var browserlist = [
	'last 2 version',
	'> 1%'
];

// Localize strings
var strings = [
	'fe-submission.php',
	'uninstall.php',
	'app/*.php',
];

// ==================================================
// Paths

// Main locations
var folder = {
	js:     'assets/js/',
	css:    'assets/css/',
	scss:   'assets/scss/',
	lang:   'languages/',
	builds: 'builds/',
};

// Admin styles
var admin = [
	folder.scss + 'fes-admin.scss'
];

// Admin scripts
var adminJS = [
	folder.js + '/src/*.js'
];


// BLC Package list
var blc = [
	'*',
	'**',
	'!.git',
	'!.gitattributes',
	'!.gitignore',
	'!.gitmodules',
	'!.sass-cache',
	'!DS_Store',
	'!bitbucket-pipelines.yml',
	'!composer.json',
	'!composer.lock',
	'!composer.phar',
	'!createzip.bat',
	'!createzip.sh',
	'!package.json',
	'!package-lock.json',
	'!webpack.config.js',
	'!postcss.config.js',
	'!Gulpfile.js',
	'.eslintrc',
	'!README.md',
	'!.vscode/*',
	'!.vscode',
	'!builds/**',
	'!builds/*',
	'!builds',
	'!node_modules/**',
	'!node_modules/*',
	'!node_modules',
	'!nbproject',
	'!nbproject/*',
	'!nbproject/**',
	'!phpcs.ruleset.xml'
];

var uglifyOptions = {
	compress: {
		drop_console: true
	}
};
// ==================================================
// Packaging Tasks

// Task: Create language files
gulp.task( 'makepot', function() {

	return gulp.src( strings )
		.pipe( wpPot({
			package: 'Front-end-submission ' + pckg.version
		}) )
		.pipe( gulp.dest( folder.lang + 'front-end-submission.pot' ) )
		.pipe( notify({
			message: 'Localized strings extracted',
			onLast: true
		}) )
		;
});


// Task: Build admin styles
gulp.task( 'admin:styles', async function() {

	gulp.src( admin )
		.pipe(
			sass({ outputStyle: 'compressed' })
			.on( 'error', sass.logError )
		)
		.pipe( autoprefixer( browserlist ) )
		.pipe( cleanCSS() )
		.pipe( rename({
			suffix: '.min'
		}) )
		.pipe( gulp.dest( folder.css ) )
		.pipe( notify({
			message: 'Admin styles are ready',
			onLast: true
		}) )
		;
});

// Task: Build admin scripts
gulp.task( 'admin:scripts', async function( cb ) {

	pump([
		gulp.src( adminJS ),
		eslint(),
		eslint.format(),
		eslint.failAfterError(),
		babel({
			presets: [
				[ '@babel/env', {
					modules: false
				} ]
			]
		}),
		concat( 'admin.js' ),
		uglify( uglifyOptions ),
		rename({
			suffix: '.min'
		}),
		gulp.dest( folder.js ),
	], cb, err => {
		if (err) {
			notify().write(err);
		}
		cb();
	});
});


// Task: Build admin files
gulp.task( 'build', gulp.parallel(
	'admin:scripts',
	'admin:styles'
));

// Task: Run development environment
gulp.task( 'dev:config', async function() {
	uglifyOptions = {
		compress: {
			drop_debugger: false
		}
	};
}
);

// Task: Build admin files
gulp.task( 'dev', gulp.series(
	'dev:config',
	'build',
));


