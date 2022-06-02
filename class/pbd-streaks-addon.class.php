<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class PBD_Streaks_Addon {
    private static $instance;

	public static function get_instance() {
		if( null == self::$instance ) {
            self::$instance = new PBD_Streaks_Addon();
        }

		return self::$instance;
    }

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'public_scripts' ) );
        add_shortcode( 'streaks', array( $this, 'pbd_streaks_shortcode_callback' ) );
    }

    public function public_scripts() {
        wp_register_style( 'pbd-sa-style', PBD_SA_URL . '/assets/css/pbd-sa-style.css', '1.0', true );
		wp_enqueue_style( 'pbd-sa-style' );
    }

    public function pbd_streaks_shortcode_callback( $atts = array() ) {
        extract ( shortcode_atts( array( 
            'id' => '',
            'count' => 1,
            'color' => '#24D8A2'
        ), $atts ));

        $reports = $this->get_pbd_streaks_report( $id );
        

        ob_start();

        ?>
            <div class="week user-weekdays">
                <?php
                    $weekdays = [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];
                    foreach( $weekdays as $fullday ){
						$wd = substr($fullday,0,2);
						if( $wd == "Su" ) {
                            $date = date( "d-m-Y", strtotime($fullday." last week") );
                            $day = date( "d", strtotime($fullday." last week") );
                        } else {
                            $date = date( "d-m-Y", strtotime($fullday." this week") );
                            $day = date( "d", strtotime($fullday." last week") );
                        }

                        $found_key = array_search($date, array_column($reports, 'date'));

                        if ( (string)$found_key == '0' ) {
                            ?>
                            <div class="day weekday <?= $wd ?> day-<?= $date ?> <?= $fullday ?>  data-abbr="<?= $wd ?>" data-date="<?= $date ?>">
                                <span><?= $wd ?></span>
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="14" cy="14" r="14" fill="<?= $color ?>"></circle><path d="M20.817 10l-8 8-3.637-3.636" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                <span><?= $day ?></span>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="day weekday <?= $wd ?> day-<?= $date ?> <?= $fullday ?>  data-abbr="<?= $wd ?>" data-date="<?= $date ?>">
                                <span><?= $wd ?></span>
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="14" cy="14" r="13" stroke="#D9D9D9" stroke-width="2"/>
                                    <circle cx="14" cy="14" r="7" fill="#E2E3E5"/>
                                </svg>
                                <span><?= $day ?></span>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        <?php

        $output = ob_get_contents();
		ob_end_clean();

		return $output;

    }
    
    public function get_pbd_streaks_report( $post_id ) {
        global $wpdb;
        
        $user_id = get_current_user_id();
        $table = $wpdb->prefix.'gamipress_user_earnings';

        $reports = $wpdb->get_results( "SELECT DATE_FORMAT(date, '%d-%m-%Y') as date, COUNT(DISTINCT user_earning_id) as count FROM $table WHERE user_id = $user_id AND post_id = $post_id GROUP BY DATE_FORMAT(date, '%d-%m-%Y')", ARRAY_A);

	    return $reports;
    }

}