'use strict';
const Generator = require('yeoman-generator');
const chalk = require('chalk');
const yosay = require('yosay');
const fs = require('fs');
const path = require('path');
const version = JSON.parse(fs.readFileSync(path.resolve(__dirname, '../../') + '/package.json')).version;
module.exports = class extends Generator {
  prompting() {
    this.log(yosay('generator-slimphp ' + chalk.green(`v${version}`)));
    const prompts = [
      {
        type: 'list',
        name: 'apptype',
        message: 'Which type of app you want to create?',
        choices: ['API Rest with JSON responses', 'Web with database connection', 'Web + API Rest']
      }
    ];
    return this.prompt(prompts).then(props => {
      this.props = props;
    });
  }

  writing() {
    let apptype = 'all';
    if (this.props.apptype === 'API Rest with JSON responses') {
      apptype = 'api';
    } else if (this.props.apptype === 'Web with database connection') {
      apptype = 'web';
    } else if (this.props.apptype === 'Web + API Rest') {
      apptype = 'all';
    }
    this.fs.copy(this.templatePath(`package-${apptype}.json`), this.destinationPath('package.json'));
    this.fs.copy(this.templatePath('composer.json'), this.destinationPath('composer.json'));
    this.fs.copy(this.templatePath('composer.phar'), this.destinationPath('composer.phar'));
    this.fs.copy(this.templatePath('index.php'), this.destinationPath('index.php'));
    this.fs.copy(this.templatePath(`bin-${apptype}`), this.destinationPath('bin'));
    this.fs.copy(this.templatePath(`inc-${apptype}`), this.destinationPath('inc'));
    this.fs.copy(this.templatePath('logs'), this.destinationPath('logs'));
    this.fs.copy(this.templatePath('htaccess'), this.destinationPath('.htaccess'));
    this.fs.copy(this.templatePath('sshconfig'), this.destinationPath('.sshconfig'));
    if (apptype === 'web') {
      this.fs.copy(this.templatePath('eslintrc.js'), this.destinationPath('.eslintrc.js'));
      this.fs.copy(this.templatePath('static'), this.destinationPath('static'));
    }
  }

  install() {
    this.installDependencies({
      bower: false,
      npm: false,
      yarn: true,
      callback: () => {
        console.log(chalk.green(`=> Everything is ready!`));
      }
    });
  }
};
