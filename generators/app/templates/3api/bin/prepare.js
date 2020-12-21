#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const fs = require("fs");
const path = require("path");
const colors = require("colors");
const prepare = require("replace");
const ini = require("ini");
const config = ini.parse(
  fs.readFileSync(path.resolve(__dirname, "../config.ini"), "utf8"),
);
//-----------------------------------
prepare({
  regex: "{site}",
  replacement: config.app["app[domain]"],
  paths: ["package.json"],
  silent: true,
});
prepare({
  regex: "{host}",
  replacement: config.ssh["ssh[host]"],
  paths: ["package.json"],
  silent: true,
});
prepare({
  regex: "{path}",
  replacement: config.ssh["ssh[path]"],
  paths: ["package.json"],
  silent: true,
});
prepare({
  regex: "{username}",
  replacement: config.database["database[username]"],
  paths: ["package.json"],
  silent: true,
});
prepare({
  regex: "{password}",
  replacement: config.database["database[password]"],
  paths: ["package.json"],
  silent: true,
});
prepare({
  regex: "{ip}",
  replacement: config.database["database[host]"],
  paths: ["package.json"],
  silent: true,
});
prepare({
  regex: "{database}",
  replacement: config.database.database["database[domain]"],
  paths: ["package.json"],
  silent: true,
});
prepare({
  regex: "{folder}",
  replacement: config.ssh["ssh[folder]"],
  paths: ["inc/config.php"],
  silent: true,
});
prepare({
  regex: "{ip}",
  replacement: config.database["database[host]"],
  paths: ["inc/config.php"],
  silent: true,
});
prepare({
  regex: "{username}",
  replacement: config.database["database[username]"],
  paths: ["inc/config.php"],
  silent: true,
});
prepare({
  regex: "{password}",
  replacement: config.database["database[password]"],
  paths: ["inc/config.php"],
  silent: true,
});
prepare({
  regex: "{database}",
  replacement: config.database["database[database]"],
  paths: ["inc/config.php"],
  silent: true,
});
prepare({
  regex: "{database}",
  replacement: config.database["database[database]"],
  paths: ["db/dump.txt"],
  silent: true,
});
console.log("=> Done!\n".green);
