'use strict';
module.exports = function (grunt) {
	grunt.initConfig({});
	require('load-grunt-tasks')(grunt);
	require('./grunt/clean')(grunt);
	require('./grunt/connect')(grunt);
	require('./grunt/copy')(grunt);
	require('./grunt/exec')(grunt);
	require('./grunt/open')(grunt);
	require('./grunt/phplint')(grunt);
	require('./grunt/replace')(grunt);
	require('./grunt/sync')(grunt);
	require('./grunt/watch')(grunt);
	require('time-grunt')(grunt);
	grunt.registerTask('default', ['prepare', 'server']);
	grunt.registerTask('prepare', ['exec:composer_update', 'exec:composer_install']);
	grunt.registerTask('build', ['clean:dist', 'copy:dist', 'replace']);
	grunt.registerTask('deploy', ['build', 'clean:deploy', 'copy:deploy', 'exec:log', 'open:dev']);
	grunt.registerTask('serve', ['deploy', 'watch']);
	grunt.registerTask('server', ['build', 'php']);
	grunt.registerTask('publish', ['build', 'exec:ssh', 'open:pro']);
};