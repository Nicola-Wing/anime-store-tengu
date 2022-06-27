<?php

include_once( 'custom-shortcodes.php' );

function theme_enqueue_styles() {
	$parent_style = 'parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
 * Custom menu locations
 */
function ast_register_new_menus() {
	register_nav_menus(
		array(
			'ast-under-header-menu' => __( 'Under Header Menu' ),
			'extra-menu'            => __( 'Extra Menu' )
		)
	);
}

add_action( 'init', 'ast_register_new_menus' );

/**
 * Create Custom Post Type for Sliders
 */

function create_slider_post_type() {

	$labels = array(
		'name'          => __( 'Sliders' ),
		'singular_name' => __( 'Sliders' ),
		'all_items'     => __( 'All Sliders' ),
		'view_item'     => __( 'View Slider' ),
		'add_new_item'  => __( 'Add New Slider' ),
		'add_new'       => __( 'Add New Slider' ),
		'edit_item'     => __( 'Edit Slider' ),
		'update_item'   => __( 'Update Slider' ),
		'search_items'  => __( 'Search Slider' ),
		'search_items'  => __( 'Sliders' )
	);

	$args = array(
		'labels'          => $labels,
		'description'     => 'Add New Slider contents',
		'menu_position'   => 27,
		'public'          => true,
		'has_archive'     => true,
		'map_meta_cap'    => true,
		'capability_type' => 'post',
		'hierarchical'    => true,
		'rewrite'         => array( 'slug' => false ),
		'menu_icon'       => 'dashicons-format-image',
		'supports'        => array(
			'title',
			'thumbnail',
			'excerpt'
		),
	);
	register_post_type( 'slider', $args );

}

add_action( 'init', 'create_slider_post_type' );

add_action( 'init', function () {
	remove_post_type_support( 'slider', 'slug' );
} );


// Default thumbnails - def size for slider image.
function cih_theme_support() {

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'slider_image', '1024', '720', true );

}

add_action( 'after_setup_theme', 'cih_theme_support' );

// Create new custom field for link field inside a slider post type.
function sliderLink_add_meta_box() {
	add_meta_box( 'slider_link', 'Slider Link', 'slider_link_callback', 'slider' );
}

function slider_link_callback( $post ) {
	wp_nonce_field( 'slider_link_save', 'slider_link_meta_box_nonce' );
	$value = get_post_meta( $post->ID, '_slider_link_value_key', true );
	?>
    <input type="text" name="slider_link_field" id="slider_link_field"
           value="<?php echo esc_attr( $value ); ?>" required="required" size="100"/>
	<?php
}

add_action( 'add_meta_boxes', 'sliderLink_add_meta_box' );
function slider_link_save( $post_id ) {
	if ( ! isset( $_POST['slider_link_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['slider_link_meta_box_nonce'], 'slider_link_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['slider_link_field'] ) ) {
		return;
	}
	$slider_link = sanitize_text_field( $_POST['slider_link_field'] );
	update_post_meta( $post_id, '_slider_link_value_key', $slider_link );
}

add_action( 'save_post', 'slider_link_save' );

/**
 * Change the output of posts on blog page. Show excerpt.
 */

add_action( 'init', function () {

	remove_action( 'storefront_loop_post', 'storefront_post_content', 30 );

	add_action( 'storefront_loop_post', function () {
		echo '<div class="entry-content" itemprop="articleBody">';
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'large', [ 'itemprop' => 'image' ] );
		}
		the_excerpt();
		echo '</div>';
	}, 30 );

} );

/**
 * Login to purchase message in the top of product.
 */

add_action( 'woocommerce_before_single_product', 'add_layers_add_message');
add_filter( 'woocommerce_is_purchasable', 'add_layers_block_admin_purchase' );
function add_layers_block_admin_purchase($block) {
	if ( is_user_logged_in() ):return true;
	else:return false;
	endif;
}

function add_layers_add_message( ){
	if ( !is_user_logged_in() ):
        echo '<h2 style="margin-bottom:5%; font-size: 1em; text-align:center; background-color:red; font-weight:bold; color:wheat;">
                PLEASE LOGIN TO PURCHASE THIS PRODUCT</h2>';
	endif;
}

/**
 * Display payment methods on shopping cart page.
 */

add_action( 'woocommerce_after_cart_totals', 'available_payment_methods' );
function available_payment_methods() {
	echo '<div class="payment-methods-cart-page">
<img src="'. wp_upload_dir()['baseurl'] .'/2022/06/Stripe-Payment.webp">
</div>
<div class="payment-methods-message">We accept the following payment methods</div>';
}

/**
 * Display trust badges on checkout page.
 */

add_action( 'woocommerce_review_order_after_submit', 'approved_trust_badges' );
function approved_trust_badges() {
	echo '<div class="trust-badges">
<img src="'. wp_upload_dir()['baseurl'] .'/2022/06/Stripe-Payment.webp">
</div>
<div class="trust-badge-message">Press "Place order"</div>';
}

/**
 * WooCommerce Sales Sorting Filter
 * Add custom sorting by sales, by name (desc), (asc).
 */

add_filter( 'woocommerce_get_catalog_ordering_args', 'wcs_get_catalog_ordering_args' );
function wcs_get_catalog_ordering_args( $args ) {
	$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

	if ( 'on_sale' == $orderby_value ) {
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'DESC';
		$args['meta_key'] = '_sale_price';
	}
	if ( 'name-desc' == $orderby_value ) {
		$args['orderby'] = 'title';
		$args['order'] = 'DESC';
	}
	if ( 'name-asc' == $orderby_value ) {
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
	}
	return $args;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'wcs_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'wcs_catalog_orderby' );
function wcs_catalog_orderby( $sort_by ) {
	$sort_by['on_sale'] = 'Sort by on sale';
	$sort_by['name-desc'] = 'Sort by name (desc)';
	$sort_by['name-asc'] = 'Sort by name (asc)';
	return $sort_by;
}

/**
 * Change "Sale!" on percentage.
 */

add_filter( 'woocommerce_sale_flash', 'change_on_sale_badge', 99, 3 );

function change_on_sale_badge( $badge_html, $post, $product ) {

	if( $product->is_type( 'variable' ) ){ // variable products

		$percentages = array();

		$prices = $product->get_variation_prices();

		foreach( $prices[ 'price' ] as $id => $price ){
			// if sale price == regular price, it means no sale right now, skip the loop iteration
			if( $prices[ 'regular_price' ][ $id ] === $prices[ 'sale_price' ][ $id ] ) {
				continue;
			}
			// array of all variations percentages
			$percentages[] = ( $prices[ 'regular_price' ][ $id ] - $prices[ 'sale_price' ][ $id ] ) / $prices[ 'regular_price' ][ $id ] * 100;
		}

		$percentage = "UP TO " . round( max( $percentages ) ) . '%';

	} else { // simple products

		$percentage = round( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() * 100 ) . '%';

	}

	return '<span class="onsale">' . $percentage . ' OFF</span>';

}

/**
 * Set label "New!" for products added less than 1 month ago.
 */

add_action( 'woocommerce_after_shop_loop_item_title', 'create_new_badge_shop_page', 3 );

function create_new_badge_shop_page() {
	global $product;
	$newness_days = 30;
	$created = strtotime( $product->get_date_created() );
	if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
		echo '<span class="itsnew onsale">' . esc_html__( 'New!', 'woocommerce' ) . '</span>';
	}
}
