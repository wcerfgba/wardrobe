/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    // Task configuration.
    concat: {
      dist: {
        files: [
          {
            src: [ 'src/js/*.js' ],
            dest: 'dist/<%= pkg.name %>.js'
          },
          {
            src: [ 'src/css/style.css', 'src/css/*.css' ],
            dest: 'dist/style.css'
          }
        ]
      }
    },
    uglify: {
      dist: {
        files: [
          {
            src: [ 'dist/<%= pkg.name %>.js' ],
            dest: 'dist/<%= pkg.name %>.min.js'
          }
        ]
      }
    },
    copy: {
      dist: {
        files: [
          {
            expand: true,
            cwd: 'src/php/',
            src: [ '*.php' ],
            dest: 'dist/'
          },
          {
            expand: true,
            cwd: 'src/assets/',
            src: [ '*' ],
            dest: 'dist/'
          }
        ]
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        browser: true,
        globals: {}
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      lib_test: {
        src: ['src/**/*.js', 'test/**/*.js']
      }
    },
    qunit: {
      files: ['test/**/*.html']
    },
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      test: {
        files: 'src/**/*',
        tasks: [ 'default' ]
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-copy');

  // Default task.
  grunt.registerTask('default', [ 'concat', 'uglify', 'copy' ]);

};
