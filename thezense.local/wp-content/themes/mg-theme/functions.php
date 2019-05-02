<?php

if ( ! function_exists( 'onyx_setup' ) ) :
	function onyx_setup() {

		load_theme_textdomain( 'onyx', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );

		add_theme_support( 'custom-logo', array(
			'height'      => 240,
			'width'       => 240,
			'flex-height' => true,
		) );

		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'onyx' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		) );


		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif; // onyx_setup
add_action( 'after_setup_theme', 'onyx_setup' );


/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'Home right sidebar',
		'id'            => 'home_right_1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );

// function onyx_content_width() {
// 	$GLOBALS['content_width'] = apply_filters( 'onyx_content_width', 840 );
// }
// add_action( 'after_setup_theme', 'onyx_content_width', 0 );


function onyx_body_classes( $classes ) {
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	return $classes;
}
add_filter( 'body_class', 'onyx_body_classes' );


function onyx_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

function onyx_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'onyx_content_image_sizes_attr', 10 , 2 );

function onyx_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'onyx_post_thumbnail_sizes_attr', 10 , 3 );

function onyx_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'onyx_widget_tag_cloud_args' );





// function onyx_scripts() {
//   wp_enqueue_script( 'scripts', get_template_directory_uri() . '/scripts.js', array( 'jquery'));
// }
// add_action( 'wp_enqueue_scripts', 'onyx_scripts' );

add_filter('show_admin_bar', '__return_false');

if(!is_admin()){

  add_action('wp_head', 'wp_print_scripts', 5);
  add_action('wp_head', 'wp_enqueue_scripts', 5);
  add_action('wp_head', 'wp_print_head_scripts', 5);
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'http://code.jquery.com/jquery-2.2.4.min.js', false, 'all', true);
  wp_enqueue_script('jquery');
}



add_action('admin_enqueue_scripts', 'admin_custom_styles');
function admin_custom_styles() {
	wp_enqueue_style( 'admin_style', get_template_directory_uri() . '/admin-style.css', false, '1.0.0' );
}