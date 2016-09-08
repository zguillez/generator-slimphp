'use strict';
module.exports = function (grunt) {
	var config = grunt.file.readJSON('config.json');
	grunt.config.set('exec', {
		composer_update: {
			command: 'php composer.phar self-update',
			stdout: false,
			stderr: false
		},
		composer_install: {
			command: 'php composer.phar install',
			stdout: false,
			stderr: false
		},
		ssh: {
			command: 'echo',
			stdout: false,
			stderr: false
		}
	});
	if (config.ssh.ip != "" && config.ssh.user != "" && config.ssh.password != "" && config.ssh.path != "") {
		grunt.config.set('exec.ssh.command', 'sshpass -p "' + config.ssh.password + '" scp -r dist/. ' + config.ssh.user + '@' + config.ssh.ip + ':' + config.ssh.path);
	}
};