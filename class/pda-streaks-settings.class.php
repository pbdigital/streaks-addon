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
        add_submenu_page( 'options-general.php', 'Streaks Addon', 'Streaks Addon', 'manage_options','pbd-streaks-settings', array( $this , 'pbd_sa_settings_page' ) );
    }

    public function pbd_sa_settings_page() {
        include_once(PBD_SA_PATH_INCLUDES . '/settings.php');
    }
}

new PBD_Streaks_Settings;