<?php if ( ! defined( 'ABSPATH' ) ) exit;

class PBD_Streaks_Settings {

    public function __construct() {
        add_action('admin_menu', array( $this, 'admin_menus'), 10 );
        add_action('admin_init', array( $this, 'register_settings' ));
    }

    public function register_settings() {
        register_setting( 'pbd_sa_settings', 'pbd_sa_settings', '' );
        register_setting( 'pdat_googleapi_settings', 'pdat_googleapi_settings', '' );
    }

    public function admin_menus(){
        add_menu_page ( 'PBD Streaks' , 'PBD Streaks' , 'manage_options' , 'pbd-streaks-settings' , array( $this , 'pbd_sa_settings_page' ));
    }

    public function pbd_sa_settings_page() {
        // $pbd_sa_settings = get_option('pbd_sa_settings');
        include_once(PBD_SA_PATH_INCLUDES . '/settings.php');
    }

    // public function pdat_completed_merges() {
    //     $pdat_completed_merges = get_option('pdat_completed_merges');
    //     include_once(PDAT_PATH_INCLUDES . '/completed-merges.php');
    // }
}

new PBD_Streaks_Settings;