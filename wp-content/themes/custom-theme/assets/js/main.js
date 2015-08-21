//----- Adiciona uma expressão que filtra apenas os elementos visíveis na tela
jQuery.expr[":"].inScreen = function(elem){
    var sT = jQuery(window).scrollTop()
    var sH = jQuery(window).height();
    var $elem = jQuery(elem);
    var eT = $elem.offset().top;
    var eH = $elem.height();
    var dist = 50;
    var s1 = (eT + eH < sT + dist);
    var s2 = (eT > sT + sH - dist);
   return !(s1 || s2);
}

jQuery(document).ready(function($) {
    // fitVids.
    $( '.entry-content' ).fitVids();

    // Responsive wp_video_shortcode().
    $( '.wp-video-shortcode' ).parent( 'div' ).css( 'width', 'auto' );

    /**
     * Odin Core shortcodes
     */

    // Tabs.
    $( '.odin-tabs a' ).click(function(e) {
        e.preventDefault();
        $(this).tab( 'show' );
    });

    // Tooltip.
    $( '.odin-tooltip' ).tooltip();

});

//----- Rola o site até uma posição específica
function scrollBodyTo(scroll_to){

    var scroll_atual = jQuery('html')[0].scrollTop;
    var scroll_time = (scroll_atual - scroll_to) / 20;

    if(scroll_time < 0){
        scroll_time = -scroll_time;
    }

    scroll_time += 600;

    jQuery('html, body').animate({scrollTop: scroll_to},scroll_time);

}

//----- Adiciona a classe 'animated' aos elementos que entraram na tela e
//----- remove a classe 'animated' dos elementos que sairam
function handleAnimate(){
    $animate.filter(':inScreen').not('.animated').each(function(){
        var $this = jQuery(this);
        $this.addClass('animated').removeClass('animate');
    });

    $animate.filter('.animated').not(':inScreen').each(function(){
        var $this = jQuery(this);
        $this.addClass('animate').removeClass('animated');
    })
}

//----- Inicializa a animação dos elementos pela rolagem
    function initAnimate(){

        jQuery(window).on('scroll',function(){
            handleAnimate();
        })

        $animate = jQuery('.animate');
        handleAnimate();
    }
//----- FIM: initAnimate

//----- Inicializa o scroll da página
    function initScroll(){
        jQuery(document).on('mousewheel || DOMMouseScroll || MozMousePixelScroll || touchmove',function(e){
            e.preventDefault();
            e = e.originalEvent;
            var delta = parseInt(e.wheelDelta || -e.detail);
            delta = delta < 0;
            scrollBody(delta);

        })
        jQuery(document).on('touchmove',function(e){
            e.preventDefault();

            scrollBody(true);
        });
    }
//----- FIM: initScroll

//----- Rolagem suave do site
    function scrollBody(delta){
        var t = document.body.scrollTop || document.documentElement.scrollTop;
        t = (delta) ? t + 260 : t - 260;

        jQuery('html,body')
            .stop(true)
            .animate(
            {
                //transform: 'translate(0, -'+t+'px) translateZ(0)'
                scrollTop: t
            },
            {
                duration: 400,
                //easing: $.bez([0, 0.33, 0.66, 1]),
                progress: function(){
                    //console.log($mainScroll.position().top)
                }
            }
            );
    }
//----- FIM: scrollBody

//----- Compartilha uma foto nas redes sociais
//----- foto: url da imagem
//----- url: url da página de compartilhamento 'image.php'
    function shareFoto(rede,foto,url){
        console.log(rede,foto,url);
        url = encodeURIComponent(url);
        var domain = document.domain;
        var cliente = encodeURIComponent("Fato Básico");
        var textoFace = encodeURIComponent("A nova coleção verão 2016 está demais! Confira e compartilhe.");
        var textoTwitter = encodeURIComponent("A nova coleção verão 2016 está demais! Confira e compartilhe.");
        var textoPinterest = encodeURIComponent("A nova coleção verão 2016 está demais! Confira e compartilhe.");

        switch(rede){
            case 't':
                //url = "http://"+(domain)+"/share/catalogo.php?id="+(id);
                window.open(
                    "http://twitter.com/?status="+(textoTwitter)+ (url),
                    'twitter-share-dialog',
                    'width=626,height=436');
                break;
            case 'f':
                //url = "http://"+(domain)+"/share/catalogo.php?id="+(id);
                window.open(
                    'https://www.facebook.com/sharer/sharer.php?u='+(url),
                    'facebook-share-dialog',
                    'width=626,height=436');
                break;
            case 'p':
                var url2 = 'http://www.pinterest.com/pin/create/button/?url='+(url)+'&media='+(url)+'&description=DescriptionText';
                    url2 = 'http://www.pinterest.com/pin/create/button/?url='+(foto)+'&media='+(foto)+'&description=DescriptionText';
                window.open(
                    url2,
                    'pinterest-share-dialog',
                    'width=626,height=436');
                break;
            case 'g':
                var url2 = 'https://plus.google.com/share?url='+url;
                window.open(
                    url2,
                    'gplus-share-dialog',
                    'width=626,height=436');
                break;
        }

    }
//----- FIM: shareFoto
