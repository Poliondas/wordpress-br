<?php
    //- Cria os metabox
    add_filter('rwmb_meta_boxes', 'register_metabox');

    function register_metabox($meta_boxes){

        /*
        $prefix = 'mk_page_';



        $meta_boxes[] = array(
            'title' => 'Elementos',
            'priority' => 'high',
            'post_types' => array('page'),
            'fields' => array(
                // TEXTAREA
                array(
                    'name' => 'Título da página',
                    'desc' => 'título principal da página [h1]',
                    'id' => "{$prefix}title",
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 3,
                ),
            ),
        );

        $meta_boxes[] = array(
            'title' => 'Galeria',
            'priority' => 'high',
            'post_types' => array('page'),
            'fields' => array(
                 // FILE ADVANCED (WP 3.5+)
                array(
                    'name' => 'Galeria',
                    'id' => "{$prefix}galeria",
                    'type' => 'file_advanced',
                    //'max_file_uploads' => 30,
                    'mime_type' => 'image', // Leave blank for all file types
                ),
            ),
        );

        $meta_boxes[] = array(
            'id'         => 'map',
            'title'      => 'Localização',
            'post_types' => array( 'page' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'autosave'   => true,
            'fields'     => array(
               // CHECKBOX
                array(
                    'name' => __( '<u><em>Utilizar Mapa</em></u>', "{$prefix}" ),
                    'id'   => "{$prefix}is_map",
                    'type' => 'checkbox',
                    // Value can be 0 or 1
                    'std'  => 0,
                ),
                // Map requires at least one address field (with type = text)
                array(
                    'id'   => "{$prefix}map_address",
                    'name' => '<br>Endereço',
                    'type' => 'text',
                    'std'  => 'Maringá',
                ),
                array(
                    'id'            => "{$prefix}map",
                    'name'          => 'Localização',
                    'type'          => 'map',
                    // Default location: 'latitude,longitude[,zoom]' (zoom is optional)
                    'std'           => '-23.466592,-51.993999,15z',
                    // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
                    'address_field' => "{$prefix}map_address",
                ),
            ),
        );
        */
        return $meta_boxes;
    }
