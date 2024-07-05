<?php

if ( class_exists( 'TribeWooTickets' ) || ! class_exists( 'TribeEventsTickets' ) )
	return;

class TribeWooTickets extends TribeEventsTickets {

	/**
	 * Name of the CPT that holds Attendees (tickets holders)
	 * @var string
	 */
	public $attendee_object = 'tribe_wooticket';
	/**
	 * Meta key that relates Products and Events
	 * @var string
	 */
	public $event_key = '_tribe_wooticket_for_event';
	/**
	 * Meta key that stores if an attendee has checked in to an event
	 * @var string
	 */
	public $checkin_key = '_tribe_wooticket_checkedin';
	/**
	 * Meta key that relates Attendees and Products
	 * @var string
	 */
	public $atendee_product_key = '_tribe_wooticket_product';
	/**
	 * Meta key that relates Attendees and Orders
	 * @var string
	 */
	public $atendee_order_key = '_tribe_wooticket_order';
	/**
	 * Meta key that relates Attendees and Events
	 * @var string
	 */
	public $atendee_event_key = '_tribe_wooticket_event';
	/**
	 * Meta key that holds the security code that's printed in the tickets
	 * @var string
	 */
	public $security_code = '_tribe_wooticket_security_code';
	/**
	 * Meta key that holds if an order has tickets (for performance)
	 * @var string
	 */
	public $order_has_tickets = '_tribe_has_tickets';
	/**
	 * Meta key that holds the name of a ticket to be used in reports if the Product is deleted
	 * @var string
	 */
	public $deleted_product = '_tribe_deleted_product_name';

	/**
	 * Holds an instance of the TribeWooTicketsEmail class
	 * @var TribeWooTicketsEmail
	 */
	private $mailer = null;

	/**
	 * Current version of this plugin
	 */
	const VERSION = '3.2';
	/**
	 * Min required The Events Calendar version
	 */
	const REQUIRED_TEC_VERSION = '3.2';
	/**
	 * Min required WooCommerce version
	 */
	const REQUIRED_WC_VERSION = '2.0';

