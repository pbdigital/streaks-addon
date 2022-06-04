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
        add_shortcode('streaks', array($this, 'pbd_streaks_shortcode_callback'));
    }

    public function public_scripts()
    {
        wp_register_style('pbd-sa-style', PBD_SA_URL . '/assets/css/pbd-sa-style.css', array(), '1.0');
        wp_register_style('pbd-sa-fullcalendar-css', PBD_SA_URL . '/assets/fullcalendar/main.css', array(), '1.0');
        wp_register_script('pbd-sa-fullcalendar-js', PBD_SA_URL . '/assets/fullcalendar/main.js', array(), '1.0');
    }

    public function pbd_streaks_shortcode_callback($atts = array())
    {
        extract(shortcode_atts(array(
            'id' => '',
            'count' => 1,
            'color' => '#24D8A2'
        ), $atts));

        $reports = $this->get_pbd_streaks_report($id);
        // echo '<pre>';
        // print_r($reports);

        $events = array();
        $counter = 0;
        foreach ($reports as $key => $report) {
            if ($key == 0) {
                array_push($events, [
                    'start' => $report['date'],
                    'end' => $report['date'],
                    'js_end' => $report['date']
                ]);
                $counter++;
            } else {
                $next_date = date('Y-m-d', strtotime('+1 day', strtotime($events[$counter - 1]['end'])));

                if ($next_date ==  $report['date']) {
                    $events[$counter - 1]['end'] = $report['date'];
                    $events[$counter - 1]['js_end'] = date('Y-m-d', strtotime('+1 day', strtotime($report['date'])));
                } else {
                    array_push($events, [
                        'start' => $report['date'],
                        'end' => $report['date'],
                        'js_end' => $report['date']
                    ]);
                    $counter++;
                }
            }
        }

        // to review by FE
        //wp_enqueue_style( 'guitaracademy-calendar-style', PBD_SA_URL . '/assets/css/gtr-style.css', '1.0', true );

        wp_enqueue_style('pbd-sa-style');
        wp_enqueue_style('pbd-sa-fullcalendar-css');
        wp_enqueue_script('pbd-sa-fullcalendar-js');
        wp_enqueue_script('pbd-sa-scripts', PBD_SA_URL . '/assets/js/scripts.js', array(), '1.0', true);
        wp_localize_script('pbd-sa-scripts', 'events', $events);

        ob_start();

?>

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
                        ?>
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="14" cy="14" r="14" fill="<?= $color ?>"></circle>
                                <path d="M20.817 10l-8 8-3.637-3.636" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        <?php else : ?>
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="14" cy="14" r="13" stroke="#D9D9D9" stroke-width="2" />
                                <circle cx="14" cy="14" r="7" fill="#E2E3E5" />
                            </svg>
                        <?php endif; ?>
                        <span><?= $day ?></span>
                    </div>
                <?php

                }
                ?>
            </div>
            <a href="#" class="view-full-calendar toggle-control">View Full Calendar</a>
        </div>

        <div class="page-template-pt-practice month-view" style="display: none;">
            <div id="source-calendar"></div>
            <a href="#" class="hide-full-calendar toggle-control">Hide Calendar</a>
        </div>

<?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public function get_pbd_streaks_report($post_id)
    {
        global $wpdb;

        $user_id = get_current_user_id();
        $table = $wpdb->prefix . 'gamipress_user_earnings';

        $reports = $wpdb->get_results("SELECT DATE_FORMAT(date, '%Y-%m-%d') as date, COUNT(DISTINCT user_earning_id) as count FROM $table WHERE user_id = $user_id AND post_id = $post_id GROUP BY DATE_FORMAT(date, '%Y-%m-%d')", ARRAY_A);

        return $reports;
    }
}
