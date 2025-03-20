<?php
/**
 * dbl-cdh-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dbl-cdh-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}
#endregion Version

#region Allgemeine Funktionen

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dbl_cdh_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		*/
	load_theme_textdomain( 'dbl-cdh-theme', get_template_directory() . '/languages' );

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

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);


	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'dbl_cdh_theme_setup' );

#endregion Allgemeine Funktionen

#region Meta Tags hinzufügen

// Meta-Tags für Theme Color hinzufügen

 function add_theme_color_meta_tag()
 {
     // Überprüfen, ob das Tag schon existiert
     if (! has_action('wp_head', 'theme_color_meta_tag')) {
 ?>
         <meta name="theme-color" media="(prefers-color-scheme: light)" content="#65C8E8" />
         <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#151b35" />
     <?php
     }
 }
 add_action('wp_head', 'add_theme_color_meta_tag');
 #endregion Meta Tags hinzufügen

 #region Styles und Scripts

// Enqueue scripts and styles.

function dbl_cdh_theme_scripts() {
    // Bootstrap CDN
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2', 'all');
    
    // Andere styles
    wp_enqueue_style('dbl-cdh-theme-swiperslider-style', get_template_directory_uri() . '/css/swiper.min.css', array(), false, 'all');
    wp_enqueue_style('dbl-cdh-theme-style', get_stylesheet_uri(), array('bootstrap'), _S_VERSION);
    wp_enqueue_style('dbl-cdh-theme-ally', get_template_directory_uri() . '/css/a11y.css', array(), false, 'all');
    wp_style_add_data('dbl-cdh-theme-style', 'rtl', 'replace' );
    
    // Scripts
    wp_enqueue_script('dbl-cdh-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('dbl-cdh-theme-a11y', get_template_directory_uri() . '/js/a11y.js', array(), _S_VERSION, true);
    
    // Bootstrap JS CDN
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);
    
    // Andere Scripts
    wp_enqueue_script('dbl-cdh-theme-swiperslider-scripts', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('dbl-cdh-theme-browser', get_template_directory_uri() . '/js/notification.js', array(), _S_VERSION, true);
    wp_enqueue_script('dbl-cdh-theme-searchmodal', get_template_directory_uri() . '/js/searchmodal.js', array('jquery'), _S_VERSION, true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'dbl_cdh_theme_scripts' );

#endregion Styles und Scripts

#region Bootstrap für Block-Editor

function enqueue_bootstrap_in_block_editor() {
    // Bootstrap CSS CDN 
    wp_enqueue_style('bootstrap-editor', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap-grid.min.css', array(), '5.3.2');
}
add_action('enqueue_block_editor_assets', 'enqueue_bootstrap_in_block_editor');

#endregion Bootstrap für Block-Editor
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

#region Theme-Support

function my_theme_setup()
{
	// Unterstützung für die theme.json-Datei aktivieren
	add_theme_support('wp-block-styles');
	add_theme_support('editor-styles');
	add_theme_support('align-wide');
	add_theme_support('wp-block-editor-settings');
}

add_action('after_setup_theme', 'my_theme_setup');

function my_theme_enqueue_editor_assets()
{
	// Enqueue theme's stylesheet for the editor
	add_editor_style('css/style-editor.css');
}

add_action('enqueue_block_editor_assets', 'my_theme_enqueue_editor_assets');

#endregion Theme-Support

#region ACF Felder für Verwendung im Block Editor

function show_acf_field($atts)
{
	$atts = shortcode_atts(
		array(
			'field' => '', // Name des ACF-Feldes
			'post_id' => null, // Standard ist der aktuelle Beitrag
		),
		$atts,
		'acf_field'
	);

	$field_value = get_field($atts['field'], $atts['post_id']);

	if ($field_value) {
		return $field_value;
	}

	return ''; // Leer, wenn kein Feld gefunden wird
}
add_shortcode('acf_field', 'show_acf_field');

#endregion ACF Felder für Verwendung im Block Editor

#region Relevanssi Ajax Live Search


// This filter hook removes the base styles that control the live search result position.
// add_filter('relevanssi_live_search_base_styles', '__return_false');
add_filter('relevanssi_live_search_add_result_div', '__return_false');
add_action('wp_enqueue_scripts', function () {
	wp_dequeue_style('relevanssi-live-search');
});

// There’s a filter for that! Add this to your theme functions.php or in a code snippet:

add_filter('relevanssi_live_search_posts_per_page', function () {
	return 10;
});

add_filter('relevanssi_live_search_configs', function ($config) {
	$config['default']['input']['min_chars'] = 3;
	return $config;
});

#endregion Relevanssi Ajax Live Search

require_once get_template_directory() . '/cdh-funktionen.php';
add_theme_support('editor-styles');
add_editor_style('css/style-editor.css');