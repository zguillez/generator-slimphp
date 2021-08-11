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
console.log("=> Done!\n".green);
