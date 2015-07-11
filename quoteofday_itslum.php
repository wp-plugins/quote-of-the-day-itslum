<?php
/*  Copyright 2015 ITslum SOLUTIONS, Inc. 

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
Description: Show your website visiotrs new quotation each day. Install then click activate and then go to Appearance > Widgets and look for the 'Quote of the Day- ITslum'. Then, drag the widget to area where you want to show quotations.
Version: 2.2
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
		$ctitle = apply_filters( 'widget_title', $instance['ctitle'] );

                $title_hash = array(
                     "quote" => "Quote of the Day",
                     "relation" => "Relationship Quote of the Day",
                     "health" => "Health Quote of the Day",
                     "nature" => "Nature Quote of the Day",
                 );

		echo $args['before_widget'];
		if ( ! empty( $ctitle) )
			echo $args['before_title'] . $ctitle. $args['after_title'];

			$jsonxix = file_get_contents('http://dir.itslum.com/quotes/api/' . $qtype. '.php');
			$objxix = json_decode($jsonxix);
			echo '<p>' . str_replace(";", "<br/>", $objxix->quote) . '</p>';
			echo '<i><a href="http://dir.itslum.com/quotes/topic/' . str_replace(" ", "+", $objxix->author) . '" target="_blank">__' . $objxix->author . '</a></i>';


		//echo __( '<script type="text/javascript" src="http://dir.itslum.com/quotes/api/' . $qtype. '/index.php?h=off"></script>', 'text_domain' );
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
		if ( isset( $instance[ 'ctitle' ] ) ) {
			$mytitle = $instance[ 'ctitle' ];
		}
		else {
			$mytitle = "Quote of the day";
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

			<label for="<?php echo $this->get_field_id( 'ctitle' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'ctitle' ); ?>" name="<?php echo $this->get_field_name( 'ctitle' ); ?>" class="widefat" style="width:100%;" type="text" value="<?php echo $mytitle; ?>"/>

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
        $instance['ctitle'] = ( ! empty( $new_instance['ctitle'] ) ) ? strip_tags( $new_instance['ctitle'] ) : '';
		return $instance;
	}

} // class QuoteOfDay_ITslum

// register QuoteOfDay_ITslum widget
function register_foo_widget() {
    register_widget( 'QuoteOfDay_ITslum' );
}
add_action( 'widgets_init', 'register_foo_widget' );
?>
