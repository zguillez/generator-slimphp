'use strict';
module.exports = function (grunt) {
	var config = grunt.file.readJSON('config.json');
	grunt.config.set('copy', {
		dist: {
			files: [{
				src: ['.htaccess'],
				dest: config.deploy_folder + "/",
				filter: 'isFile'
			}, {
				src: ['index.php'],
				dest: config.deploy_folder + "/",
				filter: 'isFile'
			}, {
				src: ['inc/**'],
				dest: config.deploy_folder + "/"
			}, {
				src: ['vendor/**'],
				dest: config.deploy_folder + "/"
			}]
		},
		deploy: {
			files: [{
				src: ['.htaccess'],
				dest: config.dev_path + "/",
				filter: 'isFile'
			}, {
				cwd: config.deploy_folder + "/",
				src: ['**'],
				dest: config.dev_path + "/"
			}]
		}
	});
};