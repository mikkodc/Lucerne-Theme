<?php
/**
 * lucerne functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lucerne
 */

if ( ! function_exists( 'lucerne_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lucerne_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on lucerne, use a find and replace
	 * to change 'lucerne' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'lucerne', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'lucerne' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'lucerne_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'lucerne_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lucerne_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lucerne_content_width', 640 );
}
add_action( 'after_setup_theme', 'lucerne_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lucerne_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'lucerne' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'lucerne' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'lucerne_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lucerne_scripts() {

	//Enqueue Theme CSS
	wp_enqueue_style( 'lucerne-style', get_stylesheet_uri() );

	//Enqueue Bootstrap
	wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() .'/library/src/bootstrap-css/css/bootstrap.min.css' );

	//Enqueue Sass
	wp_enqueue_style( 'sass-style', get_stylesheet_directory_uri() .'/library/dist/styles/style.min.css' );

	//Enqueue jQuery
	wp_enqueue_script( 'jquery-script', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), '1', true );
	wp_enqueue_script( 'jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array(), '1', true );

	//Enqueue Bootstrap Scripts
	wp_enqueue_script( 'booststap-script', get_template_directory_uri() . '/library/src/bootstrap-css/js/bootstrap.min.js', array(), '1', true );

	//Enqueue Custom Scripts
	wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/library/dist/js/all.min.js', array(), '1', true );
	wp_enqueue_script( 'intro-script', get_template_directory_uri() . '/library/dist/js/introArticle.js', array(), '1', true );
	wp_enqueue_script( 'load-script', get_template_directory_uri() . '/library/dist/js/infiniteLoad.js', array(), '1', true );
	wp_enqueue_script( 'search-script', get_template_directory_uri() . '/library/dist/js/searchFilter.js', array(), '1', true );
	wp_enqueue_script( 'reading-list-script', get_template_directory_uri() . '/library/dist/js/readingList.js', array(), '1', true );

	//Enqueue Ajax
	wp_localize_script( 'custom-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'tempateUrl' => get_stylesheet_directory_uri() ) );

	// wp_enqueue_script( 'lucerne-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	//
	// wp_enqueue_script( 'lucerne-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	//
	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
}
add_action( 'wp_enqueue_scripts', 'lucerne_scripts' );

/**
 * Include Ajax Functionalities
 */

@include('ajax-functions/ajax-object.php');

/**
 * Add new fields into 'Contact Info' section.
 *
 * @param  array $fields Existing fields array.
 * @return array
 */
function additional_contact_methods( $fields ) {

    $fields['phone'] 	= 'Phone Number';

    return $fields;
}

add_filter( 'user_contactmethods', 'additional_contact_methods' );

/**
 * Remove Admin Bar
 */
// add_filter('show_admin_bar', '__return_false');
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}

/**
 * WP_LOGIN Options
 */

add_action( 'login_form_bottom', 'add_lost_password_link' );
function add_lost_password_link() {
	$siteurl = get_bloginfo('url');
	return '<a href="'. $siteurl .'/lostpass">Forgot your Password?</a>';
}

function redirect_login_page() {
  $login_page  = home_url( '/login/' );
  $register_page  = home_url( '/register/' );
  $page_viewed = basename($_SERVER['REQUEST_URI']);

  if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($login_page);
    exit;
  } elseif( $page_viewed == "wp-login.php?action=register" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($register_page);
    exit;
  }
}
add_action('init','redirect_login_page');

// add_filter( 'lostpassword_url', 'my_lost_password_page', 10, 2 );
// function my_lost_password_page( $lostpassword_url, $redirect ) {
//     return home_url( '/login/?redirect_to=' . $redirect );
// }

function login_failed() {
  $login_page  = home_url( '/login/' );
  wp_redirect( $login_page . '?login=failed' );
  exit;
}
add_action( 'wp_login_failed', 'login_failed' );

function verify_username_password( $user, $username, $password ) {
  $login_page  = home_url( '/login/' );
    if( $username == "" || $password == "" ) {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
add_filter( 'authenticate', 'verify_username_password', 1, 3);

function logout_page() {
  $login_page  = home_url( '/login/' );
  wp_redirect( $login_page . "?login=false" );
  exit;
}
add_action('wp_logout','logout_page');

function redirect_non_logged_users_to_specific_page() {

	// if ( !is_user_logged_in() || !is_page('login') || !is_page('register') ) {
	if ( !is_user_logged_in()  && !is_page('login') ) {

		wp_redirect( 'http://www.lucernepartners.com');
    exit;
	}
}

add_action( 'template_redirect', 'redirect_non_logged_users_to_specific_page' );

add_action( 'init', 'blockusers_init' );
function blockusers_init() {
	if ( is_admin() && ! current_user_can( 'administrator' ) &&
	! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

add_action( 'shutdown', 'redirect_homepage_register' );
function redirect_homepage_register() {
  if( isset( $_POST['register_form'] ) ):
    // process form, and then
    wp_redirect( home_url() );
    exit();
  endif;
}


/**
 * Implement the Custom Thumbnail Size
 */
add_image_size( 'article-thumb', 440, 250, array( 'left', 'top' ) );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
