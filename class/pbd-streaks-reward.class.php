<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class PBD_Streaks_Reward
{
	public function __construct()
	{
		add_filter('gamipress_activity_triggers', array( $this, 'my_prefix_custom_activity_triggers_for_purchase_a_product') );
		add_action('woocommerce_payment_complete', array( $this, 'my_prefix_custom_listener_for_purchase_a_product') );
	}

	public function my_prefix_custom_activity_triggers_for_purchase_a_product($triggers)
	{
		$triggers['PBD Streaks Custom Events'] = array(
			// Register the event my_prefix_custom_purchase_event
			'pbd_day_streak_event' => __('Day Streak', 'gamipress'),
		);

		return $triggers;
	}


	public function my_prefix_custom_listener_for_purchase_a_product($order_id)
	{
		$order = wc_get_order($order_id);
		foreach ($order->get_items() as $item) {
			// Call to gamipress_trigger_event() on each product purchased
			gamipress_trigger_event(array(
				'event' => 'my_prefix_custom_purchase_event', // Set our custom purchase event
				'user_id' => $order->user_id, // User that will be awarded is the one who made the order
				// Add any extra parameters you want
				// In this example we passed the product ID and the order object itself
				'product_id' => $item->get_product_id(),
				'order' => $order,
			));
		}
	}
	// The safe way to check if an user has perform a purchase is when an order payment is set to completed
	// So let's hook the 'woocommerce_payment_complete' action


}

new PBD_Streaks_Reward();
