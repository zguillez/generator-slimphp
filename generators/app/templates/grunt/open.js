'use strict';
module.exports = function( grunt ) {
  var config = grunt.file.readJSON( 'config.json' );
  console.log( '' );
  console.log( '**********************************************************************' );
  console.log( 'Dev sever: ' + config.dev_domain + '/' + config.www_folder );
  console.log( 'Enable virtual host with: sudo nano -w /etc/hosts' );
  console.log( 'Path: ' + config.dev_path );
  console.log( '**********************************************************************' );
  console.log( '' );
  grunt.config.set( 'open', {
    dev: {
      path: config.dev_domain + '/' + config.www_folder
    },
    pro: {
      path: config.pro_domain + '/' + config.www_folder
    }
  } );
};