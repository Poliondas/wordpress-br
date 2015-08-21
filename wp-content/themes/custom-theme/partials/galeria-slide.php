<?php
    $galeria = array();
?>

<div class="galeria-slide galeria-outer float-center">
    <div class="galeria-social float-center">
        compartilhe<br>
        <a href="javascript:;" class="link fa fa-facebook" data-rede="f"></a>
        <a href="javascript:;" class="link fa fa-google-plus" data-rede="g"></a>
        <a href="javascript:;" class="link fa fa-pinterest-p" data-rede="p"></a>
        <a href="javascript:;" class="link zoom fa fa-search-plus"></a>
    </div>
    <div class="galeria-slider owl-carousel">
        <?php
            foreach($galeria as $item){
                $medium = wp_get_attachment_url($item['ID'], 'medium');
                $large = wp_get_attachment_url($item['ID'], 'large');
                $attachment_page = get_attachment_link( $item['ID'] );
        ?>
        <div
            class="item owl-lazy"
            data-foto="<?php echo $large; ?>"
            data-share="<?php echo $attachment_page; ?>"
            data-src="<?php echo $medium; ?>">

            <a
                class="fancybox"
                href="<?php echo $large; ?>" >ZOOM</a>
        </div>

        <?php
            }
        ?>
    </div>
    <div class="galeria-prev">
        <span class="page">1/20</span>
    </div>
    <div class="galeria-next">
        <span class="page">1/20</span>
    </div>
</div>
