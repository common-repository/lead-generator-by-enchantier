<?php
// register Foo_Widget widget
function register_foo_widget() {
    register_widget( 'My_Widget_Enchantier' );
}

class My_Widget_Enchantier extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'my_widget_enchantier',
			'description' => 'Générez des leads et des revenus en affichant ce widget',
		);
		parent::__construct( 'my_widget_enchantier', 'Lead Generator Enchantier', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
            echo build_widget_enchantier();
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}
