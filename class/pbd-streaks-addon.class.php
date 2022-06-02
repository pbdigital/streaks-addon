<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class PBD_Streaks_Addon {
    private static $instance;

	public static function get_instance()
	{
		if( null == self::$instance ) {
            self::$instance = new PBD_Streaks_Addon();
        }

		return self::$instance;
    }

    public function __construct(){
        // hooks and filters here
        add_action('init', array( $this, 'testing' ));
        add_shortcode( 'streaks', array( $this, 'pbd_streaks_shortcode_callback' ) );
    }

    public function testing() {
        echo '<pre>';
        wp_die(print_r($this->get_pbd_streaks_report(null, 6)));
    }

    public function pbd_streaks_shortcode_callback($atts = array()) {
        extract ( shortcode_atts( array( 
            'id' => '',
            'count' => 1
        ), $atts ));

        // start return content here
    }
    
    public function get_pbd_streaks_report($user_id, $post_id) {
        global $wpdb;
        
        $user_id = ($user_id) ? $user_id : get_current_user_id();
        $table = $wpdb->prefix.'gamipress_user_earnings';

        $reports = $wpdb->get_results( "SELECT DATE_FORMAT(date, '%d-%m-%Y') as date, COUNT(DISTINCT user_earning_id) as count FROM $table WHERE user_id = $user_id AND post_id = $post_id GROUP BY DATE_FORMAT(date, '%d-%m-%Y')");

		return $reports;
    }

}