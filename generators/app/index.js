"use strict";
const Generator = require("yeoman-generator");
const chalk = require("chalk");
const yosay = require("yosay");
const fs = require("fs");
const path = require("path");
const { version } = JSON.parse(
  fs.readFileSync(path.resolve(__dirname, "../../") + "/package.json")
);
module.exports = class extends Generator {
  prompting() {
    this.log(yosay("generator-slimphp " + chalk.green(`v${version}`)));
    const prompts = [
      {
        type: "list",
        name: "apptype",
        message: "Which type of app you want to create?",
        choices: [
          "[3.12.2] API Rest with JSON responses",
          "[3.12.2] Web without database connection",
          "[3.12.2] Web with database connection",
          "[4.2.0] API Rest with JSON responses"
        ]
      }
    ];
    return this.prompt(prompts).then(props => {
      this.props = props;
    });
  }

  writing() {
    let apptype = "3all";
    if (this.props.apptype === "[3.12.2] API Rest with JSON responses") {
      apptype = "3api";
    } else if (
      this.props.apptype === "[3.12.2] Web without database connection"
    ) {
      apptype = "3web";
    } else if (this.props.apptype === "[3.12.2] Web with database connection") {
      apptype = "3all";
    } else if (this.props.apptype === "[4.2.0] API Rest with JSON responses") {
      apptype = "4api";
    }

    this.fs.copy(
      this.templatePath(`package-${apptype}.json`),
      this.destinationPath("package.json")
    );
    this.fs.copy(
      this.templatePath(`composer-${apptype}.json`),
      this.destinationPath("composer.json")
    );
    this.fs.copy(
      this.templatePath("composer.phar"),
      this.destinationPath("composer.phar")
    );
    this.fs.copy(
      this.templatePath("index.php"),
      this.destinationPath("index.php")
    );
    this.fs.copy(
      this.templatePath(`bin-${apptype}`),
      this.destinationPath("bin")
    );
    this.fs.copy(this.templatePath("logs"), this.destinationPath("logs"));
    this.fs.copy(this.templatePath("db"), this.destinationPath("db"));
    this.fs.copy(
      this.templatePath("htaccess"),
      this.destinationPath(".htaccess")
    );
    this.fs.copy(
      this.templatePath("sshconfig"),
      this.destinationPath(".sshconfig")
    );
    if (apptype === "3web" || apptype === "3all") {
      this.fs.copy(
        this.templatePath("eslintrc.js"),
        this.destinationPath(".eslintrc.js")
      );
      this.fs.copy(this.templatePath("static"), this.destinationPath("static"));
    }

    if (apptype === "3all") {
      this.fs.copy(
        this.templatePath("static"),
        this.destinationPath("uploads")
      );
    }

    if (apptype === "4api") {
      this.fs.copy(
        this.templatePath(`inc-${apptype}/app`),
        this.destinationPath("app")
      );
      this.fs.copy(
        this.templatePath(`inc-${apptype}/src`),
        this.destinationPath("src")
      );
      this.fs.copy(
        this.templatePath(`inc-${apptype}/index.php`),
        this.destinationPath("index.php")
      );
    } else {
      this.fs.copy(
        this.templatePath(`inc-${apptype}`),
        this.destinationPath("inc")
      );
    }
  }

  install() {
    this.installDependencies({
      bower: false,
      npm: true,
      yarn: false,
      callback: () => {
        console.log(chalk.green("=> Everything is ready!"));
      }
    });
  }
};
