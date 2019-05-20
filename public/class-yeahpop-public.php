<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://andrevitorio.com
 * @since      0.1
 *
 * @package    Yeahpop
 * @subpackage Yeahpop/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Yeahpop
 * @subpackage Yeahpop/public
 * @author     Andre Vitorio <andre@vitorio.net>
 */
class Yeahpop_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/yeahpop-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function enqueue_scripts() {

		if (is_product()) {


			$names = $this->get_random_names();
			$cities = $this->get_random_cities();

			// Get product
			$product_id = get_the_ID();
			$product = wc_get_product( $product_id );

			$orders = $this->retrieve_orders_data( $product_id );

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/yeahpop-public.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, $this->plugin_name . '_object',
			array( 
				'product_title' => $product->get_title(),
				'product_image' => $product->get_image(),
				'orders' => $orders,
			));
		}

	}

	/**
	 * Add the popup html code.
	 *
	 * @since    0.1
	 */
	public function popup_html_code() {

		if (is_product()) {

			echo '<section class="custom-social-proof">
				<div class="custom-notification">
				<div class="custom-notification-container">
					<div class="custom-notification-image-wrapper">
					</div>
					<div class="custom-notification-content-wrapper">
					<p class="custom-notification-content">
						<span id="ypop-customer"></span>
						from <span id="ypop-location"></span>
						<br>
						<small>Purchased <b></b>
						<span id="ypop-product-name"></span></small>
						<small id="ypop-time"></small>
					</p>
					</div>
				</div>
				<div class="custom-close"></div>
				</div>
			</section>';

		}

	}

	public function get_random_names($length = 5) {
		$names = array('Allison', 'Arthur', 'Ana', 'Alex', 'Arlene', 'Alberto', 'Barry', 'Bertha', 'Bill', 'Bonnie', 'Bret', 'Beryl', 'Chantal', 'Cristobal', 'Claudette', 'Charley', 'Cindy', 'Chris', 'Dean', 'Dolly', 'Danny', 'Danielle', 'Dennis', 'Debby', 'Erin', 'Edouard', 'Erika', 'Earl', 'Emily', 'Ernesto', 'Felix', 'Fay', 'Fabian', 'Frances', 'Franklin', 'Florence', 'Gabielle', 'Gustav', 'Grace', 'Gaston', 'Gert', 'Gordon', 'Humberto', 'Hanna', 'Henri', 'Hermine', 'Harvey', 'Helene', 'Iris', 'Isidore', 'Isabel', 'Ivan', 'Irene', 'Isaac', 'Jerry', 'Josephine', 'Juan', 'Jeanne', 'Jose', 'Joyce', 'Karen', 'Kyle', 'Kate', 'Karl', 'Katrina', 'Kirk', 'Lorenzo', 'Lili', 'Larry', 'Lisa', 'Lee', 'Leslie', 'Michelle', 'Marco', 'Mindy', 'Maria', 'Michael', 'Noel', 'Nana', 'Nicholas', 'Nicole', 'Nate', 'Nadine', 'Olga', 'Omar', 'Odette', 'Otto', 'Ophelia', 'Oscar', 'Pablo', 'Paloma', 'Peter', 'Paula', 'Philippe', 'Patty', 'Rebekah', 'Rene', 'Rose', 'Richard', 'Rita', 'Rafael', 'Sebastien', 'Sally', 'Sam', 'Shary', 'Stan', 'Sandy', 'Tanya', 'Teddy', 'Teresa', 'Tomas', 'Tammy', 'Tony', 'Van', 'Vicky', 'Victor', 'Virginie', 'Vince', 'Valerie', 'Wendy', 'Wilfred', 'Wanda', 'Walter', 'Wilma', 'William', 'Kumiko', 'Aki', 'Miharu', 'Chiaki', 'Michiyo', 'Itoe', 'Nanaho', 'Reina', 'Emi', 'Yumi', 'Ayumi', 'Kaori', 'Sayuri', 'Rie', 'Miyuki', 'Hitomi', 'Naoko', 'Miwa', 'Etsuko', 'Akane', 'Kazuko', 'Miyako', 'Youko', 'Sachiko', 'Mieko', 'Toshie', 'Junko');

		$keys = array_rand( $names , $length);

		$random_names = array();
		for ($i = 0; $i < $length; $i++) {
			$random_names[$i] = $names[$keys[$i]] . ' ' . chr(rand(65,90)) . '.';
		}

		return $random_names;
	}

	public function get_random_cities($length = 5) {
		

		$cities = array('New York, NY', 'Los Angeles, CA', 'Chicago, IL', 'Miami, FL', 'Dallas, TX', 'Philadelphia, PA', 'Houston, TX', 'Washington, DC', 'Atlanta, GA', 'Boston, MA', 'Phoenix, AZ', 'Seattle, WA', 'San Francisco, CA', 'Detroit, MI', 'San Diego, CA', 'Minneapolis, MN', 'Tampa, FL', 'Denver, CO', 'Brooklyn, NY', 'Queens, NY', 'Baltimore, MD', 'Riverside, CA', 'Saint Louis, MO', 'Las Vegas, NV', 'Portland, OR', 'San Antonio, TX', 'Sacramento, CA', 'San Jose, CA', 'Orlando, FL', 'Cleveland, OH', 'Pittsburgh, PA', 'Cincinnati, OH', 'Manhattan, NY', 'Austin, TX', 'Kansas City, MO', 'Indianapolis, IN', 'Columbus, OH', 'Virginia Beach, VA', 'Charlotte, NC', 'Bronx, NY', 'Milwaukee, WI', 'Providence, RI', 'Jacksonville, FL', 'Salt Lake City, UT', 'Nashville, TN', 'Memphis, TN', 'Richmond, VA', 'New Orleans, LA', 'Raleigh, NC', 'Louisville, KY', 'Oklahoma City, OK', 'Bridgeport, CT', 'Buffalo, NY', 'Hartford, CT', 'Fort Worth, TX', 'Tucson, AZ', 'El Paso, TX', 'Honolulu, HI', 'Omaha, NE', 'McAllen, TX', 'Albuquerque, NM', 'Birmingham, AL', 'Dayton, OH', 'Rochester, NY', 'Sarasota, FL', 'Fresno, CA', 'Allentown, PA', 'Tulsa, OK', 'Concord, CA', 'Cape Coral, FL', 'Springfield, MA', 'Colorado Springs, CO', 'Charleston, SC', 'Grand Rapids, MI', 'Mission Viejo, CA', 'Albany, NY', 'Knoxville, TN', 'Baton Rouge, LA', 'Bakersfield, CA', 'Ogden, UT', 'New Haven, CT', 'Columbia, SC', 'Akron, OH', 'Provo, UT', 'Worcester, MA', 'Mesa, AZ', 'Palm Bay, FL', 'Toledo, OH', 'Murrieta, CA', 'Wichita, KS', 'Des Moines, IA', 'Staten Island, NY', 'Long Beach, CA', 'Greenville, SC', 'Little Rock, AR', 'Harrisburg, PA', 'Denton, TX', 'Madison, WI', 'Reno, NV');

		$keys = array_rand( $cities , $length);

		$random_cities = array();
		for ($i = 0; $i < $length; $i++) {
			$random_cities[$i] = $cities[$keys[$i]];
		}

		return $random_cities;
	}

	public function retrieve_orders_data( $product_id ) {
		global $wpdb;

		// Define HERE the orders status to include in  <==  <==  <==  <==  <==  <==  <==
		$orders_statuses = "'wc-completed', 'wc-processing', 'wc-on-hold'";

		# Requesting All defined statuses Orders IDs for a defined product ID
		$orders_ids = $wpdb->get_col( "
			SELECT DISTINCT woi.order_id
			FROM {$wpdb->prefix}woocommerce_order_itemmeta as woim, 
				{$wpdb->prefix}woocommerce_order_items as woi, 
				{$wpdb->prefix}posts as p
			WHERE  woi.order_item_id = woim.order_item_id
			AND woi.order_id = p.ID
			AND p.post_status IN ( $orders_statuses )
			AND woim.meta_key LIKE '_product_id'
			AND woim.meta_value LIKE '$product_id'
			ORDER BY woi.order_item_id ASC LIMIT 5"
		);


		$orders_data = array();

		foreach ($orders_ids as $order_id) {
			$order    = new WC_Order( $order_id );
			$address = $order->get_address();

			$state_country = $address['country'] == 'US' ? $address['state'] : $address['country'];
			$date = $this->time_elapsed_string($order->get_date_created());

			$customer_info = array(
				'id' => $order_id,
				'name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name()[0] . '.',
				'location' => $address['city'] . ', ' . $state_country,
				'date' => $date
			);

			array_push($orders_data, $customer_info);
		}
		// Return an array of Orders IDs for the given product ID
		return $orders_data;
	}

	public function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

}
