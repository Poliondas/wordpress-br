<?php

class PostType {

    protected $metabox;
    protected $post_type;
    protected $labels;

    public function __construct() {

    }

    /**
     * Constroi o array de argumentos para a consulta
     *
     * @param string $postType
     * @param array $filter
     * @return array
     */
    protected function getArgs($filter = array()) {

        //- Argumento inciais
        $args = array(
            'post_type' => $this->post_type,
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'posts_per_page' => -1,
            'order' => 'ASC',
        );

        //- standard taxonomy
        if (!empty($filter['taxonomy'])) {
            $args['classificacao_de_' . $this->post_type] = $filter['taxonomy'];
            unset($filter['taxonomy']);
        }

        if (!empty($filter['paged']) && !isset($filter['posts_per_page'])) {
            $args['posts_per_page'] = get_option('posts_per_page');
        }

        foreach ($filter as $key => &$val) {

            $args[$key] = $val;
        }


        return $args;
    }

    /**
     * Constroi a lista de posts relacionados ao termo buscado.
     * Consulta e insere os metas definidos no parâmetro $metabox
     *
     * @param array $p
     * @return array
     */
    protected function search($p = array()) {

        $term = isset($p['term']) ? $p['term'] : '';
        $meta_query = isset($p['meta_query']) ? $p['meta_query'] : array();
        $filter = isset($p['filter']) ? $p['filter'] : array();

        $args = $this->getArgs($filter);

        $args['s'] = $term;

        $q1 = new WP_Query($args);

        if (isset($p['meta_query']) && count($p['meta_query']) > 0) {

            unset($args['s']);
            $args['meta_query'] = $meta_query;

            $q2 = new WP_Query($args);

            $result = new WP_Query();
            $result->posts = array_unique(array_merge($q1->posts, $q2->posts), SORT_REGULAR);
            $result->post_count = count($result->posts);

            return $this->createList($result);
        } else {
            return $this->createList($q1);
        }
    }

    protected function createList($result) {

        global $post;

        $aList = array();

        if ($result->have_posts()) {

            while ($result->have_posts()) {
                $result->the_post();

                $item = array(
                    'id' => $post->ID,
                    'post_date' => $post->post_date,
                    'post_title' => $post->post_title,
                    'post_name' => $post->post_name,
                    'post_content' => $post->post_content,
                    'post_excerpt' => $post->post_excerpt,
                    'comment_count' => $post->comment_count,
                );

                $this->addAditionalData($item);

                $aList[] = $item;
            }
        }

        return $aList;
    }

    /**
     * Constroi a lista de posts a serem retornados.
     * Consulta e insere os metas definidos no parâmetro $metabox
     *
     * @global Object $post
     * @param array $args
     * @param array $metaBox
     * @return array
     */
    function find($filter = array()) {

        global $post;

        $args = $this->getArgs($filter);

        $the_query = new WP_Query($args);

        return $this->createList($the_query);
    }

    /**
     * Adiciona os metas definidos no parâmetro $metabox a lista $item
     *
     * @global Object $post
     * @param array $item
     * @param array $metaBox
     * @return array
     */
    protected function addAditionalData(&$item) {

        global $post;

        if (post_type_supports($this->post_type, 'thumbnail')) {
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = ( $thumb_id ) ? wp_get_attachment_url($thumb_id) : '';
            $item['featured_image'] = $thumb_url;
        }

        foreach ($this->metabox as $key => $type) {

            $item[$key] = rwmb_meta($key, array('type' => $type));
        }

        return $item;

    }

    protected function get_register_labels() {
        $s = $this->labels[0];
        $p = $this->labels[1];

        $labels = array(
            'name' => _x($p, 'Post Type General Name', 'text_domain'),
            'singular_name' => _x($s, 'Post Type Singular Name', 'text_domain'),
            'menu_name' => __($p, 'text_domain'),
            'name_admin_bar' => __($p, 'text_domain'),
            'parent_item_colon' => __('$s pai', 'text_domain'),
            'all_items' => __('Todos os Banners', 'text_domain'),
            'add_new_item' => __('Adicionar novo banner', 'text_domain'),
            'add_new' => __('Adicionar novo', 'text_domain'),
            'new_item' => __("Novo $s", 'text_domain'),
            'edit_item' => __("Editar $s", 'text_domain'),
            'update_item' => __("Atualizar $s", 'text_domain'),
            'view_item' => __("Ver $s", 'text_domain'),
            'search_items' => __("Procurar $s", 'text_domain'),
            'not_found' => __("$s não encontrado", 'text_domain'),
            'not_found_in_trash' => __("$s não encontrado na lixeira", 'text_domain'),
        );

        return $labels;
    }

    protected function get_register_args($arr = array()) {

        $labels = $this->get_register_labels();

        $args = array(
            'label' => $labels['singular_name'],
            'description' => $labels['name'],
            'supports' => array('title', 'excerpt', 'thumbnail', 'comments',),
            'taxonomies' => array('classificacao_de_' . $labels['singular_name']),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-images-alt',
            //'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        );

        foreach ($arr as $key => &$val) {
            $args[$key] = $val;
        }

        $args['labels'] = $labels;

        return $args;
    }

}
