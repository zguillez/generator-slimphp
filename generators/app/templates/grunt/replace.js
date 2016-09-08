'use strict';
module.exports = function (grunt) {
	var config = grunt.file.readJSON('config.json');
	grunt.config.set('replace', {
		folder: {
			src: 'dist/inc/config.php',
			overwrite: true,
			replacements: [{
				from: '{folder}',
				to: config.www_folder
			}]
		},
		database: {
			src: 'dist/inc/config.php',
			overwrite: true,
			replacements: [{
				from: '{ip}',
				to: config.database.ip
			}, {
				from: '{user}',
				to: config.database.user
			}, {
				from: '{password}',
				to: config.database.password
			}, {
				from: '{database}',
				to: config.database.database
			}]
		},
		check_folder: {
			src: 'dist/inc/config.php',
			overwrite: true,
			replacements: [{
				from: '//{check_folder}',
				to: ''
			}]
		},
		check_bd: {
			src: 'dist/inc/config.php',
			overwrite: true,
			replacements: [{
				from: '//{check_bd}',
				to: ''
			}]
		}
	});
	if (config.www_folder == "") {
		grunt.config.set('replace.check_folder.replacements', []);
	}
	if (config.database.ip == "" || config.database.user == "" || config.database.password == "" || config.database.database == "") {
		grunt.config.set('replace.check_bd.replacements', []);
	}
};