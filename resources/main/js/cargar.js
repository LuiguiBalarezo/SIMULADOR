$(document).ready(function(){
	var new_visible=0;
	$("body .view_menu > div").click(function(){
		$("nav").addClass("m_visible");
		$("body").addClass("body-overflow");
		$(".m_base_menu").fadeIn("slow");
		$("body .view_menu").css({"opacity":".2"});
	});
	$(".m_base_menu").click(function(){
		$("nav").removeClass("m_visible");
		$("body").removeClass("body-overflow");
		$(".m_base_menu").fadeOut("slow");
		$("body .view_menu").css({"opacity":"1"});
	});
	$(".link_traslate").on("click", function(evt){
		scroll_traslate=1;
		evt.preventDefault();
		traslate_section($(this).attr("href"));
	});
	$("#nosotros section.content a").on("click", function(evt){
		evt.preventDefault();
		traslate_section("#nosotros")
		if ($(window).width()>=1600){
			var href = $(this).attr("href");
			$("#nosotros section.content a[href!='"+href+"']").parent().addClass("ocultar");
			$("#nosotros section.list_content").addClass("mostrar");
			$(this).parent().addClass("agrandar");
			$("#nosotros > header, #nosotros > footer").fadeOut("slow",function(){
				$("#nosotros section.content article.agrandar").fadeOut(0);
			});
		}
		else{
			$('#nosotros > header, #nosotros section.content, #nosotros > footer').fadeOut(0);
			$('#nosotros section.list_content').fadeIn('slow');
		}
	});

	$("#nosotros section.list_content .cerrar a").on("click", function(evt){
		evt.preventDefault();
		traslate_section("#nosotros")
		if ($(window).width()>=1600){
			$("#nosotros section.content article.agrandar").fadeIn(0);
			$("#nosotros section.content article.ocultar").addClass("mostrar").removeClass("ocultar");
			$("#nosotros section.content article.agrandar").addClass("reducir").removeClass("agrandar");
			$("#nosotros section.list_content.mostrar").addClass("ocultar");
			$("#nosotros > header, #nosotros > footer").fadeIn("slow",function(){
				$("#nosotros section.content article.ocultar, #nosotros section.content article.mostrar, #nosotros section.list_content.mostrar, #nosotros section.list_content.ocultar").removeClass("ocultar mostrar");
				$("#nosotros section.content article.agrandar, #nosotros section.content article.reducir").removeClass("agrandar reducir");
				// $("#nosotros section.list_content.mostrar").addClass("ocultar").removeClass("mostrar");
			});
		}
		else{
			$('#nosotros section.list_content').fadeOut(0);
			$('#nosotros > header, #nosotros section.content, #nosotros > footer').fadeIn('slow');
		}
	});


	$(document).ready(function(){
		if ($(window).width()>=900) {
			jQuery('#entidades .slider').lbSlider({
				leftBtn: '.btnLeftA',
				rightBtn: '.btnRightA',
				visible: 1,
				autoPlay: true,
				autoPlayDelay: 3
			});
		}
	});

	function traslate_section(href){
		$('html, body').animate({
			scrollTop: $(href).offset().top
		}, 700,function(){
			scroll_traslate=0;
			$("nav").removeClass("m_visible");
			$("body").removeClass("body-overflow");
			$(".m_base_menu").fadeOut("slow");
			$("body .view_menu").css({"opacity":"1"});
		});
	}
});