'use strict';
module.exports = function (grunt) {
	grunt.config.set('watch', {
		dist: {
			options: {
				spawn: false,
				base: '.',
				open: true,
				livereload: true
			},
			files: ['*.php', 'inc/**/*.php', '.htaccess'],
			tasks: ['phplint', 'sync', 'watch']
		}
	});
};