<?php
/**
 * Sakher leads — Custom Post Type + public REST endpoint + admin UI.
 *
 * - CPT slug: sakher_lead
 * - REST:    POST /wp-json/sakher/v1/leads  (public, rate-limited per IP)
 * - Admin:   "Leads" menu in WP admin with sortable list + status updates
 */
defined( 'ABSPATH' ) || exit;

/* ─── Register the Custom Post Type ─────────────────────── */
add_action( 'init', function () {
	register_post_type( 'sakher_lead', [
		'labels'              => [
			'name'               => __( 'Leads', 'sakher' ),
			'singular_name'      => __( 'Lead', 'sakher' ),
			'menu_name'          => __( 'Leads', 'sakher' ),
			'all_items'          => __( 'All Leads', 'sakher' ),
			'add_new'            => __( 'Add New', 'sakher' ),
			'add_new_item'       => __( 'Add New Lead', 'sakher' ),
			'edit_item'          => __( 'Edit Lead', 'sakher' ),
			'view_item'          => __( 'View Lead', 'sakher' ),
			'search_items'       => __( 'Search Leads', 'sakher' ),
			'not_found'          => __( 'No leads yet', 'sakher' ),
		],
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-businessperson',
		'supports'            => [ 'title' ],
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'show_in_rest'        => false, // we expose our own POST endpoint
		'has_archive'         => false,
		'rewrite'             => false,
	] );
} );

/* ─── REST endpoint: POST /wp-json/sakher/v1/leads ──────── */
add_action( 'rest_api_init', function () {
	register_rest_route( 'sakher/v1', '/leads', [
		'methods'             => WP_REST_Server::CREATABLE, // POST
		'callback'            => 'sakher_rest_create_lead',
		'permission_callback' => '__return_true', // public — validation + rate limit below
		'args'                => [
			'name'    => [ 'required' => true,  'type' => 'string' ],
			'phone'   => [ 'required' => true,  'type' => 'string' ],
			'service' => [ 'required' => true,  'type' => 'string' ],
			'email'   => [ 'required' => false, 'type' => 'string' ],
			'company' => [ 'required' => false, 'type' => 'string' ],
			'tier'    => [ 'required' => false, 'type' => 'string' ],
			'people'  => [ 'required' => false, 'type' => 'integer' ],
			'notes'   => [ 'required' => false, 'type' => 'string' ],
		],
	] );
} );

