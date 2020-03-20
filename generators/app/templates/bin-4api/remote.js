#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const fs = require('fs');
const path = require('path');
const argv = require('minimist')(process.argv.slice(2));
const colors = require('colors');
const rexec = require('remote-exec');
const config = JSON.parse(
  fs.readFileSync(path.resolve(__dirname, '../.sshconfig'), 'utf8')
);
const options = {
  username: config.ssh.username,
  password: config.ssh.password
};
//-----------------------------------
if (argv.i) {
  const command = `cd ${config.ssh.path} && ${argv.i}`;
  console.log(`=> Command: ${command}`.cyan);
  rexec(config.ssh.host, command, options, err => {
    if (err) {
      console.log(`${err}`.red);
    } else {
      console.log(`${command} => Remote exec done!`.cyan);
    }

    console.log('=> Done!'.green);
  });
} else {
  console.log('error: null -i [script]\n'.red);
}
