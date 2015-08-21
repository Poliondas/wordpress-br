jQuery(function($){

    var $window = $(window);
    var $galeriaOwl;
    var $galeriaOwlPrev = $('.galeria-prev');
    var $galeriaOwlNext = $('.galeria-next');
    var $galeriaOwlPrevText = $('.galeria-prev span');
    var $galeriaOwlNextText = $('.galeria-next span');

    $galeriaOwl = $('.galeria-slider').owlCarousel({
        items: 1,
        center: false,
        margin: 0,
        lazyLoad: true,
        nav: false,
        //navText: ['', ''],
        loop: true
    });

    $galeriaOwl.on('changed.owl.carousel', function(e){
        var indice = e.page.index;
        var count = e.page.count;
        var prev = (indice - 1) + 1;
        var next = (indice + 1) + 1;
        if(prev <= 0){
            prev = count;
        }

        if(next >= count){
            next = 1;
        }
        $galeriaOwlNextText.text(next+'/'+count);
        $galeriaOwlPrevText.text(prev+'/'+count);
    })

    $galeriaOwlNext.on('click',function(){
        $galeriaOwl.trigger('next.owl.carousel');
    });

    $galeriaOwlPrev.on('click',function(){
        $galeriaOwl.trigger('prev.owl.carousel');
    });

    $galeriaOwl.trigger('to.owl.carousel',1);
    setTimeout(function(){
        $galeriaOwl.trigger('to.owl.carousel',0);
    },100)

    $(".galeria-slide .galeria-social .link").on('click', function(){
        var $this = $(this);
        var $item = $galeriaOwl.find('.owl-item.active').find('.item');

        if($this.hasClass('zoom')){
            $item.find('.fancybox').trigger('click');
        }else{
            var rede = $this.attr('data-rede');
            var foto = $item.attr('data-foto');
            var url = $item.attr('data-share');

            shareFoto(rede,foto,url);
        }

    })

    setTimeout(function(){
        $('.fancybox').fancybox({
          helpers: {
            overlay: {
              locked: false
            }
          }
        });
    },1000)

});
