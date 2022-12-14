<?php if ( ! defined( 'ABSPATH' ) ) exit;

class PBD_Streaks_Generator {

    public function __construct() {
        add_action('admin_menu', array( $this, 'admin_menus'), 10 );
        add_action( 'wp_ajax_pbd_generate_shortcode', array( $this, 'generate_shortcode_callback') );
    }

    public function admin_menus(){
        add_menu_page( 'PBD Streaks Add-on', 'Streaks Generator', 'manage_options', 'pbd-streaks-add-on', array( $this , 'pbd_streaks_generator_page' ));
    }

    public function generate_shortcode_callback()
    {
        $id = $_POST['id'];
        $color = $_POST['color'];
        $button_color = $_POST['button_color'];
        $streak_connection_color = $_POST['streak_connection_color'];
        $today_color = $_POST['today_color'];
        $class = $_POST['class'];
        $count = $_POST['count'];

        ob_start();

        ?>
            <div class="shortcode-result">
                <h4>Shorcode:</h4>
                <code>[streaks id="<?= $id ?>" color="<?= $color ?>" count="<?= $count ?>" button_color="<?= $button_color ?>" class="<?= $class ?>" streak_connection_color="<?= $streak_connection_color ?>" today_color="<?=  $today_color ?>"]</code>

                <br/><br/><br/>
                <h4>Preview:</h4>
                <?= do_shortcode('[streaks id="'. $id .'" color="'. $color .'" count="'. $count .'" button_color="'. $button_color .'" class="'. $class .'" streak_connection_color="'. $streak_connection_color .'" today_color="'.  $today_color .'"]') ?>
            </div>
        <?php


        $output = ob_get_contents();
        ob_end_clean();

        echo $output;
        exit();
    }

    public function pbd_streaks_generator_page() {

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script('pbd-sa-generator-js');
        wp_enqueue_style('pbd-sa-style');
        wp_enqueue_style('pbd-sa-fullcalendar-css');
        wp_enqueue_script('pbd-sa-fullcalendar-js');
        wp_enqueue_script('pbd-sa-circleprogress-js');
        wp_enqueue_script('pbd-sa-scripts', PBD_SA_URL . '/assets/js/scripts.js', array(), '1.0', true);

        wp_localize_script('wp-color-picker', 'pbd', [
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ]);
    
        $args = array(
            'post_type' => 'habits',
            'posts_per_page' => 1,
            'status' => 'publish'
        );
        $query = new WP_Query($args);
        $habits = $query->posts;

        ?>
            <h2>PBD Streaks Add-on Shortcode Generator</h2>
            <br />
            <div class="generator-container">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">Habit Item</th>
                            <td>
                                <select class="form-control" id="id">
                                <?php 
                                    foreach($habits as $habit) {
                                        ?><option value="<?= $habit->ID ?>"><?= $habit->post_title ?></option><?php
                                    }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Color</th>
                            <td>
                                <input type="text" name="habit-color" id="color" size="40" value="#6ae847"/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Button Color</th>
                            <td>
                                <input type="text" name="button_color" id="button_color" size="40" value="#2ad31b" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Streak Connection Color</th>
                            <td>
                                <input type="text" name="streak_connection_color" id="streak_connection_color" size="40" value="#f9f922" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Today Color</th>
                            <td>
                                <input type="text" name="today_color" id="today_color" size="40" value="#1e73be" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Class</th>
                            <td>
                                <input type="text" name="class" id="class" size="40" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Count</th>
                            <td>
                                <input type="text" name="count" id="count" size="40" value="1" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <button class="button button-primary" id="generate-button">Generate</button>
                            </th>
                        </tr>
                    </tbody>
                </table>

                <div id="pbd-preview-container"></div>
            </div>
            <style>
                .generator-container {
                    display: grid;
                    grid-template-columns: 60% 30%;
                    grid-gap: 15px;
                }
            </style>
        <?php
    }
}

new PBD_Streaks_Generator;