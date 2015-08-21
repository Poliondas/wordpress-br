jQuery(function ($) {
    jQuery.fn.MKGrade = function (a) {

        var config = {
            elementScroll: $(window),
            attrFoto: 'data-foto',
            dirFoto: ''
        };

        if (a) {
            $.extend(config, a)
        }

        return this.each(function () {

            var $container = $(this);
            var $fotos = $container.find(".item .foto");
            var $fotosScroll = $fotos;
            var iWindowH;

            config.elementScroll.on('scroll', function () {
                handleScroll();
            });

            $(window).on('resize', function () {
                autoAjuste();
            });

            $container.find(".item .bt-swap-foto").on('click', function () {
                var $this = $(this);
                var $item = $this.parents('.item').eq(0);
                $item.toggleClass('visivel-2');
            });

            autoAjuste();

            //----- Função de ajuste
            function autoAjuste() {
                iWindowH = config.elementScroll.height();
                handleScroll();
            }
            //----- FIM: autoAjuste
            //----- Função de ajuste específico da página
            function handleScroll() {
                var documentScrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                var iLimitTop = iWindowH + documentScrollTop;

                if ($fotosScroll.length > 0) {

                    $fotosScroll.each(function (i) {
                        var $this = $fotosScroll.eq(i);

                        if (!$this.hasClass('loaded')) {
                            if ($this.offset().top - iLimitTop <= iWindowH) {
                                loadImg($this);
                            }
                        }

                        if (!$this.hasClass('visivel')) {
                            if ($this.offset().top - iLimitTop <= 0) {
                                $this.addClass('visivel');
                            }
                        }
                    })

                    $fotosScroll = $fotosScroll.filter(':not(.visivel.loaded)');

                }

            }
            //----- FIM: handleScroll

            //----- Função que carrega uma imagem

            function loadImg($img) {
                if (!$img.hasClass('loaded')) {
                    var sDataFoto = $img.attr(config.attrFoto);
                    var img = document.createElement('img');
                    var dir = config.dirFoto;
                    var url = dir + sDataFoto;

                    img.onload = function () {
                        $img
                                .css({"background-image": "url(" + url + ")"})
                                .addClass('loaded');
                    }
                    img.src = url;
                }
            }
            //----- FIM: pageScript

        })
    }


    $(".galeria-grade .social .bt").on('click', function(){
        console.log('.galeria-grade .social .bt (click)')
        var $this = $(this);
        var $item = $this.parent().parent().find('.foto');

        var rede = $this.attr('data-rede');
        var foto = $item.attr('data-foto');
        var url = $item.attr('data-share');

        shareFoto(rede,foto,url);
    })


});
