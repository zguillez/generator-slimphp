'use strict';
module.exports = function (grunt) {
	var config = grunt.file.readJSON('config.json');
	grunt.config.set('clean', {
		dist: {
			src: [config.deploy_folder]
		},
		deploy: {
			options: {
				force: true
			},
			src: [config.dev_path]
		}
	});
};