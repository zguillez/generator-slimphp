'use strict';
module.exports = function (grunt) {
	var config = grunt.file.readJSON('config.json');
	grunt.config.set('open', {
		dev: {
			path: config.dev_domain + '/' + config.www_folder
		},
		pro: {
			path: config.pro_domain + '/' + config.www_folder
		}
	});
};