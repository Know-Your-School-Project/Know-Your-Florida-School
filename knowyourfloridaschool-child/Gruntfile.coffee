module.exports = (grunt) ->

  # configuration
  grunt.initConfig

    # grunt sass
    sass:
      compile:
        options:
          style: 'expanded'
        files: [
          expand: true
          cwd: 'sass'
          src: ['**/*.scss']
          dest: 'css'
          ext: '.css'
        ]

    #minify css
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'css',
          src: ['*.css', '!*.min.css'],
          dest: 'css',
          ext: '.min.css'
        }]
      }
    }

    # grunt coffee
    coffee:
      compile:
        expand: true
        cwd: 'coffee'
        src: ['**/*.coffee']
        dest: 'js'
        ext: '.js'
        options:
          bare: true
          preserve_dirs: true

    #uglify
    uglify:
      all:
        files:
          'js/scripts.min.js': [
                                  'js/chosen.jquery.min.js',
                                  'js/d3.min.js',
                                  'js/nv.d3.js',
                                  'js/highcharts.js',
                                  'js/exporting.js',
                                  'js/regression.js',
                                  'js/rangeslider.min.js',
                                  'js/search.js',
                                  'js/school-reportcards.js',
                                  'js/scripts.js',
                                ]

    # grunt watch (or simply grunt)
    watch:
      html:
        files: ['**/*.html']
      sass:
        files: '<%= sass.compile.files[0].src %>'
        tasks: ['sass']
      cssmin:
        files: '<%= cssmin.target.files[0].src %>'
        tasks: ['cssmin']
      coffee:
        files: '<%= coffee.compile.src %>'
        tasks: ['coffee']
      uglify:
        files: '<%= uglify.all.files %>'
        tasks: ['uglify']
      options:
        livereload: true

  # load plugins
  grunt.loadNpmTasks 'grunt-contrib-sass'
  grunt.loadNpmTasks 'grunt-contrib-coffee'
  grunt.loadNpmTasks 'grunt-contrib-watch'
  grunt.loadNpmTasks 'grunt-contrib-uglify'
  grunt.loadNpmTasks 'grunt-contrib-cssmin'

  # tasks
  grunt.registerTask 'default', ['sass', 'cssmin', 'coffee', 'uglify', 'watch']