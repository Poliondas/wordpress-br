<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of taxonomy
 *
 * @author carlos
 */
class Taxonomy {

    protected $labels;
    protected $post_type;
    protected $taxonomy_name;

    public function __construct($args = array()) {
        $this->post_type = $args['post_type'];
        $this->labels = $args['labels'];
        $this->taxonomy_name = 'classificacao_de_' . $this->post_type;
    }

    public function register() {

        $labels = $this->get_register_labels();
        $args = $this->get_register_args($labels);

        register_taxonomy($this->taxonomy_name, array($this->post_type), $args);
    }

    protected function get_register_args($labels) {

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );

        return $args;
    }

    protected function get_register_labels() {
        $labels = array(
            'name' => 'Classificações de ' . $this->labels[1],
            'singular_name' => 'Classificação de ' . $this->labels[0],
            'menu_name' => __('Classificação', 'text_domain'),
            'all_items' => __('All Items', 'text_domain'),
            'parent_item' => __('Parent Item', 'text_domain'),
            'parent_item_colon' => __('Parent Item:', 'text_domain'),
            'new_item_name' => __('New Item Name', 'text_domain'),
            'add_new_item' => __('Add New Item', 'text_domain'),
            'edit_item' => __('Edit Item', 'text_domain'),
            'update_item' => __('Update Item', 'text_domain'),
            'view_item' => __('View Item', 'text_domain'),
            'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
            'add_or_remove_items' => __('Add or remove items', 'text_domain'),
            'choose_from_most_used' => __('Choose from the most used', 'text_domain'),
            'popular_items' => __('Popular Items', 'text_domain'),
            'search_items' => __('Search Items', 'text_domain'),
            'not_found' => __('Not Found', 'text_domain'),
        );

        return $labels;
    }

    /**
     * Recupera uma lista de categorias
     */
    function find($p = array()) {

        $idPai = 0;

        $args = array(
            'type' => 'social',
            'parent' => $idPai,
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hide_empty' => 1,
            'taxonomy' => $this->taxonomy_name,
            'pad_counts' => false
        );
        
        foreach($p as $key => $val){
         
            $args[$key] = $val;
            
        }

        
        $categories_obj = get_categories( $args );
        $categories = array();
        foreach($categories_obj as $categorie){
            $categories[] = (array)$categorie;
        }

        return $categories;
    }

}
