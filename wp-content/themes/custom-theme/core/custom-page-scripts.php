<?php
//- Adiciona js e css específico para a página
    add_action('wp_enqueue_scripts','add_custom_page_scripts');

    function add_custom_page_scripts(){
        global $post;

        $template_dir = get_template_directory();
        $template_uri = get_template_directory_uri();

        $fileJS = '/assets/js/pages/'.$post->post_name.'.js';
        $fileCSS = '/assets/css/pages/'.$post->post_name.'.css';

        if(file_exists($template_dir.$fileJS)){
            wp_enqueue_script( 'page-script', $template_uri . $fileJS, array(), null, true );
        }

        if(file_exists($template_dir.$fileCSS)){
            wp_enqueue_style( 'page-style', $template_uri . $fileCSS, array(), null, 'all' );
        }

    }
