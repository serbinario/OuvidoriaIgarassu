module.exports = function (grunt) {

    grunt.initConfig({
        jshint: {
            dist: {
                src: ['dist/js/contrato/*.js']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.registerTask('default', [])

}