function sakher_rest_create_lead( WP_REST_Request $request ) {
	// ── Rate limit: 5 submissions / 15 min per IP ──
	$ip       = sakher_get_client_ip();
	$rl_key   = 'sakher_rl_' . md5( $ip );
	$attempts = (int) get_transient( $rl_key );
	if ( $attempts >= 5 ) {
		return new WP_Error( 'rate_limited', __( 'Too many requests. Please try again later.', 'sakher' ), [ 'status' => 429 ] );
	}
	set_transient( $rl_key, $attempts + 1, 15 * MINUTE_IN_SECONDS );

	// ── Validate ──
	$name    = sanitize_text_field( $request['name'] ?? '' );
	$phone   = sanitize_text_field( $request['phone'] ?? '' );
	$email   = sanitize_email( strtolower( $request['email'] ?? '' ) );
	$company = sanitize_text_field( $request['company'] ?? '' );
	$service = sanitize_key( $request['service'] ?? '' );
	$tier    = sanitize_key( $request['tier'] ?? '' );
	$people  = (int) ( $request['people'] ?? 0 );
	$notes   = sanitize_textarea_field( $request['notes'] ?? '' );

	if ( strlen( $name ) < 2 ) {
		return new WP_Error( 'invalid_name', 'الاسم مطلوب', [ 'status' => 400 ] );
	}
	if ( ! preg_match( '/^[0-9+\s]{8,15}$/', $phone ) ) {
		return new WP_Error( 'invalid_phone', 'رقم الجوال غير صحيح', [ 'status' => 400 ] );
	}
	if ( $email && ! is_email( $email ) ) {
		return new WP_Error( 'invalid_email', 'البريد الإلكتروني غير صحيح', [ 'status' => 400 ] );
	}
	if ( ! in_array( $service, [ 'catering', 'coffee_break', 'both' ], true ) ) {
		return new WP_Error( 'invalid_service', 'نوع الخدمة غير صحيح', [ 'status' => 400 ] );
	}
	if ( $tier && ! in_array( $tier, [ 'bronze', 'silver', 'gold' ], true ) ) {
		return new WP_Error( 'invalid_tier', 'الباقة غير صحيحة', [ 'status' => 400 ] );
	}

	// ── Create lead post ──
	$post_id = wp_insert_post( [
		'post_type'   => 'sakher_lead',
		'post_status' => 'publish',
		'post_title'  => sprintf( '%s — %s', $name, $phone ),
	], true );

	if ( is_wp_error( $post_id ) ) {
		return new WP_Error( 'db_error', 'Server error', [ 'status' => 500 ] );
	}

	// ── Meta ──
	update_post_meta( $post_id, '_sakher_name',       $name );
	update_post_meta( $post_id, '_sakher_phone',      $phone );
	update_post_meta( $post_id, '_sakher_email',      $email );
	update_post_meta( $post_id, '_sakher_company',    $company );
	update_post_meta( $post_id, '_sakher_service',    $service );
	update_post_meta( $post_id, '_sakher_tier',       $tier );
	update_post_meta( $post_id, '_sakher_people',     $people );
	update_post_meta( $post_id, '_sakher_notes',      $notes );
	update_post_meta( $post_id, '_sakher_status',     'new' );
	update_post_meta( $post_id, '_sakher_ip',         $ip );
	update_post_meta( $post_id, '_sakher_user_agent', sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ?? '' ) );

	// ── Notify admin (optional; configure via filter) ──
	do_action( 'sakher_lead_created', $post_id, [
		'name' => $name, 'phone' => $phone, 'email' => $email,
		'service' => $service, 'tier' => $tier, 'company' => $company,
	] );

	return rest_ensure_response( [ 'ok' => true, 'id' => $post_id ] );
}

function sakher_get_client_ip() {
	foreach ( [ 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ] as $h ) {
		if ( ! empty( $_SERVER[ $h ] ) ) {
			$ip = explode( ',', $_SERVER[ $h ] )[0];
			return sanitize_text_field( trim( $ip ) );
		}
	}
	return '0.0.0.0';
}

/* ─── Default email notification (admin can disable via filter) ── */
add_action( 'sakher_lead_created', function ( $post_id, $data ) {
	if ( ! apply_filters( 'sakher_send_lead_email', true ) ) return;
	$to      = get_option( 'admin_email' );
	$subject = sprintf( '[Sakher] New lead — %s', $data['name'] );
	$body    = "طلب جديد من موقع صخر:\n\n"
	         . "الاسم: {$data['name']}\n"
	         . "الجوال: {$data['phone']}\n"
	         . "البريد: {$data['email']}\n"
	         . "الشركة: {$data['company']}\n"
	         . "الخدمة: {$data['service']}\n"
	         . "الباقة: {$data['tier']}\n\n"
	         . admin_url( "post.php?post=$post_id&action=edit" );
	wp_mail( $to, $subject, $body );
}, 10, 2 );

/* ─── Admin UI: custom columns ───────────────────────────── */
add_filter( 'manage_sakher_lead_posts_columns', function ( $cols ) {
	return [
		'cb'        => $cols['cb'] ?? '',
		'title'     => __( 'Lead', 'sakher' ),
		'phone'     => __( 'Phone', 'sakher' ),
		'service'   => __( 'Service', 'sakher' ),
		'tier'      => __( 'Tier', 'sakher' ),
		'status'    => __( 'Status', 'sakher' ),
		'date'      => __( 'Received', 'sakher' ),
	];
} );

