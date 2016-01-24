module.exports = function(grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
          dist: {
            options: {                      
              style: 'compressed'
            },
            files: {
              'style.css' : 'scss/style.scss'
            }
          }
        },

        watch: {
          php: {
            files: ['*.php', '**/{,*/}*.php'],
          },

          html: {
            files: ['*.html', '**/{,*/}*.html'],
          },

          js: {
            files: ['*.js', '**/{,*/}*.js'],
          },

          css: {
            files: '**/*.scss',
            tasks: ['sass']
          },

          options: {
            livereload: true,
            spawn: false
          }
        }

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    // grunt.loadNpmTasks('grunt-contrib-compass');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['watch']);

};