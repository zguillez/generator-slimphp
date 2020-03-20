#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const fs = require('fs');
const path = require('path');
const colors = require('colors');
const shell = require('shelljs');
const config = JSON.parse(
  fs.readFileSync(path.resolve(__dirname, '../.sshconfig'), 'utf8')
);
//-----------------------------------
const command = `sshpass -p ${config.ssh.password} scp -r .htaccess index.php composer.json composer.phar inc static logs ${config.ssh.username}@${config.ssh.host}:${config.ssh.path}/${config.ssh.folder}`;
console.log(`=> Command: ${command}`.cyan);
shell.exec(command);
console.log('=> Done!\n'.green);
