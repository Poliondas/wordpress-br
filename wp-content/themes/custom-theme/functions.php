<?php
/**
 * Odin functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Odin
 * @since 2.2.0
 */

/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 600;
}

$template_directory = get_template_directory();
/**
 * Odin Classes.
 */
// require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
// require_once get_template_directory() . '/core/classes/class-shortcodes.php';
// require_once get_template_directory() . '/core/classes/class-thumbnail-resizer.php';
// require_once get_template_directory() . '/core/classes/class-theme-options.php';
// require_once get_template_directory() . '/core/classes/class-options-helper.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';
// require_once get_template_directory() . '/core/classes/abstracts/abstract-front-end-form.php';
// require_once get_template_directory() . '/core/classes/class-contact-form.php';
// require_once get_template_directory() . '/core/classes/class-post-form.php';
// require_once get_template_directory() . '/core/classes/class-user-meta.php';
require_once $template_directory . '/core/post-type.php';
require_once $template_directory . '/core/post-type-banner.php';
require_once $template_directory . '/core/taxonomy.php';

require_once $template_directory . '/core/mk-helpers.php';
require_once $template_directory . '/core/pages-metaboxes.php';
require_once $template_directory . '/core/custom-pages-scripts.php';

/**
 * Odin Widgets.
 */
require_once $template_directory . '/core/classes/widgets/class-widget-like-box.php';

if ( ! function_exists( 'odin_setup_features' ) ) {

    /**
     * Setup theme features.
     *
     * @since  2.2.0
     *
     * @return void
     */
    function odin_setup_features() {

        /**
         * Add support for multiple languages.
         */
        load_theme_textdomain( 'odin', get_template_directory() . '/languages' );

        /**
         * Register nav menus.
         */
        register_nav_menus(
            array(
                'main-menu' => __( 'Main Menu', 'odin' )
            )
        );

        /*
         * Add post_thumbnails suport.
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Add feed link.
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Support Custom Header.
         */
        $default = array(
            'width'         => 0,
            'height'        => 0,
            'flex-height'   => false,
            'flex-width'    => false,
            'header-text'   => false,
            'default-image' => '',
            'uploads'       => true,
        );

        add_theme_support( 'custom-header', $default );

        /**
         * Support Custom Background.
         */
        $defaults = array(
            'default-color' => '',
            'default-image' => '',
        );

        add_theme_support( 'custom-background', $defaults );

        /**
         * Support Custom Editor Style.
         * Allows theme developers to link a custom stylesheet file to the TinyMCE visual editor.
         */
        add_editor_style( 'assets/css/editor-style.css' );

        /**
         * Add support for infinite scroll.
         */
         /*
        add_theme_support(
            'infinite-scroll',
            array(
                'type'           => 'scroll',
                'footer_widgets' => false,
                'container'      => 'content',
                'wrapper'        => false,
                'render'         => false,
                'posts_per_page' => get_option( 'posts_per_page' )
            )
        );
        */

        /**
         * Add support for Post Formats.
         */
        // add_theme_support( 'post-formats', array(
        //     'aside',
        //     'gallery',
        //     'link',
        //     'image',
        //     'quote',
        //     'status',
        //     'video',
        //     'audio',
        //     'chat'
        // ) );

        /**
         * Support The Excerpt on pages.
         */
        // add_post_type_support( 'page', 'excerpt' );

        /**
         * Switch default core markup for search form, comment form, and comments to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption'
            )
        );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
    }
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Register widget areas.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_widgets_init() {
    register_sidebar(
        array(
            'name' => __( 'Main Sidebar', 'odin' ),
            'id' => 'main-sidebar',
            'description' => __( 'Site Main Sidebar', 'odin' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widgettitle widget-title">',
            'after_title' => '</h3>',
        )
    );
}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_flush_rewrite() {
    flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * Load site scripts.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_enqueue_scripts() {
    $template_url = get_template_directory_uri();

    // Loads Odin main stylesheet.
    wp_enqueue_style( 'odin-style', get_stylesheet_uri(), array(), null, 'all' );

    // jQuery.
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap', $template_url . '/assets/js/libs/bootstrap.min.js', array('jquery'), null, true );
    wp_enqueue_script( 'odin-main-min', $template_url . '/assets/js/main.min.js', array('jquery'), null, true );

    // Grunt watch livereload in the browser.
    // wp_enqueue_script( 'odin-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true );

    // Load Thread comments WordPress script.
    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );

/**
 * Odin custom stylesheet URI.
 *
 * @since  2.2.0
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function odin_stylesheet_uri( $uri, $dir ) {
    return $dir . '/assets/css/style.css';
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Query WooCommerce activation
 *
 * @since  2.2.6
 *
 * @return boolean
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        return class_exists( 'woocommerce' ) ? true : false;
    }
}

/**
 * Core Helpers.
 */
require_once $template_directory . '/core/helpers.php';

/**
 * WP Custom Admin.
 */
require_once $template_directory . '/inc/admin.php';

/**
 * Comments loop.
 */
require_once $template_directory . '/inc/comments-loop.php';

/**
 * WP optimize functions.
 */
require_once $template_directory . '/inc/optimize.php';

/**
 * Custom template tags.
 */
require_once $template_directory . '/inc/template-tags.php';


/**
 * Metabox for pages
 */
require_once $template_directory . '/core/pages-metaboxes.php';

/**
 * WooCommerce compatibility files.
 */
if ( is_woocommerce_activated() ) {
    add_theme_support( 'woocommerce' );
    require $template_directory . '/inc/woocommerce/hooks.php';
    require $template_directory . '/inc/woocommerce/functions.php';
    require $template_directory . '/inc/woocommerce/template-tags.php';
}


//- Adiciona a variável ajaxurl ao frontend
  add_action('wp_head','fixed_ajaxurl');

function fixed_ajaxurl() {
  $url = admin_url('admin-ajax.php');;
  echo "
    <script type='text/javascript'>
      var ajaxurl = '{$url}';
      var ajaxurlblog = 'http://kissflower.com.br/blog/wp-admin/admin-ajax.php';
    </script>
  ";
}

if(function_exists('add_script_custom')){
    add_action('wp_enqueue_scripts', 'add_script_custom', 3);
}