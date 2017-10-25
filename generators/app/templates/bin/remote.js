#! /usr/bin/env node
const fs = require('fs');
const path = require('path');
const argv = require('minimist')(process.argv.slice(2));
const colors = require('colors');
const rexec = require('remote-exec');
const config = JSON.parse(fs.readFileSync(path.resolve(__dirname, '../.sshconfig'), 'utf8'));
const options = {
  username: config.username,
  password: config.password
};
//-----------------------------------
if(argv.i) {
  let command = `cd ${config.path} && ${argv.i}`;
  console.log(`=> Command: ${command}`.cyan);
  rexec(config.ip, command, options, err => {
    if(err) {
      console.log(`${err}`.red);
    } else {
      console.log(`${command} => Remote exec done!`.cyan);
    }
    console.log(`=> Done!`.green);
  });
} else {
  console.log(`error: null -i [script]\n`.red);
}