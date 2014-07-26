<?php
/*  Copyright 2014 ITslum SOLUTIONS, Inc. 

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Plugin Name: Quote of the Day - ITslum
Plugin URI: http://dir.itslum.com/quotes/for-websites/
Description: Show your website visiotrs quote of the day in your site's sidebar. To install, click activate and then go to Appearance > Widgets and look for the 'Quote of the Day- ITslum'. Then, drag the widget to your sidebar.
Version: 1.0
Author: ITslum SOLUTIONS
Author URI: http://solutions.itslum.com
*/

/**
 * Adds ITslum Quote of the Day widget.
 */
class QuoteOfDay_ITslum extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__('Quote of the Day - ITslum', 'text_domain'), // Name
			array( 'description' => __( 'Display quote of the day on your website/blog!', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$qtype = apply_filters( 'widget_title', $instance['qtype'] );

                $title_hash = array(
                     "quote" => "Quote of the Day",
                     "relation" => "Relationship Quote of the Day",
                     "health" => "Health Quote of the Day",
                     "nature" => "Nature Quote of the Day",
                 );

		echo $args['before_widget'];
		if ( ! empty( $qtype) )
			//echo $args['before_title'] . $title_hash[$qtype]. $args['after_title'];

		echo __( '<script type="text/javascript" src="http://dir.itslum.com/quotes/api/' . $qtype. '/index.php?h=off"></script>', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'qtype' ] ) ) {
			$qtype = $instance[ 'qtype' ];
		}
		else {
			$qtype = "qotd";
		}
		?>
	         <p>
			<label for="<?php echo $this->get_field_id( 'qtype' ); ?>">Select quotation type:</label> 
			<select id="<?php echo $this->get_field_id( 'qtype' ); ?>" name="<?php echo $this->get_field_name( 'qtype' ); ?>" class="widefat" style="width:100%;">
				<option value="quote" <?php if ( 'quote' == $qtype ) echo 'selected="selected"'; ?>>Quote of the Day</option>
				<option value="relation" <?php if ( 'relation' == $qtype ) echo 'selected="selected"'; ?>>Relationship Quote of the Day</option>
				<option value="health" <?php if ( 'health' == $qtype ) echo 'selected="selected"'; ?>>Health Quote of the Day</option>
				<option value="nature" <?php if ( 'nature' == $qtype ) echo 'selected="selected"'; ?>>Nature Quote of the Day</option>
			</select>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['qtype'] = ( ! empty( $new_instance['qtype'] ) ) ? strip_tags( $new_instance['qtype'] ) : '';

		return $instance;
	}

} // class QuoteOfDay_ITslum

// register QuoteOfDay_ITslum widget
function register_foo_widget() {
    register_widget( 'QuoteOfDay_ITslum' );
}
add_action( 'widgets_init', 'register_foo_widget' );
?>
