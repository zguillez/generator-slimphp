'use strict';
module.exports = function(grunt) {
	grunt.initConfig({});
	require('load-grunt-tasks')(grunt);
	require('./grunt/connect')(grunt);
	grunt.registerTask('default', ['serve']);
	grunt.registerTask('serve', function() {
		grunt.task.run(['php']);
	});
};