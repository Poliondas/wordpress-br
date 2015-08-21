jQuery(document).ready(function($) {

    $(document).on('click', '.bloco-video .bt-play', function(){
        var $bt_play = $(this);
        var $bloco = $bt_play.parents('.bloco-video');
        var $video = $bloco.find('video');
        var video = $video[0];

        video.play();
        video.controls = true;
        $bloco.addClass('plaing');
    })

    $(document).on('click', '.bloco-video .bt-stop', function(){
        var $bt_stop = $(this);
        var $bloco = $bt_stop.parents('.bloco-video');
        var $video = $bloco.find('video');
        var video = $video[0];

        video.pause();
        video.load();
        video.controls = false;
        $bloco.removeClass('plaing');
    })
    
});