add_action( 'manage_sakher_lead_posts_custom_column', function ( $column, $post_id ) {
	switch ( $column ) {
		case 'phone':
			$phone = get_post_meta( $post_id, '_sakher_phone', true );
			if ( $phone ) {
				printf( '<a href="tel:%1$s">%1$s</a> · <a href="https://wa.me/%2$s" target="_blank">WA</a>',
					esc_html( $phone ),
					esc_attr( preg_replace( '/\D/', '', $phone ) )
				);
			}
			break;
		case 'service':
			$map = [ 'catering' => 'تموين', 'coffee_break' => 'قهوة استراحة', 'both' => 'الاثنان' ];
			echo esc_html( $map[ get_post_meta( $post_id, '_sakher_service', true ) ] ?? '—' );
			break;
		case 'tier':
			$map = [ 'bronze' => 'برونزية', 'silver' => 'فضية', 'gold' => 'ذهبية' ];
			echo esc_html( $map[ get_post_meta( $post_id, '_sakher_tier', true ) ] ?? '—' );
			break;
		case 'status':
			$status = get_post_meta( $post_id, '_sakher_status', true ) ?: 'new';
			$colors = [ 'new' => '#7B9396', 'contacted' => '#B8924A', 'closed' => '#2e7d32', 'lost' => '#c0392b' ];
			$labels = [ 'new' => 'جديد', 'contacted' => 'تم التواصل', 'closed' => 'مغلق', 'lost' => 'مفقود' ];
			printf(
				'<span style="display:inline-block;padding:3px 10px;border-radius:6px;font-size:11px;font-weight:600;background:%s;color:#fff">%s</span>',
				esc_attr( $colors[ $status ] ?? '#888' ),
				esc_html( $labels[ $status ] ?? $status )
			);
			break;
	}
}, 10, 2 );

/* ─── Lead detail meta box ───────────────────────────────── */
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'sakher_lead_details', 'Lead Details', 'sakher_render_lead_meta_box', 'sakher_lead', 'normal', 'high' );
	add_meta_box( 'sakher_lead_status',  'Status',       'sakher_render_status_meta_box', 'sakher_lead', 'side',   'high' );
} );

function sakher_render_lead_meta_box( $post ) {
	$fields = [
		'_sakher_name'       => 'Name',
		'_sakher_phone'      => 'Phone',
		'_sakher_email'      => 'Email',
		'_sakher_company'    => 'Company',
		'_sakher_service'    => 'Service',
		'_sakher_tier'       => 'Tier',
		'_sakher_people'     => 'People',
		'_sakher_notes'      => 'Notes',
		'_sakher_ip'         => 'IP',
		'_sakher_user_agent' => 'User Agent',
	];
	echo '<table class="form-table"><tbody>';
	foreach ( $fields as $key => $label ) {
		$val = get_post_meta( $post->ID, $key, true );
		printf( '<tr><th style="width:140px">%s</th><td>%s</td></tr>', esc_html( $label ), nl2br( esc_html( $val ?: '—' ) ) );
	}
	echo '</tbody></table>';
}

function sakher_render_status_meta_box( $post ) {
	$current = get_post_meta( $post->ID, '_sakher_status', true ) ?: 'new';
	wp_nonce_field( 'sakher_status', 'sakher_status_nonce' );
	echo '<select name="sakher_status" style="width:100%">';
	foreach ( [
		'new'       => 'New (جديد)',
		'contacted' => 'Contacted (تم التواصل)',
		'closed'    => 'Closed (مغلق)',
		'lost'      => 'Lost (مفقود)',
	] as $val => $label ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $val ), selected( $current, $val, false ), esc_html( $label ) );
	}
	echo '</select>';
}

add_action( 'save_post_sakher_lead', function ( $post_id ) {
	if ( ! isset( $_POST['sakher_status_nonce'] ) || ! wp_verify_nonce( $_POST['sakher_status_nonce'], 'sakher_status' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	if ( isset( $_POST['sakher_status'] ) ) {
		update_post_meta( $post_id, '_sakher_status', sanitize_key( $_POST['sakher_status'] ) );
	}
} );
