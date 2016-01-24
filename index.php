<?php
/**
* Plugin Name: Word Count and Reading Time
* Plugin URI: http://hapiucrobert.ro
* Description: Show word count and reading time in front-end with a nice and clean loading bar. 
* Version: 1.0
* Author: Hapiuc Robert
* Author URI: http://hapiucrobert.ro
* License: GPL
*/

require plugin_dir_path( __FILE__ ) . 'class.WordCount.php';

$wordCount = new WordCount();
