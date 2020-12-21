#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const fs = require("fs");
const path = require("path");
const colors = require("colors");
const argv = require("minimist")(process.argv.slice(2));
const EasyFtp = require("easy-ftp");
const shell = require("shelljs");
const ini = require("ini");
const config = ini.parse(
  fs.readFileSync(path.resolve(__dirname, "../config.ini"), "utf8"),
);
//-----------------------------------
const files = [
  `${config.ftp["ftp[local]"]}.htaccess`,
  `${config.ftp["ftp[local]"]}index.php`,
  `${config.ftp["ftp[local]"]}composer.json`,
  `${config.ftp["ftp[local]"]}composer.phar`,
  `${config.ftp["ftp[local]"]}inc`,
  `${config.ftp["ftp[local]"]}logs`,
];
//-----------------------------------
if (argv.ftp) {
  console.log("[FTP]".green);
  const ftp = new EasyFtp();
  ftp.connect({
    "host": config.ftp["ftp[host]"],
    "port": config.ftp["ftp[port]"],
    "username": config.ftp["ftp[username]"],
    "password": config.ftp["ftp[password]"],
    "local": config.ftp["ftp[local]"],
    "remote": config.ftp["ftp[remote]"],
  });
  ftp.upload(files, config.ftp["ftp[remote]"], err => {
    if (err) {
      console.log(`[error] ${err}\n`.red);
    } else {
      console.log("=> Done!\n".green);
    }
    ftp.close();
  });
} else if (argv.ssh) {
  console.log("[SSH]".green);
  let command = `sshpass -p ${config.ssh["ssh[password]"]} scp -r`;
  for (let i = 0; i < files.length; i++) {
    command += ` ${files[i]}`;
  }
  command += ` ${config.ssh["ssh[username]"]}@${config.ssh["ssh[host]"]}:${config.ssh["ssh[path]"]}/${config.ssh["ssh[folder]"]}`;
  console.log(`=> Command: ${command}`.cyan);
  shell.exec(command);
  console.log("=> Done!\n".green);
} else {
  console.log("[undefined connection type] (ssh|ftp)\n".red);
}
