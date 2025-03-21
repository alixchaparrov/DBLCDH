<?php
/**
 * DBL CDH Theme functions and definitions
 */

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * Enqueue scripts and styles
 */
function dbl_cdh_scripts() {
    // Bootstrap CSS CDN
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    
    // Google Fonts - Noto Sans
     wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null);
    
     // Haupt Theme Styles
    wp_enqueue_style('dbl-cdh-style', get_stylesheet_uri(), array('bootstrap'), _S_VERSION);
    
    // Personalisierte styles compiliert SCSS
    wp_enqueue_style('dbl-cdh-main-styles', get_template_directory_uri()  . '/assets/css/main.css', array('boostrap'),_S_VERSION);
    
    // Bootstrap JS desde CDN
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);
    
    // Scripts personalisiert
    wp_enqueue_script('dbl-cdh-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrap'), _S_VERSION, true);

    // Barrierefreiheit script
    wp_enqueue_script( 'dbl-cdh-accesibility', get_template_directory_uri() .  '/assets/js/accesibility.js', array('jquery'), _S_VERSION, true);

    //Variablen für das Skript zur Barrierefreiheit
    wp_localize_script( 'dbl-cdh-accesibility', 'accesibilityVars', array(
        'skipLinkText' => __('Zum Inhalt springen', 'dbl-cdh-theme'),
        'menuToggleText' => __('Menü', 'dbl-cdh-theme'),
        'menuExpandText' => __('Untermenü anzeigen', 'dbl-cdh-theme'),
        'menuCollapseText' => __('Untermenü verbergen', 'dbl-cdh-theme'),
    )); 
}
add_action('wp_enqueue_scripts', 'dbl_cdh_scripts');

/**
 * Setup theme.
 */
function dbl_cdh_setup() {
    // Fügt Standard-RSS-Feed-Links für Beiträge und Kommentare in den Kopfbereich ein.
    add_theme_support('automatic-feed-links');

    // Überlässt WP die Verwaltung des Dokuments
    add_theme_support('title-tag');

    // Aktiviert die Unterstützung für Post-Thumbnails in Beiträgen und Seiten.
    add_theme_support('post-thumbnails');

    // Dieses Thema verwendet wp_nav_menu() an einer Stelle.
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary', 'dbl-cdh-theme'),
            'footer' => esc_html__('Footer', 'dbl-cdh-theme'),
            'social' => esc_html__('Social Media Menu', 'dbl-cdh-theme'),
            'legal' => esc_html__('Rechtliches', 'dbl-cdh-theme'),
        )
    );

    // Wechselt das Standard-Core-Markup für das Suchformular, das Kommentarformular und die Kommentare, um gültiges HTML5 auszugeben.
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
            'navigation-widgets',
        )
    );
   
    //Hinzufügen von Theme-Unterstützung für die selektive Aktualisierung von Widgets.
	add_theme_support('customize-selective-refresh-widgets');

    // Unterstützung für Blockstile hinzufügen
    add_theme_support('wp-block-styles');
    
    // Unterstützung für voll- und breitformatige Bilder hinzufügen
    add_theme_support('align-wide');

    // Unterstützung für responsive Einbettungen hinzufügen
    add_theme_support('responsive-embeds');

    // Hinzufügen von Unterstützung für benutzerdefinierte Zeilenhöhensteuerungen
    add_theme_support('custom-line-height');

    // Unterstützung für experimentelle Linkfarbensteuerung hinzugefügt
    add_theme_support('experimental-link-color');

    // Unterstützung für benutzerdefinierte Einheiten hinzugefügt
    add_theme_support('custom-units');

    // Unterstützung für Editorstile hinzugefügt
    add_theme_support('editor-styles');

    // Editorstil - Google Fonts in den Editor einbinden
    add_editor_style([
        'https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        'assets/css/editot-style.css'
    ]);

    // RSS-Feed-Links für Standardbeiträge und -kommentare zum Kopf hinzufügen
    add_theme_support('automatic-feed-links');

    // Unterstützung für benutzerdefiniertes Kernlogo hinzufügen.
    add_theme_support(
        'custom-logo',
        array(
            'height'  =>250,
            'width' =>250,
            'flex-width' =>true,
            'flex-height' =>true,
        )
        );
}
add_action('after_setup_theme', 'dbl_cdh_setup');

/**
 * Konfiguration der Sidebar
 */
function dbl_cdh_widgets_init() {
    register_sidebar( 
        array(
            'name'          => esc_html__( 'Sidebar', 'dbl-cdh-theme'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Widgets hier hinzufügen.', 'dbl-cdh-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s"',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    // Footer widgets
    register_sidebar( 
        array(
            'name'          => esc_html__( 'Footer - Kontakt', 'dbl-cdh-theme'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Füge Widgets für den Kontaktbereich im Footer hinzu', 'dbl-cdh-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s"',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
};
add_action( 'widgets_init', 'dbl_cdh_widgets_init');

/**
 * Barrierefreie Funktionen
 */
function dbl_cdh_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#primary">' . esc_html__('Zum Inhalt springen', 'dbl-cdh-theme') . '</a>';
}
add_action('wp_body_open', 'dbl_cdh_skip_link');

/**
 * Hinzufügen von ARIA-Attributen zu den Navigationsmenüs
 */

 function dbl_cdh_nav_menu_aria_atributes($atts, $item, $args){
    // Hinzufügen von ARIA-Attributen zu Elementen, die Untermenüs haben
    if(in_array('menu-item-has-children', $item->classes)){
        $atts['aria-haspopup'] = 'true';
        $atts['aria-expanded'] = 'false';
    }
    return $atts;
 }

 /**
  * Unterstützung für Block- und Stil-Editor
  */

  function dbl_cdh_editor_support(){
    // Fügt Unterstützung für den Blockeditor hin
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    
    //Unterstützung für Editorstile
    add_theme_support('editor-styles');

    add_editor_style([
        'https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        'assets/css/editor-style.css'
    ]);
  }
  add_action('after_setup_theme', 'dbl_cdh_editor_support');

  /**
   *  Bootstrap in den Block-Editor einbinden
   */

   function dbl_cdh_enqueue_bootstrap_in_block_editor(){
    //BootstraP  CSS für Editor
    wp_enqueue_style( 'bootstrap-editor',  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    
    //Benutztdefinierte Stil für den Editor
    wp_enqueue_style('dbl-cdh-editor-styles', get_template_directory_uri() . '/assets/css/editor-style.css', array('bootstrap-editor'), _S_VERSION);

}
add_action('enqueue_block_assets', 'dbl_cdh_enqueue_bootstrap_in_block_editor');