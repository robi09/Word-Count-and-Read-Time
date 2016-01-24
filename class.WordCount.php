<?php

class WordCount {
	
	function __construct() {
		
		//Init core
		add_action( 'save_post', array($this, 'core'));

		//Append text to title
		add_filter( 'the_content', array($this, 'FrontendAppend'), 10, 2 );
		add_filter( 'the_excerpt', array($this, 'FrontendAppend'), 10, 2 );

		//Enqueue scripts
		add_action( 'wp_enqueue_scripts', array($this, 'scripts'));

		$this->OldPosts();
		// delete_option( 'swcart-oldposts' );

	}

	public function core() {
		$id = $_POST['post_ID'];

		$this->UpdateMeta($id);
	}

	public function WordCount($id) {
		$content = get_post_field( 'post_content', $id );
	    $word_count = str_word_count( strip_tags( $content ) );

	    return $word_count;
	}

	public function UpdateMeta($id) {

		//For wordcount
		if (!add_post_meta($id, 'swcart-word-count', $this->WordCount($id), true)) { 
		   update_post_meta($id, 'swcart-word-count', $this->WordCount($id));
		}

		//For reading time
		if (!add_post_meta($id, 'swcart-reading-time', $this->TimeConvert($this->ReadingTime($this->WordCount($id))), true )) { 
		   update_post_meta($id, 'swcart-reading-time', $this->TimeConvert($this->ReadingTime($this->WordCount($id))));
		}

			//and raw reading time
		if (!add_post_meta($id, 'swcart-reading-time-raw', $this->ReadingTime($this->WordCount($id)), true )) { 
		   update_post_meta($id, 'swcart-reading-time-raw', $this->ReadingTime($this->WordCount($id)));
		}
	}

	function TimeConvert($time) {
		$hours = floor($time / 60);
	    $minutes = ($time % 60);

	    if ($time <= 1) {
	        return __('Less then a minute', 'swcart');
	    } elseif($time < 59) {
			return $minutes . ' ' . __('minutes', 'swcart');
	    } elseif(($time % 60) == 0) {
	    	if($hours == 1) {
	    		return __('One hour', 'swcart');
	    	} else {
	    		return $hours . ' ' . __('hours', 'swcart');
	    	}
	    } else {
	    	return sprintf('%d hours and %02d minutes', $hours, $minutes);
	    }
	}

	public function ReadingTime($words) {
		$words_per_minute = '260';
		$minutes = $words / $words_per_minute;

		return round($minutes, 2);
	}

	public function FrontendAppend($filter_content) {
		global $id;

		$final = '</br> <span id="swcart" attr-rawtime="'.get_post_meta($id, 'swcart-reading-time-raw', true).'" style="font-size: 12px; font-weight: normal; opacity: 0.5;">Read in: ' . get_post_meta($id, 'swcart-reading-time', true) . '</span>';
		
		$final .= $filter_content;

		return $final;
	}

	public function scripts() {
		wp_enqueue_script( 'swcart-js', plugin_dir_url( __FILE__ ) . 'js/swcart-scripts.js', array('jquery'), '1.0', false );
	}

	public function OldPosts() {

		$option = get_option('swcart-oldposts');
		if(!$option) {
			$args = array( 
				'posts_per_page' => '-1',
				'post_type' => 'post', 
				'post_status'      => 'publish'
			);

			$posts = get_posts( $args );

			foreach ($posts as $post ) {
				setup_postdata( $post ); 

				$this->UpdateMeta($post->ID);
			}
				
			wp_reset_postdata();
		}

		update_option('swcart-oldposts', 'on', 'no');
	}
}