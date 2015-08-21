<?php
    
    $template_dir = get_template_directory_uri(); 
    //$thumbBlank = blank_png(90,160);
    
    //$thumbBlank = $template_dir.'/assets/images/blank.png';

    add_action( 'wp_enqueue_scripts', 'add_script_custom', 3 );
    add_action( 'wp_head', 'add_social_tags', 4 );

    get_header(); 
    
?>

    <main id="content" class="<?php echo odin_classes_page_full(); ?>" tabindex="-1" role="main">
        <!--<h1 class='page-title'>Imagem compartilhada</h1>
        <h2 class='page-title2'>LINHA DO TEMPO FATO BÁSICO</h2>-->
        <h1 class="page-title" style="margin: 0;">A nova coleção verão 2016 está demais!<br>Confira e compartilhe.</h1>
        <div class="image-outer">
                <?php
                
                    echo wp_get_attachment_image($post->ID,'full','',array(
                        'class' => 'image',
                    ));
                    
                ?>
        </div>
        
                <?php
                    /*
                 $args = array(
                   'post_type' => 'attachment',
                   'numberposts' => -1,
                   'post_status' => null,
                   'post__in' => array($post->ID)
                  );

                  $attachments = get_posts( $args );
                     if ( $attachments ) {
                        foreach ( $attachments as $attachment ) {
                           echo '<li>';
                           the_attachment_link( $attachment->ID, true );
                           echo '<p>';
                           echo apply_filters( 'the_title', $attachment->post_title );
                           echo '</p></li>';
                          }
                     }
                     

                
                     wp_reset_postdata();
                     */
                 ?>
        
        
        
    </main>
    
<?php
    
    
    
    
    get_footer();

    
    /**
     * Adiciona o script específico para esta página
     */
    
    function add_script_custom(){
        $template_uri = get_template_directory_uri();

        wp_enqueue_style( 'attachment-css', $template_uri.'/assets/css/pages/attachment.css', array(), null, 'all' );
        
    }
    function add_social_tags(){
        global $post;
        $id = $post->ID;
        
        $title = get_bloginfo( 'name' );
        $urlFotoShare = wp_get_attachment_url( $id );
        $urlFace = get_attachment_link( $id );
        $descp = '';
        
        echo "
            <meta name='description' content='{$title}' />
            <meta name='DC.title' content='{$title}' />
            <meta name='geo.region' content='BR-PR' />
            <meta name='geo.placename' content='Cianorte' />
            <meta name='geo.position' content='' />
            <meta name='ICBM' content='' />

            <meta property='og:url' content='{$urlFotoShare}'>
            <meta property='og:title' content='{$title}'>
            <meta property='og:site_name' content='Fato Basico'>
            <meta property='og:description' content='descrição: {$descp}'>
            <meta property='og:image' content='{$urlFotoShare}'>
            <meta property='og:image:type' content='image/jpg'>
            <meta property='og:image:width' content='114'> 
            <meta property='og:image:height' content='114'>
            <meta property='og:type' content='website'> 
        ";
    }
     
     