<?php
    $template_dir = get_template_directory_uri();
?>

<div class="bloco-video fashion-video vh">
    <a name="fashion-film" style="font-size: 0;"></a>

    <div class="tb full">
        <div class="td center">

            <video id="fashion-video" class="bg-video" _muted="1" _autoplay="1" loop="1" _controls='1' data-src="http://videos.marknet.com.br/clientes/fato-basico/fashion-film.mp4" poster="<?php echo $template_dir;?>/assets/images/fashion-film-poster.jpg">
                <source type="video/mp4" src="http://videos.marknet.com.br/clientes/kissflower/2016-fashion-film.mp4">
            </video>

            <div class="titulo border-corner">
                ASSISTA AO FASHION FILM
            </div>

            <div class="bt-play">
                <span class="seta"></span>
                <!--<img src="<?php echo $template_dir; ?>/assets/images/bt-play.png" />-->
            </div>

            <div class="bt-stop">
                <span class="seta"></span>
                <!--<img src="<?php echo $template_dir; ?>/assets/images/bt-stop.png" />-->
            </div>

        </div>
    </div>

</div>
