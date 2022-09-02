<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class PBD_Streaks_Reward
{
	public function __construct()
	{
		add_filter( 'gamipress_activity_triggers', array( $this, 'pbdigital_habit_custom_activity_triggers' ));
		add_action('gamipress_award_achievement', array( $this, 'strks_gamipress_award_achievement'), 10, 5);
	}

	public function pbdigital_habit_custom_activity_triggers( $triggers ) {

		$pbd_sa_settings  = get_option('pbd_sa_settings');
		$days_streak = explode(",", $pbd_sa_settings['days_streak']);
		$achievement_ids = $pbd_sa_settings['achievement_ids'];

		foreach ($achievement_ids as $achievement_id) {
			$title = get_the_title( preg_replace('/\s+/', '',  $achievement_id));
			foreach($days_streak as $streak){
				$triggers['Habit Tracker']['streak_'. $streak . '_' . $achievement_id] = __( $title .' Streak of '.$streak.' days', 'gamipress' );
			}
		}
	
		return $triggers;
	}

	public function strks_gamipress_award_achievement( $user_id, $achievement_id, $trigger, $site_id, $args ){

		$pbd_sa_settings  = get_option('pbd_sa_settings');
		$achievement_ids = $pbd_sa_settings['achievement_ids'];

		if ( in_array($achievement_id, $achievement_ids) ) {
			$pbd_addon = new PBD_Streaks_Addon;
			$current_streak = $pbd_addon->streaks_count_record($achievement_id);
			$current_streak = end($current_streak);
			$days_streak = explode(",", $pbd_sa_settings['days_streak']);

			if ( in_array($current_streak, $days_streak) ){
				//if so, trigger our custom trigger using gamipress_trigger_event()
				gamipress_trigger_event( array(
					'event' => 'streak_'. $current_streak . '_' . $achievement_id,
					'user_id' => $user_id
				) );
			}
		}
	
	
	}

}

new PBD_Streaks_Reward();
