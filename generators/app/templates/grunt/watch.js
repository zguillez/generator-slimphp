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
			files: ['*.php', '**/*.php', 'inc/**/*.php', '.htaccess'],
			tasks: ['build', 'clean:deploy', 'copy:deploy', 'exec:log']
		}
	});
};