	/**
	 * Class constructor
	 */
	public function __construct() {

		load_plugin_textdomain( 'tribe-wootickets', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/lang/' );

		/* Set up some parent's vars */
		$this->pluginName = 'WooCommerce';
		$this->pluginSlug = 'wootickets';
		$this->pluginPath = trailingslashit( dirname( dirname( __FILE__ ) ) );
		$this->pluginUrl  = trailingslashit( plugins_url( '', $this->pluginPath ) );

		parent::__construct();

		$this->hooks();

	}

	/**
	 * Registers all actions/filters
	 */
	public function hooks() {

		add_action( 'init',                                 array( $this, 'process_front_end_tickets_form'  )         );
		add_action( 'init',                                 array( $this, 'register_wootickets_type'        )         );
		add_action( 'add_meta_boxes',                       array( $this, 'woocommerce_meta_box'            )         );
		add_action( 'before_delete_post',                   array( $this, 'handle_delete_post'              )         );
		add_action( 'woocommerce_order_status_completed',   array( $this, 'generate_tickets'                ), 12     );
		add_action( 'woocommerce_email_after_order_table',  array( $this, 'add_tickets_msg_to_email'        ), 10, 2  );

		add_filter( 'post_type_link',            array( $this, 'hijack_ticket_link'             ), 10, 4  );
		add_filter( 'woocommerce_email_classes', array( $this, 'add_email_class_to_woocommerce' )         );

		add_action( 'woocommerce_resend_order_emails_available', array( $this, 'add_resend_tickets_action' ) );

	}


	/**
	 * When a user deletes a ticket (product) we want to store
	 * a copy of the product name, so we can show it in the
	 * attendee list for an event.
	 *
	 * @param $post_id
	 */
	function handle_delete_post( $post_id ) {

		$post_to_delete = get_post( $post_id );

		// Bail if it's not a Product
		if ( get_post_type( $post_to_delete ) !== 'product' )
			return;

		// Bail if the product is not a Ticket
		$event = get_post_meta( $post_id, $this->event_key, true );
		if ( $event === false )
			return;

		$attendees = $this->get_attendees( $event );

		foreach ( (array) $attendees as $attendee ) {
			if ( $attendee['product_id'] == $post_id ) {
				update_post_meta( $attendee['attendee_id'], $this->deleted_product, esc_html( $post_to_delete->post_title ) );
			}
		}

	}

	/**
	 * Add a custom email handler to WooCommerce email system
	 *
	 * @param array $classes of WC_Email objects
	 *
	 * @return array of WC_Email objects
	 */
	function add_email_class_to_woocommerce( $classes ) {

		include_once 'class-ticket-email.php';
		$this->mailer                    = new TribeWooTicketsEmail();
		$classes['TribeWooTicketsEmail'] = $this->mailer;

		return $classes;
	}

	/**
	 * Register our custom post type
	 */
	function register_wootickets_type() {

		$args = array( 'label'           => 'Tickets',
		               'public'          => false,
		               'show_ui'         => false,
		               'show_in_menu'    => false,
		               'query_var'       => false,
		               'rewrite'         => false,
		               'capability_type' => 'post',
		               'has_archive'     => false,
		               'hierarchical'    => true, );

		register_post_type( $this->attendee_object, $args );
	}

	/**
	 * Generate and store all the attendees information for a new order.
	 * @param $order_id
	 */
	public function generate_tickets( $order_id ) {

		// Bail if we already generated the info for this order
		$done = get_post_meta( $order_id, $this->order_has_tickets, true );
		if ( ! empty( $done ) )
			return;

		$has_tickets = false;
		// Get the items purchased in this order

		$order       = new WC_Order( $order_id );
		$order_items = $order->get_items();

		// Bail if the order is empty
		if ( empty( $order_items ) )
			return;

		// Iterate over each product
		foreach ( (array) $order_items as $item ) {

			$product_id = isset( $item['product_id'] ) ? $item['product_id'] : $item['id'];

			// Get the event this tickets is for
			$event_id = get_post_meta( $product_id, $this->event_key, true );

			if ( ! empty( $event_id ) ) {

				$has_tickets = true;

				// Iterate over all the amount of tickets purchased (for this product)
				for ( $i = 0; $i < intval( $item['qty'] ); $i ++ ) {

					$attendee = array( 'post_status' => 'publish',
					                   'post_title'  => $order_id . ' | ' . $item['name'] . ' | ' . ( $i + 1 ),
					                   'post_type'   => $this->attendee_object,
					                   'ping_status' => 'closed' );

					// Insert individual ticket purchased
					$attendee_id = wp_insert_post( $attendee );

					update_post_meta( $attendee_id, $this->atendee_product_key, $product_id );
					update_post_meta( $attendee_id, $this->atendee_order_key, $order_id );
					update_post_meta( $attendee_id, $this->atendee_event_key, $event_id );
					update_post_meta( $attendee_id, $this->security_code, $this->generate_security_code( $order_id, $attendee_id ) );
				}
			}
		}
		if ( $has_tickets ) {
			update_post_meta( $order_id, $this->order_has_tickets, '1' );

			// Send the email to the user
			do_action( 'wootickets-send-tickets-email', $order_id );
		}

	}

	/**
	 * Generates the validation code that will be printed in the ticket.
	 * It purpose is to be used to validate the ticket at the door of an event.
	 *
	 * @param int $order_id
	 * @param int $attendee_id
	 *
	 * @return string
	 */
	private function generate_security_code( $order_id, $attendee_id ) {
		return substr( md5( $order_id . '_' . $attendee_id ), 0, 10 );
	}

	/**
	 * Adds a message to WooCommerce's order email confirmation.
	 * @param $order
	 */
	public function add_tickets_msg_to_email( $order ) {

		$order_items = $order->get_items();

		// Bail if the order is empty
		if ( empty( $order_items ) )
			return;

		$has_tickets = false;

		// Iterate over each product
		foreach ( (array) $order_items as $item ) {

			$product_id = isset( $item['product_id'] ) ? $item['product_id'] : $item['id'];

			// Get the event this tickets is for
			$event_id = get_post_meta( $product_id, $this->event_key, true );

			if ( ! empty( $event_id ) ) {
				$has_tickets = true;
				break;
			}
		}
		if ( ! $has_tickets )
			return;

		$message = apply_filters( "wootickets_email_message", "You'll receive your tickets in another email." );
		echo '<br/>' . __( $message, "tribe-wootickets" );
	}



	/**
	 * Saves a given ticket (WooCommerce product)
	 *
	 * @param int                     $event_id
	 * @param TribeEventsTicketObject $ticket
	 * @param array                   $raw_data
	 *
	 * @return bool
	 */
	public function save_ticket( $event_id, $ticket, $raw_data = array() ) {

		if ( empty( $ticket->ID ) ) {
			/* Create main product post */
			$args = array( 'post_status'  => 'publish',
			               'post_type'    => 'product',
			               'post_author'  => get_current_user_id(),
			               'post_excerpt' => $ticket->description,
			               'post_title'   => $ticket->name );

			$ticket->ID = wp_insert_post( $args );

			update_post_meta( $ticket->ID, '_visibility', 'hidden' );
			update_post_meta( $ticket->ID, '_tax_status', 'taxable' );
			update_post_meta( $ticket->ID, '_tax_class', '' );
			update_post_meta( $ticket->ID, '_purchase_note', '' );
			update_post_meta( $ticket->ID, '_weight', '' );
			update_post_meta( $ticket->ID, '_length', '' );
			update_post_meta( $ticket->ID, '_width', '' );
			update_post_meta( $ticket->ID, '_height', '' );
			update_post_meta( $ticket->ID, '_downloadable', 'no' );
			update_post_meta( $ticket->ID, '_virtual', 'yes' );
			update_post_meta( $ticket->ID, '_sale_price_dates_from', '' );
			update_post_meta( $ticket->ID, '_sale_price_dates_to', '' );
			update_post_meta( $ticket->ID, '_product_attributes', array() );
			update_post_meta( $ticket->ID, '_sale_price', '' );
			update_post_meta( $ticket->ID, 'total_sales', 0 );

			// Relate event <---> ticket
			add_post_meta( $ticket->ID, $this->event_key, $event_id );

		} else {
			$args = array( 'ID'           => $ticket->ID,
			               'post_excerpt' => $ticket->description,
			               'post_title'   => $ticket->name );

			$ticket->ID = wp_update_post( $args );
		}

		if ( ! $ticket->ID )
			return false;

		update_post_meta( $ticket->ID, '_regular_price', $ticket->price );
		update_post_meta( $ticket->ID, '_price', $ticket->price );

		if ( trim( $raw_data['ticket_woo_stock'] ) !== '' ) {
			update_post_meta( $ticket->ID, '_stock', $raw_data['ticket_woo_stock'] );
			update_post_meta( $ticket->ID, '_stock_status', 'instock' );
			update_post_meta( $ticket->ID, '_backorders', 'no' );
			update_post_meta( $ticket->ID, '_manage_stock', 'yes' );
			delete_transient( 'wc_product_total_stock_' . $ticket->ID );
		} else {
			update_post_meta( $ticket->ID, '_manage_stock', 'no' );
		}

		if ( isset( $raw_data['ticket_woo_sku'] ) )
			update_post_meta( $ticket->ID, '_sku', $raw_data['ticket_woo_sku'] );

		if ( isset( $ticket->start_date ) ) {
			update_post_meta( $ticket->ID, '_ticket_start_date', $ticket->start_date );
		} else {
			delete_post_meta( $ticket->ID, '_ticket_start_date' );
		}

		if ( isset( $ticket->end_date ) ) {
			update_post_meta( $ticket->ID, '_ticket_end_date', $ticket->end_date );
		} else {
			delete_post_meta( $ticket->ID, '_ticket_end_date' );
		}

		wp_set_object_terms( $ticket->ID, 'Ticket', 'product_cat', true );

		return true;
	}

	/**
	 * Deletes a ticket
	 *
	 * @param $event_id
	 * @param $ticket_id
	 *
	 * @return bool
	 */
	public function delete_ticket( $event_id, $ticket_id ) {
		$delete = wp_delete_post( $ticket_id, true );

		return ( ! is_wp_error( $delete ) );
	}

	/**
	 * Returns all the tickets for an event
	 *
	 * @param int $event_id
	 *
	 * @return array
	 */


	protected function get_tickets( $event_id ) {

		$ticket_ids = $this->get_tickets_ids( $event_id );

		if ( ! $ticket_ids )
			return array();

		$tickets = array();

		foreach ( $ticket_ids as $post ) {
			$tickets[] = $this->get_ticket( $event_id, $post );
		}

		return $tickets;
	}

	/**
	 * Replaces the link to the WC product with a link to the Event in the
	 * order confirmation page.
	 *
	 * @param $post_link
	 * @param $post
	 * @param $leavename
	 * @param $sample
	 *
	 * @return string
	 */
	public function hijack_ticket_link( $post_link, $post, $leavename, $sample ) {

		if ( $post->post_type === 'product' ) {
			$event = get_post_meta( $post->ID, $this->event_key, true );
			if ( ! empty( $event ) ) {
				$post_link = get_permalink( $event );
			}
		}

		return $post_link;
	}


	/**
	 * Shows the tickets form in the front end
	 *
	 * @param $content
	 * @return void
	 */
	public function front_end_tickets_form( $content ) {

		global $post;

		$tickets = self::get_tickets( $post->ID );

		if ( empty( $tickets ) )
			return;

		include $this->getTemplateHierarchy( 'wootickets/tickets' );

	}

	/**
	 * Grabs the submitted front end tickets form and adds the products
	 * to the cart
	 */
	public function process_front_end_tickets_form() {

		global $woocommerce;

		if ( empty( $_GET['wootickets_process'] ) || intval( $_GET['wootickets_process'] ) !== 1 || empty( $_POST['product_id'] ) )
			return;

		foreach ( (array) $_POST['product_id'] as $product_id ) {
			$quantity = isset( $_POST['quantity_' . $product_id] ) ? intval( $_POST['quantity_' . $product_id] ) : 0;

			if ( $quantity > 0 )
				$woocommerce->cart->add_to_cart( $product_id, $quantity );

		}

	}

	/**
	 * Gets an individual ticket
	 *
	 * @param $event_id
	 * @param $ticket_id
	 *
	 * @return null|TribeEventsTicketObject
	 */
	public function get_ticket( $event_id, $ticket_id ) {

		if ( class_exists( 'WC_Product_Simple' ) ) {
			$product = new WC_Product_Simple( $ticket_id );
		} else {
			$product = new WC_Product( $ticket_id );
		}

		if ( ! $product )
			return null;

		$return       = new TribeEventsTicketObject();
		$product_data = $product->get_post_data();

		$return->description    = $product_data->post_excerpt;
		$return->frontend_link  = get_permalink( $ticket_id );
		$return->ID             = $ticket_id;
		$return->name           = $product->get_title();
		$return->price          = $product->get_price();
		$return->provider_class = get_class( $this );
		$return->admin_link     = admin_url( sprintf( get_post_type_object( $product_data->post_type )->_edit_link . '&action=edit', $ticket_id ) );
		$return->stock          = $product->get_stock_quantity();
		$return->start_date     = get_post_meta( $ticket_id, '_ticket_start_date', true );
		$return->end_date       = get_post_meta( $ticket_id, '_ticket_end_date', true );

		$qty              = get_post_meta( $ticket_id, 'total_sales', true );
		$return->qty_sold = $qty ? $qty : 0;

		return $return;

	}

	/**
	 * Get all the attendees for an event. It returns an array with the
	 * following fields:
	 *  'order_id'
	 *  'order_status'
	 *  'purchaser_name'
	 *  'purchaser_email'
	 *  'ticket'
	 *  'attendee_id'
	 *  'security'
	 *  'product_id'
	 *  'check_in'
	 *  'provider'
	 *
	 * @param $event_id
	 *
	 * @return array
	 */

	public function get_att($event_id)
	{
		$attendees = $this->get_attendees( $event_id );
		return $attendees;

	}
	protected function get_attendees( $event_id ) {

		$args = array( 'posts_per_page' => - 1,
		               'post_type'      => $this->attendee_object,
		               'meta_key'       => $this->atendee_event_key,
		               'meta_value'     => $event_id,
		               'orderby'        => 'ID',
		               'order'          => 'DESC' );

		$attendees_query = new WP_Query( $args );


		if ( ! $attendees_query->have_posts() )
		//	return array();

		$attendees = array();

		foreach ( $attendees_query->posts as $attendee ) {

			$order_id   = get_post_meta( $attendee->ID, $this->atendee_order_key, true );
			$checkin    = get_post_meta( $attendee->ID, $this->checkin_key, true );
			$security   = get_post_meta( $attendee->ID, $this->security_code, true );
			$product_id = get_post_meta( $attendee->ID, $this->atendee_product_key, true );
			$name       = get_post_meta( $order_id, '_billing_first_name', true ) . ' ' . get_post_meta( $order_id, '_billing_last_name', true );
			$email      = get_post_meta( $order_id, '_billing_email', true );

			$order_status = wp_get_object_terms( $order_id, 'shop_order_status', array( 'fields' => 'slugs' ) );
			$order_status = ( isset( $order_status[0] ) ) ? $order_status[0] : '';

			if ( ! empty( $order_status ) && get_post_status( $order_id ) == 'trash' )
				$order_status = sprintf( __( 'In trash (was %s)', 'tribe-wootickets' ), $order_status );

			if ( empty( $order_status ) && ! get_post( $order_id ) )
				$order_status = __( 'Deleted', 'tribe-wootickets' );

			if ( empty( $product_id ) )
				continue;

			$product = get_post( $product_id );

			$product_title = ( ! empty( $product ) ) ? $product->post_title : get_post_meta( $attendee->ID, $this->deleted_product, true ) . ' ' . __( '(deleted)', 'wootickets' );

			$attendees[] = array( 'order_id'        => $order_id,
			                      'order_status'    => $order_status,
			                      'purchaser_name'  => $name,
			                      'purchaser_email' => $email,
			                      'ticket'          => $product_title,
			                      'attendee_id'     => $attendee->ID,
			                      'security'        => $security,
			                      'product_id'      => $product_id,
			                      'check_in'        => $checkin,
			                      'provider'        => __CLASS__ );
		}

		$event_time = get_post_meta( $event_id, '_EventStartDate', true );		
		$current_event_datetime = new DateTime($event_time);
		$limit_datetime = new DateTime('2014-00-00 00:00:00');		
		if($current_event_datetime < $limit_datetime)
		{
			global $wpdb;
			$event = get_post($event_id);
			$object = $wpdb->get_results( "SELECT `Workshops`.* FROM `wp_posts` 
inner join `Workshops` 
on `wp_posts`.post_title = `Workshops`.title 
where post_title = '{$event->post_title}' and `Workshops`.start_of_workshop = '{$current_event_datetime->format('Y-m-d')}' limit 1" );	
				
		
			$atendee_object = $wpdb->get_results( "SELECT concat(first_name,' ',last_name) as name, email FROM `Workshop_Attendees` where workshop_id = {$object[0]->id}" );	
		}
		$count = 0;		
		foreach($atendee_object as $atendee)
		{
		$sub_array['order_id'] = 4499;
		$sub_array['order_status'] = 'completed';
		$sub_array['purchaser_name'] = $atendee->name;
		$sub_array['purchaser_email'] = $atendee->email;
		$sub_array['ticket'] = 'test';
		$sub_array['attendee_id'] = 4500;
		$sub_array['security'] = '8c4ea6995f';
		$sub_array['product_id'] = 4496;
		$sub_array['check_in']	= '';
		$sub_array['provider'] = 'TribeWooTickets';
		$attendees[$count] = $sub_array;
		$count++;  	
		}
		
		return $attendees;

	}

	/**
	 * Marks an attendee as checked in for an event
	 *
	 * @param $attendee_id
	 *
	 * @return bool
	 */
	public function checkin( $attendee_id ) {
		update_post_meta( $attendee_id, $this->checkin_key, 1 );
		do_action( 'wootickets_checkin', $attendee_id );

		return true;
	}

	/**
	 * Marks an attendee as not checked in for an event
	 *
	 * @param $attendee_id
	 *
	 * @return bool
	 */
	public function uncheckin( $attendee_id ) {
		delete_post_meta( $attendee_id, $this->checkin_key );
		do_action( 'wootickets_uncheckin', $attendee_id );

		return true;
	}

	/**
	 * Add the extra options in the admin's new/edit ticket metabox
	 *
	 * @param $event_id
	 * @param $ticket_id
	 * @return void
	 */
	public function do_metabox_advanced_options( $event_id, $ticket_id ) {

		$url = $stock = $sku = '';

		if ( ! empty( $ticket_id ) ) {
			$ticket = $this->get_ticket( $event_id, $ticket_id );
			if ( ! empty( $ticket ) ) {
				$stock = $ticket->stock;
				$sku   = get_post_meta( $ticket_id, '_sku', true );
			}
		}

		include $this->pluginPath . 'admin-views/metabox-advanced.php';
	}

	/**
	 * Injects a form and sets the WC sales report as action.
	 *
	 * Seems hacky. And it is. But WooCommerce takes the product_ids
	 * parameter using only $_POST, not $_GET and doesn't have any
	 * filter on it.
	 *
	 * @param $event_id
	 *
	 * @return string
	 */
	public function get_event_reports_link( $event_id ) {
		ob_start();
		$ticket_ids = $this->get_tickets_ids( $event_id );
		if ( empty( $ticket_ids ) )
			return '';

		$file = trailingslashit( $GLOBALS['woocommerce']->plugin_path ) . 'admin/woocommerce-admin-reports.php';
		if ( file_exists( $file ) )
			include_once $file;

		if ( ! function_exists( 'woocommerce_get_reports_charts' ) )
			return '';

		$charts = woocommerce_get_reports_charts();

		if ( empty( $charts['sales']['charts']['product_sales'] ) )
			return '';

		?>

		<small><a href="#" id="wootickets_event_reports"><?php esc_html_e( 'Event sales report', 'tribe-wootickets' );?></a>
		</small>

		<script type="text/javascript">
			jQuery( document ).ready( function ( $ ) {
				$( '#wootickets_event_reports' ).on( 'click', function ( e ) {
					var event_report_form = $( '<form>' ).attr( 'method', 'post' ).attr( 'action', '<?php echo admin_url( "admin.php?page=woocommerce_reports&tab=sales&chart=product_sales" );?>' );
					<?php foreach ( $ticket_ids as $id ) { ?>
					event_report_form.append( $( '<input />' ).attr( 'name', 'product_ids[]' ).val( "<?php echo $id;?>" ) );
					<?php } ?>

					// .submit doesn't work on Firefox if the form is not attached to the DOM
					event_report_form.hide().appendTo( 'body' );

					event_report_form.submit();

					e.preventDefault();

				} );
			} );
		</script>
		<?php

		return ob_get_clean();

	}

	/**
	 * Injects a form and sets the WC sales report as action.
	 *
	 * Seems hacky. And it is. But WooCommerce takes the product_ids
	 * parameter using only $_POST, not $_GET and doesn't have any
	 * filter on it.
	 *
	 * @param $event_id
	 * @param $ticket_id
	 *
	 * @return string
	 */
	public function get_ticket_reports_link( $event_id, $ticket_id ) {
		if ( empty( $ticket_id ) )
			return '';

		$file = trailingslashit( $GLOBALS['woocommerce']->plugin_path ) . 'admin/woocommerce-admin-reports.php';
		if ( file_exists( $file ) )
			include_once $file;

		if ( ! function_exists( 'woocommerce_get_reports_charts' ) )
			return '';

		$charts = woocommerce_get_reports_charts();

		if ( empty( $charts['sales']['charts']['product_sales'] ) )
			return '';

		ob_start();

		?>

		<span><a href="#" class="wootickets_ticket_report" data-id="<?php echo $ticket_id; ?>">Report</a></span>

		<script type="text/javascript">
			jQuery( document ).ready( function ( $ ) {
				$( '.wootickets_ticket_report' ).on( 'click', function ( e ) {
					e.preventDefault();

					var ids = $( '<input />' ).attr( 'name', 'product_ids[]' ).val( $( this ).attr( 'data-id' ) );
					$( '<form />' ).attr( 'method', 'post' ).attr( 'action', '<?php echo admin_url( "admin.php?page=woocommerce_reports&tab=sales&chart=product_sales" );?>' ).append( ids ).appendTo( 'body' ).submit();
				} );
			} );

		</script>
		<?php

		return ob_get_clean();

}

	/**
	 * Registers a metabox in the WooCommerce product edit screen
	 * with a link back to the product related Event.
	 *
	 */
	public function woocommerce_meta_box() {
		$event_id = get_post_meta( get_the_ID(), $this->event_key, true );

		if ( ! empty( $event_id ) )
			add_meta_box( 'wootickets-linkback', 'Event', array( $this,
				'woocommerce_meta_box_inside', ), 'product', 'normal', 'high' );

	}

	/**
	 * Contents for the metabox in the WooCommerce product edit screen
	 * with a link back to the product related Event.
	 */
	public function woocommerce_meta_box_inside() {

		$event_id = get_post_meta( get_the_ID(), $this->event_key, true );
		if ( ! empty( $event_id ) )
			echo sprintf( '%s <a href="%s">%s</a>', __( 'This is a ticket for the event:', 'tribe-wootickets' ), esc_url( get_edit_post_link( $event_id ) ), esc_html( get_the_title( $event_id ) ) );

	}

	/**
	 * Get's the WC product price html
	 *
	 * @param int|object $product
	 *
	 * @return string
	 */
	public function get_price_html( $product ) {
		if ( is_numeric( $product ) ) {
			if ( class_exists( 'WC_Product_Simple' ) ) {
				$product = new WC_Product_Simple( $product );
			} else {
				$product = new WC_Product( $product );
			}
		}

		if ( ! method_exists( $product, 'get_price_html' ) )
			return '';

		return $product->get_price_html();

	}

	public function get_tickets_ids( $event_id ) {

		if ( is_object( $event_id ) )
			$event_id = $event_id->ID;

		$query = new WP_Query( array( 'post_type'      => 'product',
		                              'meta_key'       => $this->event_key,
		                              'meta_value'     => $event_id,
		                              'meta_compare'   => '=',
		                              'posts_per_page' => - 1,
		                              'fields'         => 'ids',
		                              'post_status'    => 'publish', ) );

		return $query->posts;
	}


	/**
	 * Adds an action to resend the tickets to the customer
	 * in the WooCommerce actions dropdown, in the order edit screen.
	 *
	 * @param $emails
	 *
	 * @return array
	 */
	public function add_resend_tickets_action( $emails ) {
		$order = get_the_ID();

		if ( empty( $order ) )
			return $emails;

		$has_tickets = get_post_meta( $order, $this->order_has_tickets, true );

		if ( ! $has_tickets )
			return $emails;

		$emails[] = 'wootickets';
		return $emails;
	}

	/********** SINGLETON FUNCTIONS **********/

	/**
	 * Instance of this class for use as singleton
	 */
	private static $instance;

	/**
	 * Creates the instance of the class
	 *
	 * @static
	 * @return void
	 */
	public static function init() {
		self::$instance = self::get_instance();
	}

	/**
	 * Get (and instantiate, if necessary) the instance of the class
	 *
	 * @static
	 * @return TribeWooTickets
	 */
	public static function get_instance() {
		if ( ! is_a( self::$instance, __CLASS__ ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
