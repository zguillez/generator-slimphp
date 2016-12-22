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
			files: ['*.php', '**/*.php', 'inc/**/*.php', 'inc/views/*.html', 'inc/views/partials/*.html', '.htaccess'],
			tasks: ['build', 'clean:deploy', 'copy:deploy', 'exec:log']
		}
	});
};