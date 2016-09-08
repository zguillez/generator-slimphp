'use strict';
module.exports = function (grunt) {
	grunt.config.set('phplint', {
		options: {
			swapPath: '/tmp'
		},
		application: ['inc/**/*.php']
	});
};