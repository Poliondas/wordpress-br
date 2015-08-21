jQuery(function($){
	jQuery.fn.MKcycle=function(a){
		var config = {
				cssCustom:function(){},
				dragSensitivity:60,
				duration:'normal',
				ease:"",
				fx:"", 
				fxSequence:0,
				htmlPager: function(p){
					return "<a href='javascript:;'></a>"	;
				},
				onProgress: function(a,p,c){
				},
				next:null,
				pager:null,
				pauseOnHover:false,
				prev:null,
				slideExp:"",
				slideStart:0,
				specialEasing:'',
				timeout:0,
				useDrag:false,
				useKeys:false
			};
		if(a){
			$.extend(config,a)
		}
		return this.each(function(){
			//----- Declaração de variáveis
				var $container,$slides,$pager,$next,$prev;
				var cInterval;
				var numSlides, maxSlides;
				var slideAtual = config.slideStart;
				var slideNext = slideAtual;
				var aFx = ['custom','cover','coverVert','fade','fadeBoth','slideHorz','scrollHorz','slideDown','toss', 'zoomIn','zoomOut','zoomInOut', 'zoomOutIn'];
				var numFx,maxFx;
			//----- FIM: Declaração
			
			//----- Inicialização de variáveis
				$container = $(this)
				$container.addClass('mk-cycle');
				
				//----- Descobre e armazena as páginas na variável $slides
					findSlides();
				//----- FIM: findSlides
				
				//----- Atribui o css inicial para as páginas
					startSlides();
				//----- FIM: startSlides
				
				//----- Inicializa a paginação
					initPaginacao();
				//----- FIM: initPaginacao
				
				//----- Inicializa a transição por setas
					initKeys();
				//----- FIM: initKeys
				
				//----- Inicializa a transição pelos botões prev/next informados por parâmetro
					initButtons();
				//----- FIM: initButtons
				
				//----- Inicializa a pausa durante o evento de over
					initPause();
				//----- FIM: initPause
				
				//----- Inicializa o array de fxs
					initFx();
				//----- FIM: initFx
				
				//----- Inicializa a transição automática 
					initAutomaticTransition();
				//----- FIM: initAutomaticTransition
				
				//----- Inicializa a transição por drag
					initDrag();
				//----- FIM: initDrag
			//----- FIM
				
			//----- Seleciona os elementos correspondentes a cada página
				function findSlides(){
					if(config.slideExp == ""){config.slideExp = "> "+$(this).children()[0].tagName;}
                    $slides = $container.find(config.slideExp);
					$slides.addClass('slide');
                    
                    numSlides = $slides.length;
                    maxSlides = numSlides-1;
				}
			//----- FIM: findSlides
			
			//----- FIM: inicializa as paginas
				function startSlides(){
					$slides
						.css({position:"absolute",display:"none"})
						.eq(slideAtual)
						.css({display:"block"})
				}
			//----- FIM: startSlides
			
			//----- Inicializa a paginação
				function initPaginacao(){
					if(config.pager != null && config.pager != ''){
						$pager =  (typeof config.pager == 'string') ? $(config.pager) : config.pager;
						for(i=0;i<numSlides;i++){
							$pager.append(config.htmlPager({indice:i, slide:$pager.eq(i)}));
						}
						$pager
							.children()
							.addClass("pager-a")
							.off("touchstart mousedown")
							.on("touchstart mousedown",function(e){
								e.preventDefault();
								goto($(this).index())
							})
					}
					swapPaginacao();
				}
			//-----FIM: initPager
			
			//----- Atualiza o elemento em destaque na paginação
				function swapPaginacao(){
					if($pager){
						$pager
							.find(".pager-active")
							.removeClass("pager-active")
						$pager
							.find(".pager-a")
							.eq(slideNext)
							.addClass("pager-active")
					}
				}
			//----- FIM: swapPaginacao
			
			//----- Inicializa o slide por setas
				function initKeys(){
					if(config.useKeys){
						$(document).off('keyup').on("keyup",function(e){
							if(e.keyCode == 39 || e.keyCode == 40){next();}
							if(e.keyCode == 37 || e.keyCode == 38){prev();}
						})
					}
				}
			//----- FIM: initKeys
			
			//----- Inicializa o slide  por botões next/prev
				function initButtons(){
					if(config.prev != null){
						$prev =  (typeof config.prev == 'string') ? $(config.prev) : config.prev;
						$prev.off("touchstart mousedown").on("touchstart mousedown",function(e){
							e.preventDefault();
							prev();
						});
					}
					if(config.next != null){
						$next =  (typeof config.next == 'string') ? $(config.next) : config.next;
						$next.off("touchstart mousedown").on("touchstart mousedown",function(e){
							e.preventDefault();
							next();
						});
					}
				}
			//----- FIM: initButtons
			
			//----- Inicializa a pausa quando o mouse está sobre um slide
				function initPause(){
					if(config.pauseOnHover){
						$slides.off('mouseenter').on('mouseenter',function(){
							clearInterval(cInterval);
						}).off('mouseleave').on('mouseleave',function(){
							initAutomaticTransition();
						})
					}
				}
			//----- FIM: initPause
			
			//----- Inicializa o array de fxs
				function initFx(){
					if(numSlides < 2){
						return;
					}
					var e = config.fx.split(',') ;
          if(e[0] == ''){
            e[0] = 'all';
            var msg = "'fx' não informado. \n"+
              "Para usar todos os 'fxs' use o valor 'all'. \n"+
              "Você pode escolher um ou mais 'fxs' dentre os existentes. \n"+
              "Informe os 'fxs' usando uma string separada por virgulas. \n"+
              "Os 'fxs' serão usados em sequencia. \n"+
              "Você pode definir onde a sequencia deve começar usando o atributo 'fxSequence:#' onde '#' é a posição do fx. \n"+
              "Você pode definir a sequencia como aleatória usando o atributo \"fxSequence:'random'\". \n"+
              "fxs disponíveis: \n ";
              
            console.warn(msg,aFx);
          }
					if(e[0] == 'all'){
						e = aFx.slice(1);
					}
          config.fx = e;
					numFx = config.fx.length;
					maxFx = numFx-1;
				}
			//----- FIM: initFx
			
			//----- Inicializa a transição automática caso o parâmetro timeout seja maior que 0;
				function initAutomaticTransition()	{
					if(config.timeout > 0){
						clearTimeout(cInterval);
						cInterval = setTimeout(next,config.timeout);
					}
				}
			//----- FIM: initAutomaticTransition
            
            //----- Para a transição automatica;
				function stopAutomaticTransition()	{
                    clearTimeout(cInterval);
				}
			//----- FIM: initAutomaticTransition
			
			//----- Inicializa a escuta do evento 'set'
				$container.off('set').on("set",function(e,o){
					switch(o.funcao){
						case "next": next(); break;
						case "prev": prev(); break;
						case "goto": goto(o.indice); break;
						default:
							console.log('Função não encontrada: '+o.funcao);
					}
				});
			//---- FIM: Set
			
			//----- Transição por arrasto
				function initDrag(){
					var isTouch = $('html').hasClass('touch');
					if(config.useDrag){
					//----- Marca o inicio de uma transição por mouse ou touch
						$slides.off("touchstart mousedown").on("touchstart mousedown",function(e){
							clearInterval(cInterval);
							e = e.originalEvent;
							if(!isTouch)
							{
								e.preventDefault();
							}
							e.stopPropagation();
							$container.data("start",true);
							$container.data("startX",e.pageX);
							//$container.data("startY",e.pageY);
						})
					//----- Marca o cancelamento de uma transição por mouse ou touch
						$(document).off("mouseup touchend touchcancel").on("mouseup touchend touchcancel",function(e){
							$container.data("start",false);
							initAutomaticTransition();
						})
					//----- Verifica se deve avançar ou retroceder
						$(document).off("mousemove touchmove").on("mousemove touchmove",function(e){
							if($container.data("start")){						
								
								e = e.originalEvent;
								var pX = parseInt($container.data("startX"));
								//var pY = parseInt($container.data("startY"));
								/*
								if(e.pageX > (pX+config.dragSensitivity) || e.pageY > (pY+config.dragSensitivity)){
									prev();
									$container.data("start",false);
								}
								if(e.pageX < (pX-config.dragSensitivity) || e.pageY < (pY-config.dragSensitivity)){
									next();
									$container.data("start",false);
								}
								*/
								if(e.pageX > (pX+config.dragSensitivity)){
									prev();
									$container.data("start",false);
								}
								if(e.pageX < (pX-config.dragSensitivity)){
									next();
									$container.data("start",false);
								}
							}
						})
				}
				}
			//----- FIM: initDrag
			
			//----- Atualiza as variáveis de transição e chama a função de slide
				function next(){
					slideNext = slideAtual+1;
					if(slideNext >= numSlides){slideNext=0;}
					slide(1);
				}
			//----- FIM: next
			
			//----- Atualiza as variáveis de transição e chama a função de slide
				function prev(){
					slideNext = slideAtual-1;
					if(slideNext < 0){slideNext=maxSlides;}
					slide(-1);
				}
			//----- FIM: prev
			
			//----- Atualiza as variáveis de transição e chama a função de slide
				function goto(_p){
					var p = Math.abs(_p) % numSlides;
					
					if(p != slideAtual){
						slideNext = p;
						if(p > slideAtual){
							slide(1);
						}else{
							slide(-1);
						}
					}
				}
			//----- FIM: goto
			
			//----- Posiciona os elementos e realiza o slide
				function slide(i){
					swapPaginacao(slideNext);

					var $pageN = $slides.eq(slideNext)
					var $pageA = $slides.eq(slideAtual)
                    
                    $slides.stop(true,true);
                    
                    stopAutomaticTransition();
					
					var fx = "";
					if(config.fxSequence == 'random'){
						var pos = Math.floor((Math.random()*(config.fx.length-1)));
						fx = config.fx[pos];
					}else{
						fx = config.fx[config.fxSequence];
						config.fxSequence = (config.fxSequence < maxFx) ? config.fxSequence+1 : 0;
					}
					fx = fx.trim();
					obj = new Object();
					obj={
						className: $container[0].className,
						fx: fx,
						id: $container[0].id,
						indiceAtual:slideAtual,
						indiceNext:slideNext,
						slideAtual: $pageA,
						slideNext: $pageN
					};
					
					var a = {};
					var b = {};
					switch(fx){
						case "slideHorz":
							a.inicio = {left:(i*100)+"%"};
							a.fim = {left:"0%"};
							b.inicio = {left:"0%"}
							b.fim = {left:(-i*100)+"%"}
							break;
						case "slideVert":
							a.inicio = {top:(i*100)+"%"};
							a.fim = {top:"0%"};
							b.inicio = {top:"0%"};
							b.fim = {top:(-i*100)+"%"};
							break;
						case "fade":
							a.inicio = {opacity:0,zIndex:2};
							a.fim = {opacity:1};
							b.inicio = {zIndex:1};
							b.fim = {}
							break;
						case "fadeBoth":
							a.inicio = {opacity:0,zIndex:2};
							a.fim = {opacity:1};
							b.inicio = {opacity:1, zIndex:1};
							b.fim = {opacity:0}
							break;
						case "scrollHorz":
							a.inicio = {left:(-i*100)+"%",zIndex:2};
							a.fim = {left:"0%"};
							b.inicio = {left:"0%",zIndex:1};
							b.fim = {left:(-i*100)+"%"}
						case "cover":
							a.inicio = {left:(i*100)+"%",zIndex:2};
							a.fim = {left:"0%"};
							b.inicio = {left:"0%",display:"block",zIndex:1};
							b.fim = {left:"0%"}
							break;
						case "slideDown":
							a.inicio = {"max-height":0,zIndex:2};
							a.fim = {"max-height":"100%"};
							b.inicio = {zIndex:1};
							b.fim = {zIndex:1};
							break;
						case "coverVert":
							a.inicio = {zIndex:2, top:(i*100)+"%"};
							a.fim = {top:"0%"};
							b.inicio = {zIndex:1};
							b.fim = {zIndex:1};
							break;
						case "toss":
							a.inicio = {opacity:1,zIndex:1,top:"0%",left:"0%"};
							a.fim = {}
							b.inicio = {opacity:1,zIndex:2,top:"0%",left:"0%"};
							b.fim = {top:"10%",left:(-i*10)+"%",opacity:0};
							break;
						case "zoomOut":
							a.inicio = {opacity:1,zIndex:1,top:"0%",left:"0%"};
							a.fim = {}
							b.inicio = {opacity:1,zIndex:2,top:"0%",left:"0%"};
							b.fim = {top:"30%",left:"30%",width:"40%",height:"40%",opacity:0};
							break;
						case "zoomIn":
							a.inicio = {top:"30%",left:"30%",width:"40%",height:"40%",opacity:0,zIndex:2};
							a.fim = {opacity:1,top:"0%",left:"0%",width:"100%",height:"100%"};
							b.inicio = {opacity:1,zIndex:1,top:"0%",left:"0%"};
							b.fim = {};
							break;
						case "zoomInOut":
						case "zoomOutIn":
							var i = (fx == 'zoomOutIn') ? -i : i;
							if(i > 0){
								a.inicio = {top:"30%",left:"30%",width:"40%",height:"40%",opacity:0,zIndex:2};
								a.fim = {opacity:1,top:"0%",left:"0%",width:"100%",height:"100%"};
								b.inicio = {opacity:1,zIndex:1,top:"0%",left:"0%"};
								b.fim = {};
							}else{
								a.inicio = {opacity:1,zIndex:1,top:"0%",left:"0%"};
								a.fim = {}
								b.inicio = {opacity:1,zIndex:2,top:"0%",left:"0%"};
								b.fim = {top:"30%",left:"30%",width:"40%",height:"40%",opacity:0};
							}
							break;
						case "custom":
							arr = config.customCss;
							a = arr.pageIn;
							b = arr.pageOut;
							break;
						default:
							$container.trigger("cycleError",obj)
							return;
							break;
					}
                    obj.customCss = {
                        pageIn:{
                            inicio:a.inicio,
                            fim:a.fim
                        },
                        pageOut:{
                            inicio:b.inicio,
                            fim:b.fim
                        }
                    }
					a.inicio.display = 'block';
					a.fim.display = 'block';
					b.inicio.display = 'block';
					b.fim.display = 'block';
					
					$pageN
						.css(a.inicio)
						.animate(a.fim,{
								duration:config.duration,
								easing:config.ease,
								specialEasing:config.specialEasing,
								progress:config.onProgress
							})
					$pageA
						.css(b.inicio)
						.animate(b.fim,{
								duration: config.duration,
								easing: config.ease,
								specialEasing:config.specialEasing,
								complete:function(){
									$pageA.css({display:"none",zIndex:"",opacity:"",width:"",height:"",top:"",left:""});
									$pageN.css({zIndex:""});
									slideAtual = slideNext;
									$container.trigger("cycleAfter",obj);
                                    initAutomaticTransition();
								}
						})

                    $container.trigger("cycleBefore",obj)
				}
		})
	}
})