#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const fs = require('fs');
const path = require('path');
const colors = require('colors');
const shell = require('shelljs');
const config = JSON.parse(fs.readFileSync(path.resolve(__dirname, '../.sshconfig'), 'utf8'));
//-----------------------------------
let command = `sshpass -p ${config.password} scp -r .htaccess index.php composer.json composer.phar inc logs ${config.username}@${config.ip}:${config.path}/${config.folder}`;
console.log(`=> Command: ${command}`.cyan);
shell.exec(command);
console.log(`=> Done!\n`.green);