<?php
/**
 * Registers and Enqueues the assets
 *
 * @since  TBD
 */
class Tribe__Events__Assets {

	/**
	 * Hooks any required filters and action
	 *
	 * @since  TBD
	 *
	 * @return void
	 */
	public function hook() {
		add_action( 'admin_enqueue_scripts', array( $this, 'dequeue_incompatible' ), 200 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin' ) );
	}

	/**
	 * Registers and Enqueues the assets
	 *
	 * @since  TBD
	 *
	 * @return void
	 */
	public function register() {
		$plugin = Tribe__Events__Main::instance();
		$admin_helpers = Tribe__Admin__Helpers::instance();

		// Vendor
		tribe_assets(
			$plugin,
			array(
				array( 'jquery-placeholder', 'vendor/jquery-placeholder/jquery.placeholder.js', array( 'jquery' ) ),
				array( 'tribe-events-php-date-formatter', 'vendor/php-date-formatter/js/php-date-formatter.js', array() ),
				array( 'tribe-events-custom-jquery-styles', 'vendor/jquery/smoothness/jquery-ui-1.8.23.custom.css', array() ),
				array( 'tribe-events-jquery-resize', 'vendor/jquery-resize/jquery.ba-resize.js', array( 'jquery' ) ),
				array( 'tribe-events-chosen-style', 'vendor/chosen/public/chosen.css', array() ),
				array( 'tribe-events-chosen-jquery', 'vendor/chosen/public/chosen.jquery.js', array( 'jquery' ) ),
				array( 'tribe-events-bootstrap-datepicker-css', 'vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.css', array() ),
				array( 'tribe-events-bootstrap-datepicker', 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js', array( 'jquery' ) ),
			),
			null,
			array(
				'in_footer'    => false,
			)
		);

		// All post Type pages
		tribe_asset(
			$plugin,
			'tribe-events-admin',
			'events-admin.js',
			array(
				'jquery',
				'jquery-ui-dialog',
				'jquery-ui-datepicker',
				'jquery-ui-sortable',
				'tribe-bumpdown',
				'tribe-dropdowns',
				'tribe-attrchange',
				'tribe-events-dynamic',
				'tribe-events-jquery-resize',
				'tribe-jquery-timepicker',
				'tribe-timepicker',
				'underscore',
				'wp-util',
			),
			'admin_enqueue_scripts',
			array(
				'groups'       => array( 'events-admin' ),
				'conditionals' => array( $this, 'should_enqueue_admin' ),
				'localize'     => array(
					(object) array(
						'name' => 'TEC',
						'data' => array( $this, 'get_ajax_url_data' ),
					),
				),
			)
		);

		// All tribe events pages
		tribe_asset(
			$plugin,
			'tribe_events-admin',
			'events-admin.css',
			array(),
			'admin_enqueue_scripts',
			array(
				'groups'       => array( 'events-admin' ),
				'conditionals' => array( $this, 'should_enqueue_admin' ),
			)
		);

		// Post Type admin page
		tribe_assets(
			$plugin,
			array(
				array( 'tribe-events-ecp-plugins', 'jquery-ecp-plugins.js', array( 'jquery' ) ),
				array(
					'tribe-events-editor',
					'event-editor.js',
					array(
						'jquery',
						'jquery-ui-datepicker',
						'jquery-ui-sortable',
						'tribe-bumpdown',
						'tribe-dropdowns',
						'underscore',
						'wp-util',
						'tribe-jquery-timepicker',
						'tribe-timepicker',
						'tribe-attrchange',
						'tribe-select2',
						'ecp-plugins',
					),
				),
				array(
					'tribe-events-admin-ui',
					'events-admin.css',
					array(
						'tribe-jquery-timepicker-css',
						'tribe-select2-css',
						'dashicons',
						'thickbox',
					),
				),
			),
			'admin_enqueue_scripts',
			array(
				'groups'       => array( 'events-admin' ),
				'conditionals' => array( $this, 'should_enqueue_admin' ),
			)
		);

		// Admin Menu Assets
		tribe_asset(
			$plugin,
			'tribe-events-admin-menu',
			'admin-menu.css',
			array( 'dashicons' ),
			array( 'admin_enqueue_scripts', 'wp_enqueue_scripts' ),
			array(
				'conditionals' => 'is_admin_bar_showing',
			)
		);

		// Setting page Assets
		tribe_asset(
			$plugin,
			'tribe-events-settings',
			'tribe-settings.js',
			array( 'dashicons', 'tribe-select2', 'thickbox' ),
			'admin_enqueue_scripts',
			array(
				'conditionals' => array( $admin_helpers, 'is_screen' ),
			)
		);

		// FrontEnd
		tribe_asset(
			$plugin,
			'tribe-events-dynamic',
			'events-dynamic.js',
			array( 'jquery', 'tribe-events-php-date-formatter', 'tribe-moment' ),
			array( 'wp_enqueue_scripts', 'admin_enqueue_scripts' ),
			array(
				'conditionals' => array( $this, 'should_enqueue_on_tribe' ),
				'localize'     => array(
					'name' => 'tribe_dynamic_help_text',
					'data' => array( $this, 'get_js_dynamic_data' ),
				),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-calendar-script',
			'tribe-events.js',
			array( 'jquery', 'tribe-events-bootstrap-datepicker', 'tribe-events-jquery-resize', 'jquery-placeholder' ),
			'wp_enqueue_scripts',
			array(
				'conditionals' => array( $this, 'should_enqueue_frontend' ),
				'in_footer'    => false,
				'localize'     => array(
					'name' => 'tribe_js_config',
					'data' => array( $this, 'get_js_calendar_script_data' ),
				),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-bar',
			'tribe-events-bar.js',
			array( 'jquery', 'tribe-events-dynamic', 'tribe-events-calendar-script', 'tribe-events-bootstrap-datepicker', 'tribe-events-jquery-resize', 'jquery-placeholder' ),
			'wp_enqueue_scripts',
			array(
				'in_footer'    => false,
				'conditionals' => array( $this, 'should_enqueue_frontend' ),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-calendar-mobile-style',
			'tribe-events-theme-mobile.css',
			array( 'tribe-events-calendar-style', 'tribe-accessibility-css' ),
			'wp_enqueue_scripts',
			array(
				'media'        => 'only screen and (max-width: ' . tribe_get_mobile_breakpoint() . 'px)',
				'groups'       => array( 'events-styles' ),
				'conditionals' => array(
					'operator' => 'AND',
					array( $this, 'is_mobile_breakpoint' ),
					array( $this, 'should_enqueue_frontend' ),
				),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-calendar-full-mobile-style',
			'tribe-events-full-mobile.css',
			array( 'tribe-events-calendar-style', 'tribe-accessibility-css' ),
			'wp_enqueue_scripts',
			array(
				'media'        => 'only screen and (max-width: ' . tribe_get_mobile_breakpoint() . 'px)',
				'groups'       => array( 'events-styles' ),
				'conditionals' => array(
					'operator' => 'AND',
					array( $this, 'is_mobile_breakpoint' ),
					array( $this, 'should_enqueue_frontend' ),
					array( $this, 'should_enqueue_full_styles' ),
				),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-full-calendar-style',
			'tribe-events-full.css',
			array(),
			'wp_enqueue_scripts',
			array(
				'groups'       => array( 'events-styles' ),
				'priority'     => 5,
				'conditionals' => array(
					'operator' => 'AND',
					array( $this, 'should_enqueue_frontend' ),
					array( $this, 'should_enqueue_full_styles' ),
				),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-calendar-style',
			$this->get_style_file(),
			array( 'tribe-events-custom-jquery-styles', 'tribe-events-bootstrap-datepicker-css' ),
			'wp_enqueue_scripts',
			array(
				'groups'       => array( 'events-styles' ),
				'conditionals' => array( $this, 'should_enqueue_frontend' ),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-calendar-override-style',
			Tribe__Events__Templates::locate_stylesheet( 'tribe-events/tribe-events.css' ),
			array(),
			'wp_enqueue_scripts',
			array(
				'groups'       => array( 'events-styles' ),
				'conditionals' => array( $this, 'should_enqueue_frontend' ),
			)
		);

		// Register AJAX views assets
		tribe_asset(
			$plugin,
			'the-events-calendar',
			'tribe-events-ajax-calendar.js',
			array( 'jquery', 'tribe-events-calendar-script', 'tribe-events-bootstrap-datepicker', 'tribe-events-jquery-resize', 'jquery-placeholder' ),
			null,
			array(
				'localize'     => array(
					'name' => 'TribeCalendar',
					'data' => array( $this, 'get_ajax_url_data' ),
				),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-ajax-day',
			'tribe-events-ajax-day.js',
			array( 'jquery', 'tribe-events-calendar-script' ),
			null,
			array(
				'localize'     => array(
					'name' => 'TribeCalendar',
					'data' => array( $this, 'get_ajax_url_data' ),
				),
			)
		);

		tribe_asset(
			$plugin,
			'tribe-events-list',
			'tribe-events-ajax-list.js',
			array( 'jquery', 'tribe-events-calendar-script' ),
			null,
			array(
				'localize'     => array(
					'name' => 'TribeList',
					'data' => array(
						'ajaxurl'     => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
						'tribe_paged' => absint( tribe_get_request_var( 'tribe_paged', 0 ) ),
					),
				),
			)
		);
	}

	/**
	 * Add admin scripts and styles
	 *
	 * @since  TBD
	 */
	public function load_admin() {
		$admin_helpers = Tribe__Admin__Helpers::instance();

		// settings screen
		if ( $admin_helpers->is_screen( 'settings_page_tribe-settings' ) ) {
			// hook for other plugins
			do_action( 'tribe_settings_enqueue' );
		}

		if ( $admin_helpers->is_post_type_screen( Tribe__Events__Main::POSTTYPE ) ) {
			// hook for other plugins
			do_action( 'tribe_events_enqueue' );
		} elseif ( $admin_helpers->is_post_type_screen( Tribe__Events__Venue::POSTTYPE ) ) {
			// hook for other plugins
			do_action( 'tribe_venues_enqueue' );
		} elseif ( $admin_helpers->is_post_type_screen( Tribe__Events__Organizer::POSTTYPE ) ) {
			do_action( 'tribe_organizers_enqueue' );
		}
	}

	/**
	 * Compatibility fix: some plugins enqueue jQuery UI/other styles on all post screens,
	 * breaking our own custom styling of event editor components such as the datepicker.
	 *
	 * Needs to execute late enough during admin_enqueue_scripts that the items we are removing
	 * have already been registered and enqueued.
	 *
	 * @since  TBD
	 *
	 * @see https://github.com/easydigitaldownloads/easy-digital-downloads/issues/3033
	 */
	public function dequeue_incompatible() {
		if ( ! Tribe__Admin__Helpers::instance()->is_post_type_screen( Tribe__Events__Main::POSTTYPE ) ) {
			return false;
		}

		wp_dequeue_style( 'jquery-ui-css' );
		wp_dequeue_style( 'edd-admin' );
	}

	/**
	 * Checks if we should enqueue on frontend and backend on our pages
	 *
	 * @since  TBD
	 *
	 * @return bool
	 */
	public function should_enqueue_on_tribe() {
		if ( is_admin() ) {
			return $this->should_enqueue_admin();
		} else {
			return $this->should_enqueue_frontend();
		}
	}

	/**
	 * Checks if we should enqueue frontend assets
	 *
	 * @since  TBD
	 *
	 * @return bool
	 */
	public function should_enqueue_frontend() {
		global $post;

		$should_enqueue = (
			tribe_is_event_query()
			|| tribe_is_event_organizer()
			|| tribe_is_event_venue()
			|| is_active_widget( false, false, 'tribe-events-list-widget' )
			|| ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'tribe_events' ) )
		);

		/**
		 * Allow filtering of where the base Frontend Assets will be loaded
		 *
		 * @since  TBD
		 *
		 * @param bool $should_enqueue
		 */
		return apply_filters( 'tribe_events_assets_should_enqueue_frontend', $should_enqueue );
	}

	/**
	 * Checks if we should enqueue full styles assets
	 *
	 * @since  TBD
	 *
	 * @return bool
	 */
	public function should_enqueue_full_styles() {
		$should_enqueue = $this->is_style_option_tribe();

		/**
		 * Allow filtering of where the base Full Style Assets will be loaded
		 *
		 * @since  TBD
		 *
		 * @param bool $should_enqueue
		 */
		return apply_filters( 'tribe_events_assets_should_enqueue_full_styles', $should_enqueue );
	}

	/**
	 * Checks if we are on the correct admin pages to enqueue admin
	 *
	 * @since  TBD
	 *
	 * @return bool
	 */
	public function should_enqueue_admin() {
		$admin_helpers = Tribe__Admin__Helpers::instance();
		$should_enqueue = (
			$admin_helpers->is_screen( array( 'widgets', 'customize' ) )
			|| $admin_helpers->is_screen()
			|| $admin_helpers->is_post_type_screen()
		);

		/**
		 * Allow filtering of where the base Admin Assets will be loaded
		 *
		 * @since  TBD
		 *
		 * @param bool $should_enqueue
		 */
		return apply_filters( 'tribe_events_assets_should_enqueue_admin', $should_enqueue );
	}

	/**
	 * Checks if we have a mobile Breakpoint
	 *
	 * @since  TBD
	 *
	 * @return bool
	 */
	public function is_mobile_breakpoint() {
		// check if responsive should be killed
		if ( apply_filters( 'tribe_events_kill_responsive', false ) ) {
			add_filter( 'tribe_events_mobile_breakpoint', '__return_zero' );
		}

		$mobile_break = tribe_get_mobile_breakpoint();
		return $mobile_break > 0;
	}

	/**
	 * Checks if we are using Tribe setting for Style
	 *
	 * @since  TBD
	 *
	 * @return bool
	 */
	public function is_style_option_tribe() {
		$style_option = tribe_get_option( 'stylesheetOption', 'tribe' );
		return 'tribe' === $style_option;
	}

	/**
	 * Checks if we are on the correct admin settings page
	 *
	 * @since  TBD
	 *
	 * @return bool
	 */
	public function is_settings_page() {
		return $admin_helpers->is_screen( 'settings_page_tribe-settings' );
	}

	/**
	 * Playing ping-pong with WooCommerce. They keep changing their script.
	 *
	 * @since TBD
	 *
	 * @see https://github.com/woothemes/woocommerce/issues/3623
	 *
	 * @return string
	 */
	public function get_placeholder_handle() {
		$placeholder_handle = 'jquery-placeholder';

		global $woocommerce;
		if (
			class_exists( 'Woocommerce' ) &&
			version_compare( $woocommerce->version, '2.0.11', '>=' ) &&
			version_compare( $woocommerce->version, '2.0.13', '<=' )
		) {
			$placeholder_handle = 'tribe-placeholder';
		}

		return $placeholder_handle;
	}


	/**
	 * Due to how we define which style we use based on an Option on the Administration
	 * we need to determine this file.
	 *
	 * @since  TBD
	 *
	 * @return string
	 */
	public function get_style_file() {
		$name = tribe_get_option( 'stylesheetOption', 'tribe' );

		$stylesheets = array(
			'tribe'    => 'tribe-events-theme.css',
			'full'     => 'tribe-events-full.css',
			'skeleton' => 'tribe-events-skeleton.css',
		) ;

		// By default we go with `tribe`
		$file = $stylesheets['tribe'];

		// if we have one we use it
		if ( isset( $stylesheets[ $name ] ) ) {
			$file = $stylesheets[ $name ];
		}

		/**
		 * Allows filtering of the Stylesheet file for Events Calendar Pro
		 *
		 * @deprecated  TBD
		 *
		 * @param string $file Which file we are loading
		 * @param string $name Option from the DB of style we are using
		 */
		return apply_filters( 'tribe_events_stylesheet_url', $file, $name );
	}


	/**
	 * Gets the Localize variable for TEC admin JS
	 *
	 * @since  TBD
	 *
	 * @return array
	 */
	public function get_ajax_url_data() {
		$bits = array(
			'ajaxurl' => esc_url_raw( admin_url( 'admin-ajax.php', ( is_ssl() || FORCE_SSL_ADMIN ? 'https' : 'http' ) ) ),
			'post_type' => Tribe__Events__Main::POSTTYPE,
		);

		return $bits;
	}


	/**
	 * Gets the Localize variable for Calendar Script JS
	 *
	 * @since  TBD
	 *
	 * @return array
	 */
	public function get_js_calendar_script_data() {
		$js_config_array = array(
			'permalink_settings' => get_option( 'permalink_structure' ),
			'events_post_type'   => Tribe__Events__Main::POSTTYPE,
			'events_base'        => tribe_get_events_link(),
		);

		/**
		 * Allows for easier filtering of the "Export Events" iCal link URL.
		 *
		 * @since 4.6.5
		 *
		 * @see tribe_get_ical_link
		 * @param boolean $force Defaults to false; when true, the dynamic JS generation of the "Export Events" URL is disabled.
		 */
		if ( apply_filters( 'tribe_events_force_filtered_ical_link', false ) ) {
			$js_config_array['force_filtered_ical_link'] = true;
		}

		return $js_config_array;
	}

	/**
	 * Gets the Localize variable for Dynamic JS
	 *
	 * @since  TBD
	 *
	 * @return array
	 */
	public function get_js_dynamic_data() {
		$data = array(
			'date_with_year'          => tribe_get_date_option( 'dateWithYearFormat', Tribe__Date_Utils::DBDATEFORMAT ),
			'date_no_year'            => tribe_get_date_option( 'dateWithoutYearFormat', Tribe__Date_Utils::DBDATEFORMAT ),
			'datepicker_format'       => Tribe__Date_Utils::datepicker_formats( tribe_get_option( 'datepickerFormat' ) ),
			'datepicker_format_index' => tribe_get_option( 'datepickerFormat' ),
			'days'              => array(
				__( 'Sunday' ),
				__( 'Monday' ),
				__( 'Tuesday' ),
				__( 'Wednesday' ),
				__( 'Thursday' ),
				__( 'Friday' ),
				__( 'Saturday' ),
			),
			'daysShort'         => array(
				__( 'Sun' ),
				__( 'Mon' ),
				__( 'Tue' ),
				__( 'Wed' ),
				__( 'Thu' ),
				__( 'Fri' ),
				__( 'Sat' ),
			),
			'months'            => array(
				__( 'January' ),
				__( 'February' ),
				__( 'March' ),
				__( 'April' ),
				__( 'May' ),
				__( 'June' ),
				__( 'July' ),
				__( 'August' ),
				__( 'September' ),
				__( 'October' ),
				__( 'November' ),
				__( 'December' ),
			),
			'monthsShort'       => array(
				__( 'Jan' ),
				__( 'Feb' ),
				__( 'Mar' ),
				__( 'Apr' ),
				__( 'May' ),
				__( 'Jun' ),
				__( 'Jul' ),
				__( 'Aug' ),
				__( 'Sep' ),
				__( 'Oct' ),
				__( 'Nov' ),
				__( 'Dec' ),
			),
			'msgs'              => json_encode( array(
				__( 'This event is from %%starttime%% to %%endtime%% on %%startdatewithyear%%.', 'the-events-calendar' ),
				__( 'This event is at %%starttime%% on %%startdatewithyear%%.', 'the-events-calendar' ),
				__( 'This event is all day on %%startdatewithyear%%.', 'the-events-calendar' ),
				__( 'This event starts at %%starttime%% on %%startdatenoyear%% and ends at %%endtime%% on %%enddatewithyear%%', 'the-events-calendar' ),
				__( 'This event starts at %%starttime%% on %%startdatenoyear%% and ends on %%enddatewithyear%%', 'the-events-calendar' ),
				__( 'This event is all day starting on %%startdatenoyear%% and ending on %%enddatewithyear%%.', 'the-events-calendar' ),
			) ),
		);

		return $data;
	}

}