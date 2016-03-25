/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    concat: {
      options: {
        stripBanners: true,
        banner: '<%= pkg.banner %>'
      },
      dist: {
        files: [
          {
            cwd: 'src/js',
            src: [ '*.js' ],
            dest: 'dist/<%= pkg.name %>.js'
          }
        ]
      }
    },
    uglify: {
      options: {
        banner: '<%= pkg.banner %>'
      },
      dist: {
        files: [
          {
            src: [ 'dist/<%= pkg.name %>.js' ],
            dest: 'dist/<%= pkg.name %>.min.js'
          }
        ]
      }
    },
    cssmin: {
      dist: {
        files: [
          {
            cwd: 'src/css',
            src: [ '*.css' ],
            dest: 'dist/<%= pkg.name %>.min.css'
          }
        ]
      }
    },
    copy: {
      dist: {
        files: [
          {
            expand: true,
            cwd: 'src/php',
            src: [ '*.php' ],
            dest: 'dist/'
          },
          {
            expand: true,
            cwd: 'src/assets',
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
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['jshint:lib_test', 'qunit']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-copy');

  // Default task.
  grunt.registerTask('default', [ 'concat', 'uglify', 'cssmin', 'copy' ]);

};
