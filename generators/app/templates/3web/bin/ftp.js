#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const fs = require('fs');
const path = require('path');
const colors = require('colors');
const EasyFtp = require('easy-ftp');
const config = JSON.parse(
  fs.readFileSync(path.resolve(__dirname, '../.sshconfig'), 'utf8')
);
const ftp = new EasyFtp();
//-----------------------------------
ftp.connect(config.ftp);
const files = [
  `${config.ftp.local}.htaccess`,
  `${config.ftp.local}index.php`,
  `${config.ftp.local}composer.json`,
  `${config.ftp.local}composer.phar`,
  `${config.ftp.local}inc`,
  `${config.ftp.local}static`,
  `${config.ftp.local}logs`
];
ftp.upload(files, config.ftp.remote, err => {
  if (err) {
    console.log(`${err}\n`.red);
  } else {
    console.log('=> Done!\n'.green);
  }
  ftp.close();
});
