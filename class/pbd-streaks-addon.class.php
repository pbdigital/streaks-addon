<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class PBD_Streaks_Addon
{
    private static $instance;

    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new PBD_Streaks_Addon();
        }

        return self::$instance;
    }

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'public_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'public_scripts'));
        add_action( 'wp_default_scripts', array($this, 'wp_default_custom_scripts') );
        add_action('wp_head', array($this, 'set_cookie_user_timezone'));
        add_shortcode('streaks', array($this, 'pbd_streaks_shortcode_callback'));
        add_shortcode('longest_streaks', array($this, 'longest_streak_callback'));
        add_shortcode('current_streaks', array($this, 'current_streak_callback'));
    }

    public function public_scripts()
    {
        wp_register_style('pbd-sa-style', PBD_SA_URL . '/assets/css/pbd-sa-style.css', array(), '1.0');
        wp_register_style('pbd-sa-fullcalendar-css', PBD_SA_URL . '/assets/fullcalendar/main.css', array(), '1.0');
        wp_register_script('pbd-sa-fullcalendar-js', PBD_SA_URL . '/assets/fullcalendar/main.js', array(), '1.0');
        wp_register_script('pbd-sa-circleprogress-js', PBD_SA_URL . '/assets/js/circle-progress.min.js', array(), '1.0');

    }


    public function admin_scripts()
    {
        wp_register_script('pbd-sa-generator-js', PBD_SA_URL . '/assets/js/generator.js', array(), '1.0');
    }

    public function wp_default_custom_scripts( $scripts ){
        $suffix = SCRIPT_DEBUG ? '' : '.min';
        $scripts->add( 'iris', '/wp-admin/js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), '1.0.7', 1 );
        $scripts->add( 'wp-color-picker', "/wp-admin/js/color-picker$suffix.js", array( 'iris' ), false, 1 );
        $scripts->set_translations( 'wp-color-picker' );
    }
    public function set_cookie_user_timezone()
    {
        if ( ! isset( $_COOKIE['tribe_browser_time_zone'] ) ) { 
            ?>
            <script type="text/javascript">
                if ( navigator.cookieEnabled ) {
                    document.cookie = "pbd_streaks_time_zone=" + Intl.DateTimeFormat().resolvedOptions().timeZone + "; path=/";
                }
            </script>
            <?php 
        }

    }

    public function pbd_streaks_shortcode_callback($atts = array())
    {
        extract(shortcode_atts(array(
            'id' => '',
            'count' => 1,
            'color' => '#24D8A2',
            'button_color' => '',
            'streak_connection_color' => '',
            'class' => '',
            // 'timezone' => '',
            'today_color' => ''
        ), $atts));

        $reports = $this->get_pbd_streaks_report($id);

        // convert date to user timezone convert_date_to_local_timezone
        foreach ($reports as $key => $report) {
            $reports[$key]['date'] = $this->convert_date_to_local_timezone($report['date']);
        }

        wp_enqueue_style('pbd-sa-style');
        wp_enqueue_style('pbd-sa-fullcalendar-css');
        wp_enqueue_script('pbd-sa-fullcalendar-js');
        wp_enqueue_script('pbd-sa-circleprogress-js');
        wp_enqueue_script('pbd-sa-scripts', PBD_SA_URL . '/assets/js/scripts.js', array(), '1.0', true);


        $calender_id = 'elc-' . bin2hex(random_bytes(4));
        wp_localize_script('pbd-sa-scripts', 'pbd', [
            'events' => $reports, 
            'color' => $color,
            'calender_id' => $calender_id
        ]);

        ob_start();
        
        ?>
        <div class="goal-body <?= $class ?>">
            <div class="week-view">
                <div class="week user-weekdays">
                    <?php
                    $weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                    foreach ($weekdays as $fullday) {
                        $wd = substr($fullday, 0, 2);
                        if ($wd == "Su") {
                            $date = date("Y-m-d", strtotime($fullday . " last week"));
                            $day = date("j", strtotime($fullday . " last week"));
                        } else {
                            $date = date("Y-m-d", strtotime($fullday . " this week"));
                            $day = date("j", strtotime($fullday . " this week"));
                        }


                        $found_key = array_search($date, array_column($reports, 'date'));

                    ?>
                        <div class="day weekday <?= ($date == date('Y-m-d')) ? 'today' : '' ?>" data-date="<?= $date ?>">
                            <span><?= substr($wd, 0, 1) ?></span>

                            <?php
                            if ((string)$found_key >= '0') :
                                $progress_percent = number_format(($reports[$found_key]['count'] / $count) * 100);
                                $progress_percent = 100;
                                //TODO: Add ability to have progression
                                if ($progress_percent < 100):
                                ?>
                                    <div class="<?= $calender_id ?> day-status"
                                        data-value="<?= $progress_percent / 100 ?>">
                                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18 33.429c8.521 0 15.429-6.908 15.429-15.429S26.52 2.571 18 2.571 2.571 9.48 2.571 18 9.48 33.429 18 33.429ZM18 36c9.941 0 18-8.059 18-18S27.941 0 18 0 0 8.059 0 18s8.059 18 18 18Z" fill="#D2D2D2"/>
                                            <path d="M27 18a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" fill="#D2D2D2"/>
                                        </svg>
                                        
                                    </div>
                                <?php
                                else:
                                ?>
                                    <div>
                                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="18" cy="18" r="18" fill="<?= $color ?>"/>
                                        <path d="M26 13L15 24L10 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                <?php
                                endif;
                            ?>
                            <?php else : ?>
                                <div class="<?= $calender_id ?> day-status">
                                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18 33.429c8.521 0 15.429-6.908 15.429-15.429S26.52 2.571 18 2.571 2.571 9.48 2.571 18 9.48 33.429 18 33.429ZM18 36c9.941 0 18-8.059 18-18S27.941 0 18 0 0 8.059 0 18s8.059 18 18 18Z" fill="#D2D2D2"/>
                                        <path d="M27 18a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" fill="#D2D2D2"/>
                                    </svg>
                                    
                                </div>

                            <?php endif; ?>
                            <span><?= $day ?></span>
                        </div>
                    <?php

                    }
                    ?>
                </div>
                <a href="#" class="view-full-calendar toggle-control" <?= ($button_color) ? 'style="color: '.$button_color.'"' : '' ?> data-id="<?= $calender_id ?>" data-events='<?= json_encode($reports) ?>'>View Full Calendar</a>
            </div>


            <div class="page-template-pt-practice month-view" style="display: none;">
                <div id="<?= $calender_id  ?>" class="src-calendar"></div>
                <a href="#" class="hide-full-calendar toggle-control" <?= ($button_color) ? 'style="color: '.$button_color.'"' : '' ?> >Hide Calendar</a>
                <style>
                    .goal-body<?=  ($class) ? '.'.$class : '' ?> #<?= $calender_id  ?> .fc-daygrid-day-events a {
                        background: <?= $color ?> !important;
                    }
                    
                    <?php if ($streak_connection_color) : ?>
                        .goal-body<?=  ($class) ? '.'.$class : '' ?> #<?= $calender_id  ?> .active-streak::after {
                            background: <?= $streak_connection_color ?> !important;
                        }

                        .goal-body<?=  ($class) ? '.'.$class : '' ?> #<?= $calender_id  ?> .active-streak ~ .active-streak::before {
                            background: <?= $streak_connection_color ?> !important;
                        }
                    <?php endif; ?>

                    <?php if ($today_color) : ?>
                        .goal-body<?=  ($class) ? '.'.$class : '' ?> #<?= $calender_id  ?> .active-streak::after {
                            background: <?= $streak_connection_color ?> !important;
                        }
                        
                        .goal-body<?=  ($class) ? '.'.$class : '' ?> #<?= $calender_id  ?> .active-streak ~ .active-streak::before {
                            background: <?= $streak_connection_color ?> !important;
                        }
  
                        <?php //if ((int)$progress_percent < 100) : ?>
                        .goal-body<?=  ($class) ? '.'.$class : '' ?> #<?= $calender_id  ?> .fc-day-today:not(.active-streak)  .fc-daygrid-day-number {
                            background: <?= $today_color ?> !important;
                            /* hint here */
                        }
                        <?php //endif; ?>
                    <?php endif; ?>
                </style>
                <script>
                    jQuery(function($) {
                        // circle progress bar for week view
                        let dayStatus = $('.<?= $calender_id  ?>.day-status');

                        dayStatus.circleProgress({
                            size: 36,
                            startAngle: -1.55,
                            lineCap: 'round',
                            fill: {color: '<?= $color ?>'}
                        });
                    })
                    
                </script>
            </div>
        </div>
        <?php


        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public function longest_streak_callback($atts = array())
    {
        extract(shortcode_atts(array(
            'id' => ''
        ), $atts));

        return (int)max($this->streaks_count_record($id));
    }

    public function current_streak_callback($atts = array())
    {
        extract(shortcode_atts(array(
            'id' => ''
        ), $atts));

        $reports = $this->get_pbd_streaks_report($id);

        $new_format = array();
        foreach($reports as $report) {
            $new_format[] = $report['date'];
        }

        $datetime = new DateTime();
        $today = $datetime->format('Y-m-d');
        $key = array_search($today, $new_format);

        $count = 1;
        if ($key == null)
            return 0;
        else {
            for ($x = $key; $x > 0; $x--) {
                $datetime = new DateTime($new_format[$x]);
                $datetime->modify('-1 day');

                if ($datetime->format('Y-m-d') == $new_format[$x - 1]) {
                    $count += 1;
                } else {
                    break;
                }
            }
        }

        return $count;

    }

    public function get_pbd_streaks_report($post_id)
    {
        global $wpdb;

        $user_id = get_current_user_id();
        $table = $wpdb->prefix . 'gamipress_user_earnings';

        $reports = $wpdb->get_results("SELECT date, COUNT(DISTINCT user_earning_id) as count FROM $table WHERE user_id = $user_id AND post_id = $post_id GROUP BY DATE_FORMAT(date, '%Y-%m-%d')", ARRAY_A);

        return $reports;
    }

    public function streaks_count_record($id) {
        $reports = $this->get_pbd_streaks_report($id);

        $counts = array();
        $count = 0;
        foreach($reports as $key => $report) {
            $datetime = new DateTime($report['date']);
            $datetime->modify('+1 day');
            
            if ($key == (count($reports) - 1)) {
                break;
            } else {
                if ($datetime->format('Y-m-d') == $reports[$key + 1]['date']) {
                    $count += 1;
                } else {
                    $count = 1;
                }
            }
            array_push($counts, $count);
        }

        return $counts;

    }

    public function convert_date_to_local_timezone($date) {
        // timezone sample Asia/Manila
        $browser_time_zone_string = $_COOKIE['pbd_streaks_time_zone'];
        $browser_time_zone = new DateTimeZone($browser_time_zone_string);
        $date = new DateTime($date);
        $date->setTimezone($browser_time_zone);
        return $date->format('Y-m-d');
    }

    
}
