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
    /*const prompts = [{
     type: 'confirm',
     name: 'someAnswer',
     message: 'Would you like to enable this option?',
     default: true
     }];*/
    /*const prompts = [
      {
        type: 'text',
        name: 'name',
        message: 'Which is the app name?',
        default: 'myapp'
      }, {
        type: 'list',
        name: 'framework',
        message: 'Which Javascript framework you want to use?',
        choices: ['Angular', 'Ionic', 'Polymer', 'ReactJS', 'Vue']
      }
    ];
    return this.prompt(prompts).then(props => {
      this.props = props;
    });*/
  }

  writing() {
    this.fs.copy(this.templatePath('package.json'), this.destinationPath('package.json'));
    this.fs.copy(this.templatePath('composer.json'), this.destinationPath('composer.json'));
    this.fs.copy(this.templatePath('composer.lock'), this.destinationPath('composer.lock'));
    this.fs.copy(this.templatePath('composer.phar'), this.destinationPath('composer.phar'));
    this.fs.copy(this.templatePath('index.php'), this.destinationPath('index.php'));
    this.fs.copy(this.templatePath('config.json'), this.destinationPath('config.json'));
    this.fs.copy(this.templatePath('inc'), this.destinationPath('inc'));
    this.fs.copy(this.templatePath('logs'), this.destinationPath('logs'));
    this.fs.copy(this.templatePath('htaccess'), this.destinationPath('.htaccess'));
    this.fs.copy(this.templatePath('sshconfig'), this.destinationPath('.sshconfig'));
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
