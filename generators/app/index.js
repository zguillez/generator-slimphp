'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var spawnCommand = require('spawn-command');
module.exports = yeoman.Base.extend({
	initializing: function () {
		this.pkg = require('../../package.json');
		this.log(yosay('Welcome to the zetadelic ' + chalk.red('SlimPHP v' + this.pkg.version) + ' generator!'));
	},
	writing: function () {
		this.fs.copy(this.templatePath('editorconfig'), this.destinationPath('.editorconfig'));
		this.fs.copy(this.templatePath('jshintrc'), this.destinationPath('.jshintrc'));
		this.fs.copy(this.templatePath('bowerrc'), this.destinationPath('.bowerrc'));
		this.fs.copy(this.templatePath('package.json'), this.destinationPath('package.json'));
		this.fs.copy(this.templatePath('bower.json'), this.destinationPath('bower.json'));
		this.fs.copy(this.templatePath('composer.json'), this.destinationPath('composer.json'));
		this.fs.copy(this.templatePath('composer.lock'), this.destinationPath('composer.lock'));
		this.fs.copy(this.templatePath('composer.phar'), this.destinationPath('composer.phar'));
		this.fs.copy(this.templatePath('Gruntfile.js'), this.destinationPath('Gruntfile.js'));
		this.fs.copy(this.templatePath('index.php'), this.destinationPath('index.php'));
		this.fs.copy(this.templatePath('config.json'), this.destinationPath('config.json'));
		this.fs.copy(this.templatePath('grunt'), this.destinationPath('grunt'));
		this.fs.copy(this.templatePath('inc'), this.destinationPath('inc'));
		this.fs.copy(this.templatePath('logs'), this.destinationPath('logs'));
		this.fs.copy(this.templatePath('htaccess'), this.destinationPath('.htaccess'));
	},
	install: function () {
		var scope = this;
		this.installDependencies(function () {
			console.log('\nRunning ' + chalk.bold.yellow('grunt prepare') + ' for you to install the required Slim vendors. If folder /vendors isn\'t created, try running the command yourself or run ' + chalk.bold.yellow('./composer.phar self-update && ./composer.phar install') + '\n\n');
			var child = spawnCommand('grunt prepare');
			child.stdout.on('data', function (data) {
				console.log(data.toString('utf8'));
			});
		});
	}
});