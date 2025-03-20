<?php
/**
 * DBL CDH Theme functions and definitions
 */

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * Enqueue scripts and styles.
 */
function dbl_cdh_scripts() {
    // Bootstrap CSS desde CDN
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    // Google Fonts - Noto Sans
     wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null);
    // Estilos principales del tema
    wp_enqueue_style('dbl-cdh-style', get_stylesheet_uri(), array('bootstrap'), _S_VERSION);
    
    // Bootstrap JS desde CDN
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);
    
    // Scripts personalizados
    wp_enqueue_script('dbl-cdh-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrap'), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'dbl_cdh_scripts');

/**
 * Setup theme.
 */
function dbl_cdh_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register menu locations
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary', 'dbl-cdh-theme'),
            'footer' => esc_html__('Footer', 'dbl-cdh-theme'),
        )
    );

    // Add support for HTML5
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

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style([
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        'style.css'
    ]);
}
add_action('after_setup_theme', 'dbl_cdh_setup');

/**
 * Incluir funciones de accesibilidad
 */
function dbl_cdh_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#primary">' . esc_html__('Zum Inhalt springen', 'dbl-cdh-theme') . '</a>';
}
add_action('wp_body_open', 'dbl_cdh_skip_link');