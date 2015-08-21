<?php
/**
 * Gera o base64 de um png transparente
 */
function blank_png($w=100, $h=100){

    $img = imagecreatetruecolor($w, $h);
    // Prepare alpha channel for transparent background
    $alpha_channel = imagecolorallocatealpha($img, 0, 0, 0, 127);
    imagecolortransparent($img, $alpha_channel);
    // Fill image
    imagefill($img, 0, 0, $alpha_channel);
    // Save transparency
    imagesavealpha($img,true);

    ob_start();
    imagepng($img);
    return 'data:image/png;base64,'.base64_encode(ob_get_clean());

}
/** END blank_png */

/**
 * Paginação simples
 */
    function pagination_funtion($mx) {
        $total = $mx;

        if ( $total > 1 )  {
            if ( !$current_page = get_query_var('paged') )
                $current_page = 1;

                $big = 999999999;

                $permalink_structure = get_option('permalink_structure');
                $format = empty( $permalink_structure ) ? '&page=%#%' : 'page/%#%/';
                echo paginate_links(array(
                    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                    'format' => $format,
                    'current' => $current_page,
                    'total' => $total,
                    'mid_size' => 2,
                    'type' => 'plain'
                ));
            }
    }
/** END Paginação */
