'use strict';
module.exports = function (grunt) {
	var config = grunt.file.readJSON('config.json');
	grunt.config.set('sync', {
		dist: {
			files: [{
				cwd: '.',
				src: ['*.php', 'inc/**/*.php', '.htaccess'],
				dest: config.localhost_folder + "/"
			}],
			pretend: false,
			verbose: true
		}
	});
};