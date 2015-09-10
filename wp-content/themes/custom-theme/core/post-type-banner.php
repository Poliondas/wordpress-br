<?php

class PostTypeBanner extends PostType {

    protected $post_type = 'banner';
    protected $labels = array('Banner', 'Banners');
    protected $metabox = array(
        "mk_banner_logo" => 'file_advanced',
        "mk_banner_logo_style" => 'textarea',
        "mk_banner_link_texto" => 'textarea',
        "mk_banner_link_url" => 'url',
        "mk_banner_link_style" => 'textarea',
        "mk_banner_bg_position" => 'slider',
    );

    /**
     * Construtor da classe
     */
    public function __construct() {

        parent::__construct();
    }

    /**
     * Registra o Post Type
     */
    public function register() {

        $args = $this->get_register_args(array(
            'menu_icon' => 'dashicons-images-alt',
            //'supports' => array('title', 'excerpt', 'thumbnail', 'comments','editor'),
        ));

        register_post_type($this->post_type, $args);

        $taxonomy = new Taxonomy(array(
            'post_type' => 'banner',
            'labels' => $this->labels,
        ));

        $taxonomy->register();

    }

    /**
     * Retorna uma lista com os banners onitido a partir da consulta com os filtros
     * @param array $filter
     * @return array
     */
    public function find($filter = array()) {
        return parent::find($filter);
    }

    /**
     * Retorna uma lista com os banners obitido a partir da consulta com os filtros
     * @return array
     */
    public function searchByTerm($term = false) {

        return parent::search($term);

        /*
        $filter = array();

        $meta_query = array(
            'relation' => 'AND',
            array(
                'key' => 'mk_banner_bg_position',
                'value' => 60,
                'compare' => '>='
            ),
            array(
                'key' => 'mk_banner_link_texto',
                'value' => $term,
                'compare' => 'LIKE'
            )
        );

        $aBanners = parent::customSearch(array(
            'term' => $term,
            'meta_query' => $meta_query,
            'filter' => $filter,
        ));

        return $aBanners;
        */
    }

    /**
     * Register Metabox
     */
    public function metabox($meta_boxes) {
        $prefix = 'mk_banner_';

        $meta_boxes[] = array(
            'title' => 'Elementos',
            'priority' => 'high',
            'post_types' => array($this->post_type),
            'fields' => array(
                // SLIDER
                array(
                    'name'       => 'Alinhamento da imagem de fundo',
                    'id'         => "{$prefix}bg_position",
                    'type'       => 'slider',
                    'std'        => '50',

                    // Text labels displayed before and after value
                    'prefix'     => '',
                    'suffix'     => '%',

                    // jQuery UI slider options. See here http://api.jqueryui.com/slider/
                    'js_options' => array(
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ),
                ),
                // FILE ADVANCED (WP 3.5+)
                array(
                    'name' => 'Logo (img)',
                    'id' => "{$prefix}logo",
                    'type' => 'file_advanced',
                    'max_file_uploads' => 1,
                    'mime_type' => 'image', // Leave blank for all file types
                ),
                // TEXTAREA
                array(
                    'name' => 'Estilização da logo',
                    'desc' => 'css personalizado para a logo',
                    'id' => "{$prefix}logo_style",
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 3,
                    'std' => "bottom: 55%;\nleft: 55%;\nmax-width:40%",
                ),
                // TEXTAREA
                array(
                    'name' => 'Texto 1',
                    'desc' => 'Texto do link',
                    'id' => "{$prefix}link_texto",
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 3,
                ),
                // URL
                array(
                    'name' => 'Url 1',
                    'id' => "{$prefix}link_url",
                    'desc' => 'Url do link',
                    'type' => 'url',
                    'std' => '',
                ),
                // TEXTAREA
                array(
                    'name' => 'Estilização do link',
                    'desc' => 'css personalizado para o link',
                    'id' => "{$prefix}link_style",
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 3,
                    'std' => 'top: 55%; left: 55%; width: 40%;',
                ),

            ),
        );

        return $meta_boxes;
    }

}

//- Instancia o PostType
global $postTypeBanner;
$postTypeBanner = new PostTypeBanner();

//- Hook into the 'init' action
add_action('init', PostTypeBannerRegister, 0);

//- Cria os metabox
add_filter('rwmb_meta_boxes', 'PostTypeBannerRegisterMetaBox');

function PostTypeBannerRegister() {
    global $postTypeBanner;
    $postTypeBanner->register();
}

function PostTypeBannerRegisterMetaBox($meta_boxes) {
    global $postTypeBanner;
    return $postTypeBanner->metabox($meta_boxes);
}
