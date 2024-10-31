<?php
/*
Plugin Name: pixRSS
Plugin URI: http://wordpress.org/extend/plugins/pixrss/
Description: Integrates a pix.ie RSS feed into your blog.
Version: 0.3
License: GPLV2
Author: Paul Cormack
Author URI: http://www.paulcormack.net/
*/

class pixRSS extends WP_Widget {

	function pixRSS() {
		$widget_ops = array( 'classname' => 'widget_pixRSS', 'description' => __( "A pix.ie RSS parser." ) );
		$this->WP_Widget('pixRSS', __('pixRSS'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$thumb_counter = 0;
		$pixRSS_before = '<ul class="pixRSS">';
		$pixRSS_after = '</ul>';
		// blog output looks hideous without this line
		echo $before_widget;
		// widget defaults
		if(!empty($instance['title'])) echo $before_title . $instance['title'] . $after_title;
		if(empty($instance['user'])) $instance['user'] = 'eightcell';
		if(empty($instance['img_limit'])) $instance['img_limit'] = 4;
		$feed_url = 'http://rss.pix.ie/' . $instance['user'] . '/photos';
		# widget formatting
		echo $pixRSS_before;
		
		try {
			# fetch the rss from pix.ie
			$pix_xml = new SimpleXmlElement(file_get_contents($feed_url));
			foreach ($pix_xml->channel->item as $item) {
				# parse...
				$pix_title = $item->title;
				$pix_link = $item->link;
				# the media namespace
				$media = $item->children('http://search.yahoo.com/mrss/');
				$namespaces = $item->getNameSpaces(true);
				$media = $item->children($namespaces['media']);
				$raw_url = $media->thumbnail->attributes()->url;
				$pix_thumb = preg_replace('/-00240L-/', '-00100S-', $raw_url);
				// generate the html
				echo '<li><a href="' . $pix_link . '" title="' . $pix_title . 
					'" target="_blank"><img alt="' . $pix_title  . '" src="' . 
					$pix_thumb . '" /></a></li>';
				$thumb_counter++;
				# display limit?
				if($thumb_counter == $instance['img_limit']) { break; }
			}
		}
		# the rabbit hole... avoid this place
		catch (Exception $pixRSS_error){
			$pixRSS_error->getMessage();
		}

		# widget formatting
		echo $pixRSS_after;
		# blog output looks hideous without this line
		echo $after_widget;
	}

	function update($new_instance, $old_instance) { return $new_instance; }

	function form($instance) {
		# html for the admin panel...
		echo '<div id="pixRSS-admin-panel">';
		echo '<p><label for="' . $this->get_field_id('title') . '">Widget title:</label>';
		echo '<input type="text" class="widefat" ';
		echo 'name="' . $this->get_field_name('title') . '" '; 
		echo 'id="' . $this->get_field_id('title') . '" ';
		echo 'value="' . $instance['title'] . '" /></p>';
		echo '<p><label for="' . $this->get_field_id('user') . '">pix.ie username:</label>';
		echo '<input type="text" class="widefat" ';
		echo 'name="' . $this->get_field_name('user') . '" '; 
		echo 'id="' . $this->get_field_id("user") . '" ';
		echo 'value="' . $instance['user'] . '" /></p>';
		echo '<p><label for="' . $this->get_field_id('bm_limit') . '">How many new uploads to display?</label><br />';
		echo '<select id="' . $this->get_field_id('img_limit') . '" name="' . $this->get_field_name('img_limit') . 
			'" class="widefat">';

		for ($i=1; $i<=20; $i++) {

			echo '<option value="' . $i . '"';
			if ( $i == $instance['img_limit'] ) echo ' selected="selected"';
			echo '">' . $i . '</option>';

		}

		echo '</select></p>';
		echo '</div>';

	}

}

add_action('widgets_init', create_function('', 'return register_widget("pixRSS");'));

?>
