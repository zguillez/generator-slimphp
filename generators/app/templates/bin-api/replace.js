#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const fs = require('fs');
const path = require('path');
const colors = require('colors');
const replace = require('replace');
const config = JSON.parse(fs.readFileSync(path.resolve(__dirname, '../.sshconfig'), 'utf8'));
//-----------------------------------
replace({
  regex: '{site}',
  replacement: config.domain,
  paths: ['package.json'],
  silent: true
});
replace({
  regex: '{folder}',
  replacement: config.ssh.folder,
  paths: ['inc/config.php'],
  silent: true
});
replace({
  regex: '{ip}',
  replacement: config.database.host,
  paths: ['inc/config.php'],
  silent: true
});
replace({
  regex: '{username}',
  replacement: config.database.username,
  paths: ['inc/config.php'],
  silent: true
});
replace({
  regex: '{password}',
  replacement: config.database.password,
  paths: ['inc/config.php'],
  silent: true
});
replace({
  regex: '{database}',
  replacement: config.database.database,
  paths: ['inc/config.php'],
  silent: true
});
console.log(`=> Done!\n`.green);
