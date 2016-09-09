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
			src: [config.localhost_folder + "/api.php", config.localhost_folder + "/.htaccess", config.localhost_folder + "/inc/**", config.localhost_folder + "/vendor/**", config.localhost_folder + "/logs/**"]
		}
	});
};