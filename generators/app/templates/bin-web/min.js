#! /usr/bin/env node
/* eslint no-unused-vars: "off", no-restricted-modules: "off" */
const colors = require('colors');
const fs = require('fs');
const CleanCSS = require('clean-css');
const minify = require('uglify-js-es6').minify;
let readFile = (file, ext, resolve, reject) => {
  fs.readFile(`inc/static/${file}.${ext}`, 'utf8', (err, data) => {
    if (err) {
      reject(err);
    }
    resolve(data);
  });
};
let writeFilePromise = (file, html, ext) => {
  return new Promise((resolve, reject) => {
    fs.writeFile(`static/${file}.min.${ext}`, html, (err) => {
      if (err) {
        reject(err);
      }
      resolve();
    });
  });
};
let minifierCSSFile = (file) => {
  let readFilePromise = new Promise((resolve, reject) => {
    readFile(file, 'css', resolve, reject);
  });
  readFilePromise.then(function (data) {
    let css = new CleanCSS({ keepBreaks: true }).minify(data).styles;
    writeFilePromise(file, css, 'css').then(() => {
      console.log(`The file inc/static/${file}.min.css was saved!`.green);
    }).catch(function (err) {
      return console.log(`${err}`.red);
    });
  }).catch(function (err) {
    return console.log(`${err}`.red);
  });
};
let minifierJSFile = (file) => {
  let readFilePromise = new Promise((resolve, reject) => {
    readFile(file, 'js', resolve, reject);
  });
  readFilePromise.then(function (data) {
    let js = minify(data, {
      fromString: true,
      beautify: true,
    });
    writeFilePromise(file, js.code, 'js').then(() => {
      console.log(`The file inc/static/${file}.min.js was saved!`.green);
    }).catch(function (err) {
      return console.log(`${err}`.red);
    });
  }).catch(function (err) {
    return console.log(`${err}`.red);
  });
};
minifierCSSFile('styles');
minifierJSFile('scripts');
