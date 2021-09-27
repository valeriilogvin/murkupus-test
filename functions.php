<?php
/**
 * markupus functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package markupus
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function markupus_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'markupus' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'markupus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'markupus_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function markupus_scripts() {
    wp_enqueue_style(
        'markupus-style',
        get_template_directory_uri() . '/dist/css/main.min.css'
    );
    wp_enqueue_style(
        'montserrat-gfonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap'
    );
//    wp_enqueue_script(
//        'sun-slick',
//        get_stylesheet_directory_uri() . '/slick/slick.min.js',
//        array(),
//        '',
//        true
//    );
}
add_action( 'wp_enqueue_scripts', 'markupus_scripts' );


/*
 * custom functions
 * */

add_filter('woocommerce_currency_symbol', 'symbol_to_letter', 9999, 2);

function symbol_to_letter( $valyuta_symbol, $valyuta_code ) {
    if( $valyuta_code === 'UAH' ) {
        return ' грн.';
    }
    return $valyuta_symbol;
}


function woocommerce_get_product_thumbnail() {
    global $product;
    echo '
        <div class="sofas-item-thumbnail">
          <img class="sofas-item-img" src="'. wp_get_attachment_url( $product->get_image_id() ).'" alt="">
        </div>
        ';
}


remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );

add_action('woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10 );

function abChangeProductsTitle() {
    echo '<h2 class="sofas-item-title">' . get_the_title() . '</h2>';
}


add_filter( 'woocommerce_loop_add_to_cart_link', 'custom_product_link' );

function custom_product_link( $link ) {
    global $product;
    echo '
        <div class="sofas-item-modal">
            <a 
                data-quantity="1" 
                data-product_id="'. get_the_ID() .'" 
                href="'. $product->add_to_cart_url()  .'"
                value="'. esc_attr( $product->get_id() ) .'" 
                data-product_sku="'. esc_attr($sku) .'" 
                aria-label="Add “'. the_title_attribute() .'” to your cart"
                class="sofas-item-btn anim-btn ajax_add_to_cart add_to_cart_button"
                data-text="Add to cart"
            >
                <span class="anim-btn__overlay"></span>
                <span class="anim-btn__text">Add to cart</span>
            </a>
        </div>
    ';
}
