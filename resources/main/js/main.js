var $ = jQuery.noConflict();
// Settings and Variables
var bgRunning = false;
var bgTimer;
var menuTimer;
var subMenuTimer;
var pageLoading=false;
var myAudio;
var btnSound;
var animateMenuPosition = true;
var muteAudioChangedBy = '';
var muteAudioChangedStatus = '';
var showBgCaption = true;
var audioSupport = true;
var bgImagesMove = false;
var bgImagesInProsses = false;
var useFullImage = false;
var useFitMode = false;
var ytplayer;
var ytPlayerReady = false;
var subThumbsActive = true;
var hasTouch = 'ontouchstart' in window;
var tempbgPaused;
var tempThumbs='';
var tempActive='';
var minWidth = 1100;
var minHeight = 500;
var firstPage = true;
var historySupport = false;
var mobileDevice = false;
if( navigator.userAgent.match(/Android/i) ||
 navigator.userAgent.match(/webOS/i) ||
 navigator.userAgent.match(/iPhone/i) ||
 navigator.userAgent.match(/iPad/i) ||
 navigator.userAgent.match(/iPod/i)
 ){
	mobileDevice = true;
}

function supports_history_api() {
  return !!(window.history && history.pushState);
}

function setHistoryLinks(targets){
	for(var i=0; i<targets.length; i++){
		$(targets[i]+' a[target!="_blank"]:not(.modal)').each(function(){
			$(this).click(function(event){
				event.preventDefault();
				openPage($(this).attr('href'), true);
			});
		});
	}
}

// Init after Loaded
$(window).bind('load', init);
function init(){

	if(supports_history_api())
		historySupport = true;
		
	if($.browser.msie && parseFloat($.browser.version) <= 7){
		$('#loading').html('Sorry, your browser is too old to display this new generation HTML5 web site :(');
		return false;
	}
	
	if(mobileDevice && videoSkipMobile){
		$('#bgImages li').each(function(){
			var mediaType = getMediaType($(this).find('a').attr('href'));
			if((mediaType=='youtube' || mediaType=='vimeo' || mediaType=='jwplayer' || mediaType=='flash') )
				$(this).remove();
		});
	}
	if(mobileDevice && menuAlwaysOpenMobile) menuAlwaysOpen = true;
	if(mobileDevice) ghostModeEnable = false;
	
	$(document).bind("fullscreenchange", fullscreenStateChanged);
	fullscreenStateChanged();
	
	if(twitterEnable) loadTweets();
	
	// Set deeplink
	if(!historySupport || !historyApiEnable){
		$.history.init(openPage);
		//setHistoryLinks(new Array('#menu-container', '#contentBox'));
	}else if(historySupport && historyApiEnable){
		setHistoryLinks(new Array('#menu-container', '#contentBox', '#contentBoxScroll'));
		window.onpopstate = function(event) {
		  openPage(document.location.href, false);
		};
		$('#closeButton').attr('href', defaultURL); 
		openPage('', false);
	}else{
		$('#closeButton').attr('href', defaultURL);
		openPage('', false);
	}
	
	// Dedect browser
	if(!document.createElement('audio').canPlayType)
	{
		$('.soundplaylist').hide();
		$('.soundiconBG').hide();
		$('.soundmuteBG').hide();
		audioSupport = false;
	}
	$(window).bind('resize', function() {
		doSize();
	});
	$(window).bind('scroll', function() {
		doSize();
	});
	if(mobileDevice){
		$('#thumbOpener').show().click(function(){
			if(parseInt($('#bgImages').css('bottom'))<30){
				$('#thumbOpener').animate({bottom:130}, 300);
				galeriThumbsMoveUp();
				$('#bgImages').bind('touchstart', bgThumbsTouchStart);
			}else{
				$('#thumbOpener').animate({bottom:45}, 300);
				$('#bgImages').unbind('touchstart', bgThumbsTouchStart);
				galeriThumbsMoveDown();
			}
		});
	}
	
	if(mobileDevice){
		menuPositionFixed = true;
		videoPaused = true;
		bgPatternV = 'none';
		$('#bgPattern').hide();
		
		$('#videoExpander').click(function(){
			if(activePlayer=='youtube' || activePlayer=='vimeo' || activePlayer == 'jwplayer'){
				window.location = '#[playvideo]';
			}
		});
		
	}
	
	if(!mobileDevice){
		$(document).bind('mousemove', galeriThumbsMouseMove);
		$(document).bind('mousemove', bgImageMove);
	}
	
	initMenu();
	doSize();
	
	/*$('#bodyLoading').animate({opacity:'0', top:-200}, 1000, 'easeOutBack', function(){
		$(this).remove();
		$('#body-wrapper').animate({opacity:'1'}, 1000);
	});*/
	$('#body-wrapper').animate({opacity:'1'}, 1000);
	
	setPlaylist();
	galleryThumbs();
	setScroll();
	
	if(isCanvasSupported()){
		var timecircleCanvas = document.getElementById('timecircle');
		timecircleCTX = timecircleCanvas.getContext('2d');
	}
	
	$('#currentItemNo').mouseenter(function(){
		$(this).stop().animate({'text-indent':-80}, 400);
		if(!bgPaused){
			$(this).append($('<div></div>').addClass('currentItemPaused'));
			$('.currentItemPaused').css({top:0, left:40}).animate({left:0}, 400);
		}else{
			$(this).append($('<div></div>').addClass('currentItemPlayed'));
			$('.currentItemPlayed').css({top:0, left:40}).animate({left:0}, 400);
		}
	}).mouseleave(function(){
		$(this).css('text-indent', '80px');
		$(this).stop().animate({'text-indent':0}, 400);
		$('.currentItemPaused').stop().animate({left:-40}, 400, function(){ $(this).remove(); });
		$('.currentItemPlayed').stop().animate({left:-40}, 400, function(){ $(this).remove(); });
	}).click(function(){
		if(bgPaused) {
			playBg();
			$('.currentItemPlayed').stop().animate({left:-40}, 400, function(){ $(this).remove(); });
			$(this).append($('<div></div>').addClass('currentItemPaused'));
			$('.currentItemPaused').css({top:0, left:40}).animate({left:0}, 400);
		}else{
			pauseBg();
			$('.currentItemPaused').stop().animate({left:-40}, 400, function(){ $(this).remove(); });
			$(this).append($('<div></div>').addClass('currentItemPlayed'));
			$('.currentItemPlayed').css({top:0, left:40}).animate({left:0}, 400);
		}
	});
	
	
	$('.btnCtrl, .tlCtrl, .btnBL, #itemNumbers, .headerText, .subText').each(function(){
		$(this).hover(function(){
			$(this).animate({opacity:'1'}, {duration:300});
		}, function(){
			$(this).animate({opacity:'0.5'}, {duration:300});
		});
	});
	
	if(ghostModeEnable){
		ghostModeMouseMove();
		$(document).bind('mousemove', ghostModeMouseMove);
	}
	
	$('.shareBL > .mBL, .videoBL > .mBL').hover(function(){
		hideFooterText();
		var blFirstWidth = $(this).parent().width();
		$(this).parent().css('width','auto');
		var blDivWidth = $(this).parent().width();
		$(this).parent().css('width', blFirstWidth+'px');
		$(this).parent().unbind('mouseenter', mBLover);
		$(this).parent().unbind('mouseleave', mBLout);
		$(this).parent().bind('mouseenter', {blDivWidth:blDivWidth}, mBLover);
		$(this).parent().bind('mouseleave', {blDivWidth:blDivWidth}, mBLout);
	}, function(){});
	
	$('.twtBL').hover(function(){
		hideFooterText();
		clearTimeout(twtTimer);
		nextTweet();
	}, function(){
		clearTimeout(twtTimer);
		showFooterText();
		$(this).delay(300).animate({width:40, 'opacity':'0.5'}, {duration:300, complete:function(){ //showFooterText(); 
		}});
	});
	
	$('.soundplaylist').hover(function(){
		if($('#playWrapper').is(':hidden'))
			$('#playWrapper').css({opacity:'0', right:'80px', top:($('.soundplaylist').offset().top-20)+'px'}).show();
		$('#playWrapper').show().stop(true).animate({top:$('.soundplaylist').offset().top, opacity:'0.5', right:80}, {duration:400, easing:'easeOutBack'});
	}, function(){
		$('#playWrapper').delay(300).animate({top:$('.soundplaylist').offset().top-20, opacity:'0'}, {duration:400, easing:'easeOutBack', complete:function(){
			$(this).hide();
		}});
	});
	
	$('#playWrapper').hover(function(){
		$('#playWrapper').stop(true).animate({top:$('.soundplaylist').offset().top, right:80, opacity:1}, {duration:400, easing:'easeOutBack'});
	}, function(){
		$('#playWrapper').delay(300).animate({top:$('.soundplaylist').offset().top-20, opacity:'0'}, {duration:400, easing:'easeOutBack', complete:function(){
			$(this).hide();
		}});
	});
	
	if($('#audioList ul li').length<1){
		$('.soundplaylist').hide();
		$('.soundiconBG').hide();
	}
	
	if(menuAlwaysOpen) openMainMenu();
}

function hideFooterText(){
	$('.footerText').stop(true,true).animate({width:20}, {queue:true, duration:300});
	$('.footerText span').stop(true,true).animate({opacity:0}, {queue:true, duration:300});
}

function showFooterText(){
	$('.footerText').css({width:'auto'});
	var footerTextW = $('.footerText').width();
	$('.footerText').css({width:'20px'});
	$('.footerText').delay(800).animate({width:footerTextW}, {queue:true, duration:300});
	$('.footerText span').delay(800).animate({opacity:1}, {queue:true, duration:300});
}

function mBLover(event){
	if($(this).width()<=40){
		$(this).stop(true).animate({width:event.data.blDivWidth, opacity:'1'}, {duration:300});
	}
}

function mBLout(event){
	showFooterText();
	$(this).delay(300).animate({width:40, opacity:'0.5'}, {duration:300, complete:function(){
	}});
}

function fullscreenStateChanged(){
	if($(document).fullScreen()!=null){
		if($(document).fullScreen()){
			$('.closeFullScrnBG').css('display', 'block');
			$('.setFullScrnBG').hide();
		}else{
			$('.closeFullScrnBG').hide();
			$('.setFullScrnBG').css('display', 'block');
		}
	}else{
		$('.closeFullScrnBG').hide();
		$('.setFullScrnBG').hide();
	}
}

var twtTimer;
var ii = 0;
function nextTweet(){
	ii++;
	hideFooterText();
	var addWidth = 100;
	if($('.twtList li.active').length>0)
	{
		if(!$('.twtList li.active').is(':last-child'))
			$('.twtList li.active').removeClass('active').next().addClass('active');
		else
			$('.twtList li.active').removeClass('active').parent().find('li:first-child').addClass('active');
	}else{
		$('.twtList li:first-child').addClass('active');
		$('.twtList li:not(.active)').hide();
	}
	var oldWidth = $('.twtList').parent().width();
	$('.twtList').parent().css('width', 'auto');
	var newWidth = $('.twtList li.active').width();
	$('.twtList').parent().css('width', (oldWidth)+'px');
	$('.twtList').parent().stop(true).animate({width:newWidth+addWidth, opacity:'1'}, 300);
	$('.twtList li:not(.active)').fadeOut('slow', function(){
		$('.twtList li.active').fadeIn('slow');
	});
	twtTimer = setTimeout(nextTweet, 5000);
}

// Loads the next tweets
function loadTweets(){
   var url = "https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name="+twitterUser+"&count="+twitterCount+"&callback=?";
   $.getJSON(url,function(data) {
		$.each(data, function(i, post) {
			$('.twtList').append($('<li>'+post.text+'</li>'));
		});
		if(data.length>0){
			$('.twtLoading').remove();
			$('.twtBL').show();
		}
   });
};

function ghostModeMouseMove(){
	if(ghost){
		if($('#bgText .headerText').text()!='')
			$('.headerText').stop(true).animate({opacity:'0.5'}, {queue:true, duration:500});
		if($('#bgText .subText').text()!='')
			$('.subText').stop(true).animate({opacity:'0.5'}, {queue:true, duration:500});
		$('.btnCtrl, .tlCtrl, .btnBL, #itemNumbers').stop(true).animate({opacity:'0.5'}, {queue:true, duration:500, complete:function(){
			if(!$('#playWrapper').is(':hidden'))
				$('#playWrapper').hide();
		}});
		$('#menu-container, #bgImages').stop(true).animate({opacity:'1'}, 500);
		$('.ghostModeActive').remove();
		ghost = false;
	}
	clearTimeout(ghostTimer);
	ghostTimer = setTimeout(gotoGhost, ghostModeTime);
}

var ghost = false;
var ghostTimer;
function gotoGhost(){
	var addtionalQuery = '';
	if(useFullImage)
		addtionalQuery += ', #bgImages';
	if($('#contentBoxContainer').html()=='')
		addtionalQuery += ', #menu-container';
	$('.btnCtrl, .tlCtrl, .btnBL, #itemNumbers, .headerText, .subText, #playWrapper '+addtionalQuery).stop(true).animate({opacity:'0'}, 500);
	if(ghostModeText)
		$('body').append($('<div class="ghostModeActive">Ghost Mode Active</div>').css({opacity:'0'}));
	$('.ghostModeActive').css({left:((winW-$('.ghostModeActive').width())/2)+'px', top:((winH-$('.ghostModeActive').height())/2)+'px'});
	$('.ghostModeActive').delay(500).animate({opacity:1}, {duration:500, complete:function(){
		$(this).delay(1000).animate({opacity:'0'}, {duration:500, complete:function(){ $(this).remove(); }});
	}});
	ghost = true;
}



jQuery.fn.extend({
	contentPageReady: function (fn) {
		if (fn) {
			return jQuery.event.add(document, "contentPageReady", fn, null);
		} else {
			var ret = jQuery.event.trigger("contentPageReady", null, document, false, null);
			if (ret === undefined)
				ret = true;
			return ret;
		}
	}
});

function bgThumbsTouchStart(e){
	var firstX;
	var event = window.event;
	if(hasTouch && event.touches.length==1)
		firstX = event.touches[0].pageX;
	$('#bgImages').bind('touchmove', {firstX:firstX}, bgThumbsTouchMove);
	$('#bgImages').bind('touchend', bgThumbsTouchEnd);
}
function bgThumbsTouchMove(e){
	var pX;
	var event = window.event;
	if(hasTouch && event.touches.length==1)
		pX = event.touches[0].pageX;
	var dX = parseInt($('#bgImages').position().left+pX-e.data.firstX);
	if(dX<$('#body-wrapper').width()-$('#bgImages').width())
		dX = $('#body-wrapper').width()-$('#bgImages').width();
	if(dX>0)
		dX=0;
	$('#bgImages').css({left:dX+'px'});
}
function bgThumbsTouchEnd(e){
	$('#bgImages').unbind('touchmove', bgThumbsTouchMove);
	$('#bgImages').unbind('touchend', bgThumbsTouchEnd);
}

/*Loading Animation*/
var contentLoadingLeft;
var cl;
function showLoading(){
	if(isCanvasSupported()){
		if(typeof(cl)=='undefined'){
			cl = new CanvasLoader('canvasloader-container');
			cl.setColor(rgb2hex($('#REF_ColorFirst').css('color')));
			cl.setShape('spiral');
			cl.setDiameter(30);
			cl.setDensity(48);
			cl.setRange(0.4);
			cl.setSpeed(4);
			cl.show();
		}
		$('#contentLoading').show().css({opacity:'0'});
		contentLoadingLeft = getContentLoadingLeft();
		$('#contentLoading').css({left:contentLoadingLeft, top:$('#content').position().top+280});
		$('#contentLoading').stop(true).animate({top:$('#content').position().top+80, opacity:'1'}, 500, 'easeOutQuad');
	}
}
function hideLoading(){
	if(isCanvasSupported()){
		contentLoadingLeft = getContentLoadingLeft();
		$('#contentLoading').stop(true).animate({top:$('#content').position().top-280, opacity:'0'}, 500, 'easeOutQuad', function(){
			$(this).hide();
		});
	}
}

function getContentLoadingLeft(){ return (winW-$('#contentLoading').width()-40)/2; };


/* Sub Thumb Gallery */
function galeriThumbsMouseMove(e)
{
	// Horizontal Move
	galeriThumbsHorizontalMove(e.pageX);
	// Vertical Move
	if(e.pageY > $('#bgImages').position().top-40 && parseInt($('#bgImages').css('bottom'))<32)
		galeriThumbsMoveUp();
	else if(e.pageY < $('#bgImages').position().top-40)
		galeriThumbsMoveDown();
}
function galeriThumbsHorizontalMove(param_pageX){
	if((parseInt($('#bgImages').css('bottom'))>-40 && $('#bgImages').width()>$('#body-wrapper').width())){
		var posTop = parseInt((($('#body-wrapper').width()-$('#bgImages').width())/$('#body-wrapper').width())*param_pageX);
		if(posTop>0)
			posTop=0;
		$('#bgImages').animate({left:posTop}, {queue:false, duration:400, easing:'easeOutQuad'});
	}
}
function galeriThumbsMoveUp(){
	$('#bgImages').animate({bottom:-12}, {queue:false, duration:300, easing:'easeOutQuad', complete:function(){ } } );
}
function galeriThumbsMoveDown(){
	$('#bgImages').animate({bottom:-92}, {queue:false, duration:300, easing:'easeOutQuad', complete:function(){ } } );
}

function bgImageMove(e){
	if(useFullImage && !useFitMode && activePlayer=='none')
	{
		if($('#body-wrapper').width()<$('#bgImageWrapper .new').width())
			var xPos = parseInt((($('#body-wrapper').width()-$('#bgImageWrapper .new').width())/$('#body-wrapper').width())*e.pageX);
		else
			var xPos = ($('#body-wrapper').width()-$('#bgImageWrapper .new').width())/2;
		if($('#body-wrapper').height()<$('#bgImageWrapper .new').height())
			var yPos = parseInt((($('#body-wrapper').height()-$('#bgImageWrapper .new').height())/$('#body-wrapper').height())*e.pageY);
		else
			var yPos = ($('#body-wrapper').height()-$('#bgImageWrapper .new').height())/2;
		$('#bgImageWrapper .new').animate({left:xPos, top:yPos}, {queue:false, duration:400, easing:'easeOutQuad'});
	}
}

function galleryThumbs(activeItem, mode){

	$('#bgImages li a').live('click',function(){
		return false;
	});
	
	var totalBgImagesWidth = 0;
	$('#bgImages').show();
	$('#bgImages li img.thumb').each(function(){
		totalBgImagesWidth+=$(this).width();
	});
	$('#bgImages').css('width', totalBgImagesWidth+'px');
	$('#bgImages').hide();
	
	$('#bgImages li').hover(function(){
			$(this).find('img.thumb').stop().animate({opacity:'1'}, 500);
			$(this).find('.thumbType').stop().animate({opacity:'1'}, 500);
	},function(){
		if(!$(this).hasClass('active')){
			$(this).find('img.thumb').stop().animate({opacity:'.3'}, 500);
			$(this).find('.thumbType').stop().animate({opacity:'.3'}, 500);
		}
	}).click(function(){
		if(!$(this).hasClass('active') && !bgRunning)
		{
			clearInterval(bgTimer);
			$('#bgImages li').removeClass('active');
			$(this).addClass('active');
			runBg();
		}
	});
	
	$('#bgImages li').each(function(){
		var mediaType = getMediaType($(this).find('a').attr('href'));
		//if(! ((mediaType=='youtube' || mediaType=='vimeo' || mediaType=='jwplayer' || mediaType=='flash') && mobileDevice && videoSkipMobile) )
		//{
			if(mediaType=='youtube' || mediaType=='vimeo' || mediaType=='jwplayer')
				$(this).append($('<div></div>').addClass('thumbType thumbVideo'));
			else if(mediaType=='flash')
				$(this).append($('<div></div>').addClass('thumbType thumbFlash'));
			else
				$(this).append($('<div></div>').addClass('thumbType thumbImage'));
		//}
	});
	
	if(activeItem==undefined){
		if($('#bgImages li.active').length!=1){
			$('#bgImages li').removeClass('active');
			$('#bgImages li:first-child').addClass('active');
		}
	}else{
		$('#bgImages li').removeClass('active');
		$('#bgImages li a[href="'+activeItem+'"]').parent().addClass('active');
		if($('#bgImages li.active').length!=1){
			$('#bgImages li').removeClass('active');
			$('#bgImages li:first-child').addClass('active');
		}
	}
	
	$('#bgImages').css('left','0px');

	setBgPlayStatus();
	if(mode==undefined)
		changeMode(false, false);
	else if(mode=='fit')
		changeMode(true, true);
	else if(mode == 'full')
		changeMode(true, false);
	runBg();
}

function showFullFitButtons(){
	if(activePlayer=='none' && useFullImage){
		if(useFitMode){
			$('.fitCenterBG').hide();
			$('.fullCenterBG').show();
		}else{
			$('.fitCenterBG').show();
			$('.fullCenterBG').hide();
		}
	}else{
		$('.fitCenterBG').hide();
		$('.fullCenterBG').hide();
	}
}

function changeMode(fullM, fitM){
	if(fitM==true)
		fullM=true
	
	if(!fullM){
		$('.fitBG').hide();
		$('.fullBG').show();
	}else{
		$('.fullBG').hide();
		$('.fitBG').show();
	}
	
	if(useFullImage!=fullM || fitM!=useFitMode)
	{
		useFullImage = fullM;
		useFitMode = fitM;
		
		var addC='';
		if(fullM){
			$('#bgImages').show().animate({opacity:1}, 500);
			if($('#contentBoxContainer').html()!='')
				addC = ', #content, #contentBoxScroll';
			if(bgPatternV!='none')
				addC += ', #bgPattern';
			$('#bgText, #bottomleft, #menu-container'+addC).animate({opacity:0}, 500);
			$('#fullControl').animate({opacity:1}, 500, function(){
				$('#bgPattern, #content, #menu-container, #bottomleft').hide();
				$('.infoBG').css('display','block');
				$('.infoBG').hover(function(){
					if($('#bgText .headerText').text()!='')
						$('#bgText .headerText').css({opacity:'0.5'});
					if($('#bgText .subText').text()!='')
						$('#bgText .subText').css({opacity:'0.5'});
					$('#bgText').stop().animate({opacity:'1'}, 300);
				}, function(){
					$('#bgText').stop().animate({opacity:'0'}, 300, function(){});
				});
				doSize();
			});
		}else{
			$('#bgImages').animate({opacity:0}, 500, function(){
				$(this).hide();
			});
			$('.fitCenterBG').hide();
			$('.fullCenterBG').hide();
			var addC = '';
			if($('#contentBoxContainer').html()!='')
				addC = ', #content, #contentBoxScroll';
			else
				$('#bgText').stop().animate({opacity:'1'}, 300);
			
			if(bgPatternV!='none')
				addC += ', #bgPattern';
			$('#menu-container, #bottomleft '+addC).show();
			$('.infoBG').hide();
			$('.infoBG').unbind('mouseover', 'mouseout', 'mouseenter', 'mouseleave');
			if(bgPatternV!='none')
				addC += ', #bgPattern';
			
			$('#fullControl').animate({opacity:0}, 500, function(){
				if(tempThumbs!=''){
					$('#bgImages').html(tempThumbs);
					$('#bgImage').html(tempActive);
					bgPaused = tempbgPaused;
					tempThumbs = '';
					tempActive = '';
					galleryThumbs();
					activePlayer='none';
					if($('#bgImage').find('#ytVideo').length>0)
						activePlayer = 'youtube';
					else if($('#bgImage').find('#vmVideo').length>0)
						activePlayer = 'vimeo';
					else if($('#bgImage').find('#jwVideo').length>0)
						activePlayer = 'jwplayer';
					else if($('#bgImage').find('#swfContent').length>0)
						activePlayer = 'flash';
				}
				doSize();
				$('#menu-container, #bottomleft '+addC).animate({opacity:1}, 500);
			});
		}
	}
	useFullImage = fullM;
	useFitMode = fitM;
	showFullFitButtons();
}

function setFullScrn(){
	$(document).fullScreen(true);
}

function closeFullScrn(){
	$(document).fullScreen(false);
}

function setFull(){
	changeMode(true, false);
}

function setMin(){
	changeMode(false, false);
}

function setFit(){
	changeMode(true, true);
}

function closeMainMenu(){
	if(menuAlwaysOpen) return false;
	if($.trim($('#contentBoxContainer').html())!='') return false;
	mainmenurunning = true;
	$('#mainmenuleft, #mainmenuright').css('overflow', 'hidden');
	$('#mainmenuleft').stop().animate({left:parseInt(parseInt(winW/2)), width:0}, {queue:true, duration:500, easing:'easeInQuad'});
	$('#mainmenuright').stop().animate({left:parseInt(winW/2), width:0}, {queue:true, duration:500, easing:'easeInQuad'});
	$('#logo').stop().delay(400).animate({opacity:.5}, {queue:true, duration:500, easing:'easeInQuad', complete:function(){ mainmenurunning=false; } });
}

var mainmenutimer;
var mainmenurunning = false;
// init menu
var menuHalfWidth = 510;
function initMenu(){
	showMenu();
	
	// Set Menu Position
	$('#logo').css({left: parseInt((winW-$('#logo').width())/2)+'px', opacity:.5});
	$('#mainmenuleft').css('left', (parseInt(winW/2)-$('#mainmenuleft').width())+'px');
	$('#mainmenuright').css('left', parseInt(winW/2)+'px');
	$('#mainmenuleft ul.menu').css('margin-right', (parseInt($('#logo').width()/2)+20)+'px');
	$('#mainmenuright ul.menu').css('margin-left', (parseInt($('#logo').width()/2)+20)+'px');
	$('#mainmenuright, #mainmenuleft').css('top', parseInt(($('#logo').height()-$('#mainmenuleft').height())/2)+'px');
	
	$('#mainmenuleft, #mainmenuright').css({overflow:'hidden', width:'0px'});
	$('#mainmenuleft').css('left',(parseInt(winW/2))+'px');
	
	$('#logo').mouseenter(function(){
		openMainMenu();
	});
	
	$('#mainmenuleft, #mainmenuright, #logo').mouseenter(function(){
		clearTimeout(mainmenutimer);
	});
	
	$('#mainmenuleft, #mainmenuright, #logo').mouseleave(function(){
		mainmenutimer =  setTimeout(closeMainMenu, 500);
	});
}

function openMainMenu(){
	//if(mainmenurunning) return false;
	mainmenurunning = true;
	if($('#mainmenuleft').width()==0 && $('#mainmenuright').width()==0){
		$('#mainmenuleft').css({left:parseInt(parseInt(winW/2))});
		$('#mainmenuright').css({left:parseInt(winW/2)});
	}
	$('#logo').stop().animate({opacity:1}, {queue:true, duration:500, easing:'easeOutQuad'});
	$('#mainmenuleft').stop().animate({left:parseInt(parseInt(winW/2)-menuHalfWidth), width:menuHalfWidth}, {queue:true, duration:700, easing:'easeOutQuad', complete:function(){ $(this).css('overflow', 'visible'); } });
	$('#mainmenuright').stop().animate({left:parseInt(winW/2), width:menuHalfWidth}, {queue:true, duration:700, easing:'easeOutQuad', complete:function(){ $(this).css('overflow', 'visible');  mainmenurunning=false; } });
}

function setBgPlayStatus(){
	if(!bgPaused){
		bgTimer = setInterval(nextBg, bgTime);
	}
}

// Resize All Elements
var winW = $(window).width();
var winH = $(window).height();
var contentWidth = 980;
function doSize(){
	winW = $(window).width();
	winH = $(window).height();
	var winRatio = winW/winH;
	$('#body-wrapper').css({width:winW+'px', height:winH+'px'});
	if(activePlayer!='none'){
		var mediaUrl = $('#bgImages li.active a').attr('href');
		var mediaParams = getParamsFromUrl(mediaUrl);
		imgWO = parseInt(mediaParams['width']);
		imgHO = parseInt(mediaParams['height']);		
	}else{
		var imgWO = parseInt($('#bgImage img.new').attr('width'));
		var imgHO = parseInt($('#bgImage img.new').attr('height'));
	}
	var imgRatio = imgWO/imgHO;
	var imgLeft=0;
	var imgTop=0;
	
	if((winRatio>imgRatio))
	{
		var imgW = parseInt(winW);
		var imgH = parseInt(imgW/imgRatio);
		
	}else{
		var imgH = winH;
		var imgW = parseInt(imgH*imgRatio);
	}
	
	if((winRatio>imgRatio))
	{
		var imgHF = parseInt(winH);
		var imgWF = parseInt(imgHF*imgRatio);
		
	}else{
		var imgWF = parseInt(winW);
		var imgHF = parseInt(imgWF/imgRatio);
	}
	
	// Set Bg Image W, H
	var newImageW = 0;
	var newImageH = 0;
	if(!useFullImage && bgStretch){
		newImageW = imgW;
		newImageH = imgH;
		if(activePlayer == 'youtube'){
			ytplayer.setSize(imgW, imgH);
		}
		else if(activePlayer == 'vimeo')
			$('#vimeoplayer').css({width:imgW+'px', height:imgH+'px'});
		else if(activePlayer == 'flash'){
			$('#swfWrapper, #swfWrapper object, #swfWrapper embed').css({width:imgW+'px', height:imgH+'px'});
		}
		else if(activePlayer == 'jwplayer')
			jwplayer('jwP').resize(imgW, imgH);
	}else{
		if(!useFullImage && !bgStretch){
			newImageW = imgWF;
			newImageH = imgHF;
		}else if(!useFitMode){
			newImageW = imgWO;
			newImageH = imgHO;
		}else{
			newImageW = imgWF;
			newImageH = imgHF;
		}
		
		if(activePlayer == 'youtube')
			ytplayer.setSize(winW, (winH-80));
		else if(activePlayer == 'vimeo')
			$('#vimeoplayer').css({width:winW+'px', height:(winH-80)+'px'});
		else if(activePlayer == 'flash'){
			$('#swfWrapper, #swfWrapper object, #swfWrapper embed').css({width:imgWO+'px', height:imgHO+'px'});
			newImageW = imgWO;
			newImageH = imgHO;
		}else if(activePlayer == 'jwplayer')
				jwplayer('jwP').resize(winW, (winH-80));
	}
	if($('#bgImages').width()<$('#body-wrapper').width()){
		$('#bgImages').css('left', (($('#body-wrapper').width()-$('#bgImages').width())/2)+'px');
	}
	
	if(useFullImage && !(activePlayer=='none' || activePlayer=='flash')){
		imgLeft = imgTop = 0;
	}else if(!useFullImage && !bgStretch && !(activePlayer=='none' || activePlayer=='flash')){
		imgLeft = imgTop = 0;
	}else{
		imgLeft = parseInt((winW-newImageW)/2);
		imgTop = parseInt((winH-newImageH)/2);
	}
	
	// Set Bg Image Position
	if(!bgRunning)
		$('#bgImage .new').stop(true).animate({left:imgLeft, top:imgTop, width:newImageW, height:newImageH}, {queue:false, duration: 500});
	else
		$('#bgImage .new').stop(true).css({left:imgLeft+'px', top:imgTop+'px', width:newImageW+'px', height:newImageH+'px'});
	
	// Set Pattern W, H
	$('#bgPattern').css({width:winW+'px', height:winH+'px'});
	$('#videoExpander').css({width:winW+'px', height:winH+'px'});
	setContentHeight();
	
	$('.btnCtrl').css('top', parseInt((winH-40)/2)+'px');
	$('.fitCenterBG, .fullCenterBG').css('left', parseInt((winW-40)/2)+'px');

	$('#logo').css({left: parseInt((winW-$('#logo').width())/2)+'px'});
	if($('#mainmenuleft').width()>0 || $('#mainmenuright').width()){
		$('#mainmenuleft').css({left:parseInt(parseInt(winW/2)-menuHalfWidth)});
		$('#mainmenuright').css({left:parseInt(winW/2)});
	}
	
	contentLoadingLeft = getContentLoadingLeft();
	$('#contentLoading').css({left:contentLoadingLeft});
	
	setScroll();
	fullscreenStateChanged();
}

function setContentHeight(){
	if(mobileDevice) contentWidth = 960;
	var conentTop = $('#mainmenuleft').position().top + $('#menu-container').position().top + $('#mainmenuleft').height()+40;
	$('#content').css({top:conentTop, left:((winW-contentWidth)/2-20)+'px', height:(winH-$('#footer').height()-120-conentTop)+'px'});
	$('#contentBoxScroll').css({top:conentTop, height:($('#content').height()+40)+'px', left:(((winW-contentWidth)/2)+contentWidth)+'px'});
	
	if($('#contentBoxContainer').height()<$('#content').height())
	{
		$('#content').css({height:$('#contentBoxContainer').height()+'px'});
		$('#contentBoxScroll').css({height:($('#content').height()+40)+'px'});
	}
	$('#contentBox').css({height:($('#content').height())+'px'});
	$('#contentBoxScroll .dragcontainer').height($('#contentBoxScroll').height()-60);
}
function setScroll(){
	$("#contentBoxScroll .dragger").unbind('mousedown', 'mouseup');
	if(hasTouch)
		$("#contentBox").unbind('touchstart');
	scrollMove();
	if($('#contentBoxContainer').height()>$('#contentBox').height())
	{	
		$('#contentBoxScroll .dragcontainer').show();
		$("#contentBoxScroll .dragger").bind('mousedown', setScrollMouseDown).mouseenter(function(){
			$(this).stop().animate({opacity:'.8'}, 300);
		}).mouseleave(function(){
			$(this).stop().animate({opacity:'1'}, 300);
		}); 
		
		if(hasTouch)
			$("#contentBox").bind('touchstart', setScrollMouseDown);
		
		$('#contentBox').mousewheel(function(event, delta) {
			scrollMove(delta);
			return false;
		});
		$('#contentBoxScrollDragger').parent().bind('mousedown', function(evt){
			$(this).find('.dragger').stop().animate({opacity:'.5'}, 300);
			var newpx = evt.pageY-$(this).offset().top-$(this).find('.dragger').height()/2;
			var sbah = $(this).height()-$(this).find('.dragger').height();
			if(newpx<0)
				newpx=0;
			if(newpx>sbah)
				newpx=sbah;
			$(this).find('.dragger').css('top', newpx+'px');
			scrollContentPosition($(this).find('.dragger'),'animate', newpx);
		});
	}else{
		$('#contentBox').unbind('mousewheel');
		$('#contentBoxScroll .dragcontainer').hide();
		scrollUnBinds();
	}
}

function rFalse(event){
	return false;
}

function setScrollMouseDown(s)
{
	if(typeof document.body.style.MozUserSelect!="undefined") //Firefox route
		document.body.style.MozUserSelect="none";
	var obj = $('#contentBoxScrollDragger');
	$(document).bind('selectstart dragstart', rFalse);
	if(!hasTouch)
		var startPositionY = $(obj).position().top;
	else
		var startPositionY = $(obj).offset().top;
	
	var event = window.event;
	if(hasTouch && event.touches.length==1){
		pointY = event.touches[0].pageY;
	}else{
		pointY = s.pageY;
	}
	
	var startMouseFirstY = pointY;
	$(obj).unbind('mousedown');
	$('#contentBox').unbind('touchstart', setScrollMouseDown); 
	$(document).bind('mouseup', setScrollMouseUp);
	$(document).bind('mousemove', {startPositionY:startPositionY, startMouseFirstY:startMouseFirstY}, setScrollMouseMove);
	
	if(hasTouch){
		$(document).unbind('touchmove', setScrollMouseMove);
		$(document).bind('touchmove', {startPositionY:startPositionY, startMouseFirstY:startMouseFirstY}, setScrollMouseMove);
		$(document).bind('touchend', setScrollMouseUp);
	}
}

function setScrollMouseMove(s){
	var obj = $('#contentBoxScrollDragger');
	$(this).find('.dragger').stop().animate({opacity:'.5'}, 300);
	
	var event = window.event;
	if(hasTouch && event.touches.length==1){
		s.preventDefault();
		pointY = event.touches[0].pageY;
	}else
		pointY = s.pageY
	
	if(!hasTouch)
		var drY = s.data.startPositionY + (pointY-s.data.startMouseFirstY);
	else
		var drY = $('#contentBoxScrollDragger').position().top - (pointY-s.data.startMouseFirstY);

	if(drY<0)
		drY=0;
	else if(drY>$(obj).parent().height()-$(obj).height())
		drY=$(obj).parent().height()-$(obj).height();
		
	$(obj).css({top:drY+'px'});
	scrollContentPosition(obj, 'direct', drY);
}

function scrollContentPosition(obj, aniType, dYPosition){ 
	if(dYPosition==null)
		var dY = $(obj).position().top;
	else
		var dY = dYPosition;
	var ch = $('#contentBoxContainer').height()-$('#contentBox').height();
	var sbah = $(obj).parent().height()-$(obj).height();
	var contentPos = (ch/sbah)*dY*-1;

	if(aniType=='animate')
		$('#contentBoxContainer').stop(true).animate({top:contentPos}, {queue:false, duration:300, easing:'easeOutQuad'} );
	else
		$('#contentBoxContainer').stop(true).css({top:contentPos+'px'});
}

function setScrollMouseUp(){
	scrollUnBinds();
	$('#contentBoxScrollDragger').bind('mousedown', setScrollMouseDown);
	if(hasTouch)
		$('#contentBox').bind('touchstart', setScrollMouseDown);
	$(this).find('.dragger').stop().animate({opacity:'1'}, 300);
}
function scrollUnBinds(){
	$(document).unbind('selectstart dragstart', rFalse);
	if(typeof document.body.style.MozUserSelect!="undefined") //Firefox route
		document.body.style.MozUserSelect="";
	$(document).unbind('mousemove', setScrollMouseMove);
	$(document).unbind('mouseup', setScrollMouseUp);
	if(hasTouch){
		$(document).unbind('touchemove', setScrollMouseMove);
		$(document).unbind('touchend', setScrollMouseUp);
	}
}

function scrollMove(dir){
	var movepx=0;
	var dragger = $('#contentBoxScrollDragger');
	
	var sbah = $(dragger).parent().height()-$(dragger).height();
	var ch = (($('#contentBoxContainer').height()-$('#contentBox').height())/sbah)*2;
	
	if(dir==undefined)
		movepx=0;
	else if(dir>0)
		movepx=(sbah/ch)*-1;
	else
		movepx=sbah/ch;
	var newpx = $(dragger).position().top + parseInt(movepx);
	if(newpx<=$(dragger).height()/2 && dir==undefined)
		newpx = 0;
	if(newpx>=(sbah-$(dragger).height()/2) && dir==undefined)
		newpx=sbah;
	if(newpx<0)
		newpx=0;
	if(newpx>sbah)
		newpx=sbah;
	newpx = parseInt(newpx);
	$(dragger).animate({top:newpx}, {queue:false, duration:300, easing:'easeOutQuad'} );
	scrollContentPosition(dragger, 'animate', newpx);
}

// Background Image Auto Next
function autoBg(){
	if(bgPaused) return false;
	nextBg();
}

// Background Image Next Button
function nextBg() {
	if(bgRunning) return false;
	clearInterval(bgTimer);
	if(!$('#bgImages li.active').is(':last-child')){
		$('#bgImages li.active').removeClass('active').next().addClass('active');
		runBg();
	}
	else if(loopBg){
		$('#bgImages li.active').removeClass('active').parent().find('li:first-child').addClass('active');
		runBg();
	}
}

// Background Image Prev Button
function prevBg(){
	if(bgRunning) return false;
	clearInterval(bgTimer);
	if(!$('#bgImages li.active').is(':first-child'))
		$('#bgImages li.active').removeClass('active').prev().addClass('active');
	else
		$('#bgImages li.active').removeClass('active').parent().find('li:last-child').addClass('active');
	runBg();
}

// Background Image Pause Button
function pauseBg(){
	clearInterval(timecircleTimer);
	if(isCanvasSupported()) timecircleCTX.clearRect (0,0,50,50);
	hideBgImageLoading();
	//pauseBgVideo();
	clearInterval(bgTimer);
	bgPaused = true;
	$('#bgImage img.new').stop();
}

// Background Image Play Button
function playBg(){
	clearInterval(bgTimer);
	bgPaused = false;
	if(activePlayer=='youtube' || activePlayer=='vimeo' || activePlayer=='jwplayer'){
		//playBgVideo();
	}else
		nextBg();
}

function pauseBgVideo(){
	if(activePlayer=='youtube')
		ytplayer.stopVideo();
	else if(activePlayer=='vimeo')
		$f(vmplayer).api('pause');
	else if(activePlayer=='jwplayer')
		jwplayer('jwP').pause();
	$('.pauseVideoBL').hide();
	$('.playVideoBL').show();
}

function playBgVideo(){
	if(activePlayer=='youtube')
		ytplayer.playVideo();
	else if(activePlayer=='vimeo')
		$f(vmplayer).api('play');
	else if(activePlayer=='jwplayer')
		jwplayer('jwP').play();
	$('.pauseVideoBL').show();
	$('.playVideoBL').hide();
}


function videoMute(){
	if(activePlayer=='youtube')
		ytplayer.mute();
	else if(activePlayer=='vimeo')
		$f(vmplayer).api('setVolume',0);
	else if(activePlayer=='jwplayer')
		jwplayer('jwP').setMute(true);
	videoMuted=true;
	setVideoMuteIcon();
}

function videoUnMute(){
	if(activePlayer=='youtube')
		ytplayer.unMute();
	else if(activePlayer=='vimeo')
		$f(vmplayer).api('setVolume',1);
	else if(activePlayer=='jwplayer')
		jwplayer('jwP').setMute(false);
	videoMuted=false;
	setVideoMuteIcon();
}

function setVideoMuteIcon(){
	if(activePlayer=='youtube' || activePlayer=='vimeo' || activePlayer=='jwplayer'){
		if(videoMuted){
			$('.soundmuteVideo').show();
			$('.soundiconVideo').hide();
		}else{
			$('.soundmuteVideo').hide();
			$('.soundiconVideo').show();
		}
	}else{
		$('.soundmuteVideo').hide();
		$('.soundiconVideo').hide();
	}
}

/*Youtube Api Begin*/ 
var tag = document.createElement('script');
tag.src = "http://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubePlayerAPIReady() {
	ytPlayerReady = true;
}
function onPlayerReady(event) {
	if(!videoPaused)
		event.target.playVideo();
	if(videoMuted)
		videoMute();
	else
		videoUnMute();
}
var done = false;
function onPlayerStateChange(event) {
	if(event.data==YT.PlayerState.ENDED && bgPaused==false)
		nextBg();
	else if(event.data==YT.PlayerState.ENDED && videoLoop)
		event.target.playVideo();
}
function stopVideo() {
	ytplayer.stopVideo();
}
/*Youtube Api End*/ 
  
/*Vimeo Api Begin*/
var vmPlayerReady=false;
var vmplayer;
function vimeoApiReady(player_id){
	vmplayer = player_id;
	vmPlayerReady = true;
	$f(vmplayer).addEvent('finish', vimeoVideoEnded);
	if(!videoPaused)
		$f(vmplayer).api('play');
	if(videoMuted)
		videoMute();
	else
		videoUnMute();
}
function vimeoVideoEnded(player_id){
	vmplayer = player_id;
	if(!bgPaused)
		nextBg();
	else if(videoLoop)
		$f(vmplayer).api('play')
}
/*Vimeo Api End*/  

function getParamsFromUrl(mediaURL){
	var params = new Array();
	var urlSections = mediaURL.split('/');
	var lastSection = urlSections[urlSections.length-1];
	var qmPosition = lastSection.indexOf('?');
	if(mediaURL.indexOf('?')>-1)
		params['vurl'] = mediaURL.substring(0, mediaURL.indexOf('?'));
	else
		params['vurl'] = mediaURL;
		
	if(qmPosition>-1){
		params['v'] = lastSection.substring(0, qmPosition);
		var queryString = lastSection.substring(qmPosition+1);
		var qsSections = queryString.split('&');
		for(var i=0; i<qsSections.length; i++){
			var keyValue = qsSections[i].split('=');
			if(keyValue[0]!=undefined)
				params[keyValue[0]] = keyValue[1];
		}
	}else{
		params['v'] = lastSection;
	}
	return params;
}

function getMediaType(mediaUrl){
	if (mediaUrl.indexOf('youtu.be')>-1 || mediaUrl.indexOf('youtube.com/watch')>-1)
		return 'youtube';
	else if(mediaUrl.indexOf('vimeo.com')>-1)
		return 'vimeo';
	else{
		var extensions = mediaUrl.split('.');
		if(extensions.length>1)
		{
			var qmPosition = extensions[extensions.length-1].indexOf('?');
			if(qmPosition>0)
				var le = extensions[extensions.length-1].substring(0, qmPosition);
			else
				var le = extensions[extensions.length-1]
			le = le.toLowerCase();
			
			if(le=='flv' || le=='f4v' || le=='m4v' || le=='mp4' || le=='mov')
				return 'jwplayer';
			else if(le=='swf')
				return 'flash';
			else
				return '';
		}else
			return '';
	}
}


function bgSoundMute(state){
	if(muteWhilePlayVideo && audioSupport){
		if(state)
			doMute();
		else if(muteAudioChangedBy==''){
			doUnMute();
		}else if(muteAudioChangedBy!=''){
			if(muteAudioChangedStatus=='mute')
				doMute();
			else if(muteAudioChangedStatus=='unmute')
				doUnMute();
		}
	}
}

// Background Image Animation
var activePlayer = 'none';
function runBg(){
	if($('#bgImages li').length<=0)	return false;
	
	activeNo = 0;
	$('#bgImages li').each(function(index, value){
		if($(this).hasClass('active'))
			activeNo = index+1;
	});
	
	if(activeNo<10)
		activeNo = '0'+activeNo;
	$('#currentItemNo').text(activeNo);
	totalCount = $('#bgImages li').length
	if(totalCount<10)
		totalCount = '0'+totalCount;
	$('#totalItemCount').text(totalCount);
	$('#bgImageWrapper .source').removeClass('new').addClass('old');
	var mediaUrl = $('#bgImages li.active a').attr('href');
	if(getMediaType(mediaUrl)=='youtube' || getMediaType(mediaUrl)=='vimeo' || getMediaType(mediaUrl)=='jwplayer' || getMediaType(mediaUrl)=='flash'){
	
	clearInterval(timecircleTimer);
	if(isCanvasSupported() && typeof(timecircleCTX) != 'undefined') timecircleCTX.clearRect (0,0,50,50);
	
	$('.pauseVideoBL').show();
	$('.playVideoBL').hide();
	
		if(getMediaType(mediaUrl)=='youtube')
		{
			bgSoundMute(true);
			var mediaParams = getParamsFromUrl(mediaUrl);
			if(ytPlayerReady)
			{
				activePlayer = 'youtube';
				$('#bgImageWrapper').prepend($('<div id="ytVideo"><div id="ytVideoPlayer"></div></div>').addClass('new').addClass('source').css('opacity','0'));
				ytplayer = new YT.Player('ytVideoPlayer', {
				  height: mediaParams['height'],
				  width: mediaParams['width'],
				  videoId: mediaParams['v'],
				  playerVars: {
					controls: 1,
					showinfo: 0 ,
					modestbranding: 1,
					wmode: 'opaque'
				},
				  events: {
					'onReady': onPlayerReady,
					'onStateChange': onPlayerStateChange
				  }
				});
			}
		}
		else if(getMediaType(mediaUrl)=='vimeo'){
			bgSoundMute(true);
			var mediaParams = getParamsFromUrl(mediaUrl);
			activePlayer = 'vimeo';
			$('#bgImageWrapper').prepend($('<div id="vmVideo"></div>').addClass('new').addClass('source').css('opacity','0'));
			$('#vmVideo').append($('<iframe width="'+mediaParams['width']+'" height="'+mediaParams['height']+'" src="http://player.vimeo.com/video/'+mediaParams['v']+'?api=1&amp;title=0&amp;byline=0&amp;portrait=0&autoplay=0&loop=0&controls=1&player_id=vimeoplayer" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>').attr('id', 'vimeoplayer'));
			$('#vmVideo iframe').each(function(){
				$f(this).addEvent('ready', vimeoApiReady);
			});
		}else if(getMediaType(mediaUrl)=='jwplayer'){
			bgSoundMute(true);
			var mediaParams = getParamsFromUrl(mediaUrl);
			activePlayer = 'jwplayer';
			$('#bgImageWrapper').prepend($('<div id="jwVideo"><div id="jwP"></div></div>').addClass('new').addClass('source').css('opacity','0'));
			jwplayer('jwP').setup({
				flashplayer: themeURL+'/jwplayer/player.swf',
				autostart: ((videoPaused)?false:true),
				skin: themeURL+'/jwplayer/glow/glow.xml',
				file: mediaParams['vurl'],
				height: mediaParams['height'],
				width: mediaParams['width'],
				events: {
					onComplete: function(event){
						if(bgPaused==false)
							nextBg();
						else if(videoLoop)
							jwplayer('jwP').play();
					}
				}
			 });
			 if(videoMuted)
				videoMute();
			else
				videoUnMute();
		}else if(getMediaType(mediaUrl)=='flash'){
			bgSoundMute(false);
			var mediaParams = getParamsFromUrl(mediaUrl);
			activePlayer = 'flash';
			$('#bgImageWrapper').prepend($('<div id="swfContent"><div id="swfWrapper" width="'+mediaParams['width']+'" height="'+mediaParams['height']+'"><p>You need to <a href="http://www.adobe.com/products/flashplayer/" target="_blank">upgrade your Flash Player</a> to version 10 or newer.</p></div></div>').addClass('new').addClass('source').css('opacity','0'));
			var flashvars = {};  
			var attributes = {};  
			attributes.wmode = "transparent";
			attributes.play = "true";
			attributes.menu = "false";
			attributes.scale = "showall";
			attributes.wmode = "transparent";
			attributes.allowfullscreen = "true";
			attributes.allowscriptaccess = "always";
			attributes.allownetworking = "all";					
			swfobject.embedSWF(mediaParams['vurl'], "swfWrapper", mediaParams['width'], mediaParams['height'], "10", themeURL+'/js/expressInstall.swf', flashvars, attributes);
			
			 if(videoMuted)
				videoMute();
			else
				videoUnMute();
		}
		if(mobileDevice)
			$('#videoExpander').show();
		
		if(getMediaType(mediaUrl)!='flash'){
			$('.videoBL').show();
			if(!ghost)
				$('.videoBL').animate({opacity:0.5}, {duration:300, queue:false});
			else
				$('.videoBL').css({opacity:0});
		}
		bgRunning = true;
		clearInterval(bgTimer);
		doSize();
		
		runBgAni();
	}else{
		$('.videoBL').animate({opacity:0.5}, {duration:300, queue:false, complete:function(){
			$(this).hide();
		}});
		bgSoundMute(false);
		activePlayer = 'none';
		bgRunning = true;
		showBgImageLoading();
		$('#bgImageWrapper').prepend($('<img src="'+$('#bgImages li.active a').attr('href')+'" />').addClass('new source').css('opacity','0'));
		$('#bgImageWrapper img.new').load(function(){
			$(this).css('opacity', '0');
			$(this).attr('width', $(this).width());
			$(this).attr('height', $(this).height());
			doSize();
			clearInterval(bgTimer);
			hideBgImageLoading();
			runBgAni();
		}).error(function(){
			bgRunning = false;
			hideBgImageLoading();
			nextBg();
		}).dequeue();
		if(mobileDevice)
			$('#videoExpander').hide();
		setVideoMuteIcon();
	}
	
	
}

var bgImageLoadTimer;
var bgImageLoadingRunning = false;
function showBgImageLoading(){
	if(isCanvasSupported()) bgImageLoadTimer = setInterval(drawBgImageLoading, 40);
	bgImageLoadingRunning = true;
}
function hideBgImageLoading(){
	clearInterval(bgImageLoadTimer);
	if(isCanvasSupported()) timecircleCTX.clearRect (0,0,50,50);
	bgImageLoadingRunning = false;
}

var drawBgImageLoaderStep = 0;
function drawBgImageLoading(){
	if(isCanvasSupported()){
		drawBgImageLoaderStep +=15;
		if(drawBgImageLoaderStep>360)
			drawBgImageLoaderStep-=360;
		timecircleCTX.clearRect (0,0,50,50);
		timecircleCTX.strokeStyle=$('#REF_ColorSecond').css('color');
		timecircleCTX.lineWidth = 4;
		timecircleCTX.beginPath();
		timecircleCTX.arc(25, 25, 21, Math.PI*(drawBgImageLoaderStep/180) , Math.PI*((drawBgImageLoaderStep-45)/180), true);
		timecircleCTX.stroke();
	}
}


function runBgAni(){
	showFullFitButtons();
	clearInterval(bgTimer);
	$('#bgText .subText').stop(true).animate({opacity:0}, 800 , 'easeOutQuad');
	$('#bgText .headerText').stop(true).animate({opacity:0}, 800 , 'easeOutQuad', function(){
		
		$('#bgText .headerText, #bgText .subText').css('width', 'auto');
		
		$('#bgText .headerText').html($('#bgImages li.active h3').text());
		if($('#bgImages li.active h3').text()!=''){
			var headerTextW = $('#bgText .headerText').width();
			$('#bgText .headerText').css({width:'0px', overflow:'hidden'});
			$('#bgText .headerText').animate({opacity:1, width:headerTextW}, {queue:true, duration:500, easing:'easeOutQuad', complete:function(){
				$(this).css({overflow:'auto', width:'auto'});
				$(this).animate({opacity:0.5}, {queue:true, duration:500, easing:'easeOutQuad'});
			}});
		}
		
		$('#bgText .subText').html($('#bgImages li.active p').text());
		if($('#bgImages li.active p').text()!=''){
			var subTextW = $('#bgText .subText').width();
			$('#bgText .subText').css({width:'0px', overflow:'hidden'});
			$('#bgText .subText').delay(400).animate({opacity:1, width:subTextW}, {queue:true, duration:500, easing:'easeOutQuad', complete:function(){
				$(this).css({overflow:'auto', width:'auto'});
				$(this).animate({opacity:0.5}, {queue:true, duration:500, easing:'easeOutQuad'});
			}});
		}
	});
	
	$('#bgImages li img').stop().animate({opacity:'.4'},500);
	$('#bgImages li.active img').stop().animate({opacity:'1'},500);
	if($('#bgImageWrapper .old').length>0)
	{
		$('#bgImageWrapper .old').stop(true).animate({opacity:0}, 500, function(){
			$(this).remove();
			bgRunning = false;
		});
	}else{bgRunning = false;}
	
	if(!NormalFade){
		$('#bgImageWrapper .new').css('opacity', '1');
		if(activePlayer=='none' && !useFullImage){
			var beforeAniLeft = $('#bgImageWrapper .new').css('left');
			$('#bgImageWrapper .new').css('left', '-'+$('#bgImageWrapper .new').width()+'px');
			$('#bgImageWrapper .new').animate({left:beforeAniLeft},600, 'easeOutQuad');
		}
	}else{
		$('#bgImageWrapper .new').css('opacity', '0');
			$('#bgImageWrapper .new').animate({opacity:'1'},600, 'easeOutQuad');
	}
	clearInterval(timecircleTimer);
	bgTimeCurrent = 0;
	setBgTimer();
}

function setBgTimer(){
	if(bgTime>0 && bgPaused==false && activePlayer == 'none'){
		timecircleTimer = setInterval(timecircle, 100);
		bgTimer = setInterval(autoBg, bgTime);
		bgTimeCurrent = 0;
	}else{
		clearInterval(timecircleTimer);
		bgTimeCurrent = 0;
	}
}

var timecircleTimer, bgTimeCurrent;
function timecircle(){
	if(!bgImageLoadingRunning && isCanvasSupported()){
		bgTimeCurrent += 100;
		timePer = bgTimeCurrent/bgTime;
		timecircleCTX.clearRect (0,0,50,50);
		timecircleCTX.strokeStyle=$('#REF_ColorSecond').css('color');
		timecircleCTX.lineWidth = 4;
		timecircleCTX.beginPath();
		timecircleCTX.arc(25, 25, 21, (Math.PI*2*timePer) - (Math.PI/2) , (Math.PI/2)*-1, true);
		timecircleCTX.stroke();
	}
}

bie9 = false;
vie8 = false;
if ($.browser.msie && parseInt($.browser.version.substr(0,1))==8) vie8 = true;
// Open Inner Page
function openPage(getURL, reload){
	if(typeof reload == 'undefined')
		reload = false;
	subMenuDoClose($('ul.menu'));
	if ($.browser.msie && parseInt($.browser.version.substr(0,1))<9) bie9 = true;
	// Page Loading on Click
	if(mobileDevice){
		if(getURL=='#[playvideo]'){
			if(activePlayer=='youtube' || activePlayer=='vimeo' || activePlayer == 'jwplayer'){
				$('#bgText, #bgImages, #topRight, #videoExpander, #thumbOpener, #content, #contentBoxScroll').hide();
				if(activePlayer=='jwplayer')
					jwplayer('jwP').play();
			}
			return false;
		}else if(activePlayer=='youtube' || activePlayer=='vimeo' || activePlayer == 'jwplayer'){
			if($('#topRight').is(':hidden'))
			{
				$('#bgText, #bgImages, #topRight, #videoExpander, #thumbOpener, #content, #contentBoxScroll').show();
				if(activePlayer=='youtube')
					ytplayer.stopVideo();
				else if(activePlayer=='vimeo')
					$f(vmplayer).api('pause');
				else if(activePlayer=='jwplayer')
					jwplayer('jwP').stop();
				var htmldata = $('#bgImageWrapper').html();
				$('#bgImageWrapper').html('');
				$('#bgImageWrapper').html(htmldata);
			}
		}
	}
	if(getURL.substr(0,1)== '/')  getURL = getURL.substr(1,getURL.length);
	
	if(getURL=='')
		getURL='/';
	if(pageLoading || getURL=='' || getURL.indexOf('gallery[')>-1 || getURL.substr(0,1)=='#') return false;
	//if(historySupport && historyApiEnable){
		var hasindex = getURL.indexOf('#');
		if(hasindex>-1){
			getURL = getURL.substr(0,hasindex);
		}
	//}
	var pageLoadingURL = $.trim(getURL);
	
	pageLoading = true;
	$(document).unbind('contentPageReady');
	$('#contentBoxContainer').error(function(){
		alert('page not found');
		pageLoading = false;
	});

	if(typeof _gaq != 'undefined'){
		var suburl = pageLoadingURL;
		if(suburl=='/' || suburl == '//') suburl = '';
		suburl = window.location.pathname+suburl;
		_gaq.push(['_trackPageview', suburl]);
	}
	
	//history.pushState(null, null, pageLoadingURL);
	
	if($('#contentBoxContainer').html()=='')
	{
		if(frontPage!='' && pageLoadingURL=='/'){
			pageLoading = false;
			showBgCaption = true;
			//if(!bie9) $('title').html(defaultTitle);
			setShareURL(defaultURL);
			closeMainMenu();
		}else if(!(pageLoadingURL=='/' || pageLoadingURL=='//')){
			showLoading();
			$('#contentBoxContainer').load(pageLoadingURL+addionalCharacter(pageLoadingURL)+'info=page', pageLoadReady);
			$.ajax({'url':pageLoadingURL+addionalCharacter(pageLoadingURL)+'info=title', type:'post', udata:pageLoadingURL, ureload:reload}).done(titleOnLoaded);
			setShareURL(pageLoadingURL);
		}else{
			pageLoading = false;
			showBgCaption = true;
			//if(!bie9) $('title').html(defaultTitle);
			setShareURL(defaultURL);
			closeMainMenu();
		}
	}else{
		$('#contentBoxScroll').animate({opacity:'0', marginTop:-200}, 600, 'easeOutExpo');
		$('#content').animate({opacity:'0', marginTop:-200}, 600, 'easeOutExpo', function(){
			$('#content, #contentBoxScroll').hide();
			if(!(pageLoadingURL=='/' || pageLoadingURL=='//')){
				showLoading();
				$('#contentBoxContainer').load(pageLoadingURL+addionalCharacter(pageLoadingURL)+'info=page', pageLoadReady);
				$.ajax({'url':pageLoadingURL+addionalCharacter(pageLoadingURL)+'info=title', type:'post', udata:pageLoadingURL, ureload:reload}).done(titleOnLoaded);
				setShareURL(pageLoadingURL);
			}else{
				if($.trim($('#contentBoxContainer').html())!='' && pageLoadingURL=='/' && firstPage){
					showLoading();
					pageLoaded();
				}else{
					$('#contentBoxContainer').html('');
					//if(!bie9) $('title').html(defaultTitle);
					setShareURL(defaultURL);
					pageLoading = false;
					showBgCaption = true;
					closeMainMenu();
				}
			}
			setCaptionPosition();
		});
	}
	setCaptionPosition();
	return false;
}

function titleOnLoaded(response, status, xhr){
	if(status!='error'){
		if(historySupport && historyApiEnable){
			if(this.ureload)
				history.pushState(null, response, this.udata);
		}
		if(!$.browser.msie)
			$('title').html(response);
	}
}

function pageLoadReady(response, status, xhr){
	if(status=='error')
		$('#contentBoxContainer').html(response);
	pageLoading = false;
	var imageTotal = $('#contentBoxContainer img').length;
    var imageCount = 0;
	if(imageTotal>0)
	{
		$('#contentBoxContainer img').load(function(){
			if(++imageCount == imageTotal){
				pageLoaded();
				return true;
			}
		}).error(function(){
			if(++imageCount == imageTotal){
				pageLoaded();
				return true;
			}
		});
	}else{
		pageLoaded();
	}
}

// Inner Page Loaded Actions
function pageLoaded(){
	firstPage = false;
	hideLoading();
	if($.trim($('#contentBoxContainer').html())=='') return false;

	jQuery.event.trigger("contentPageReady", null, document, false, null);	
	showBgCaption = false;
	setCaptionPosition();
	pageLoading = false;
	
	openMainMenu();
	
	$('#content').show().css({opacity:'1'});
	
	if(historySupport && historyApiEnable)
		setHistoryLinks(new Array('#contentBox'));
	
	$('#contentBoxScroll').show().css({opacity:'0', marginTop:'200px'});
	$('#content').show().css({opacity:'0', marginTop:'200px'});
		setContentHeight();
		$('#contentBoxScrollDragger').css('top', '0px');
		setScroll();
	$('#content, #contentBoxScroll').stop(true).delay(500).animate({opacity:'1', marginTop:0}, 600, 'easeOutExpo');
	$('#contentBoxContainer').css('top', '0px');
	$('#contentBoxScrollDragger').css('top', '0px');
	
	$('#contentBox a').mouseover(function(){
		if(audioSupport){
			btnSound.play();
		}
	});
	
	if(jQuery.isFunction(acp_initialise)) 
		acp_initialise();
	
	// Set click sound to all links
	$('#contentBox .blogTop a').click(function(){
		$('#content').stop().animate({scrollTop:0}, 1000, 'easeOutExpo');
	});
	
	// Toggle Button
	$('div.sh_toggle_text').click( function(){
		$(this).parent().find(".sh_toggle_content").slideToggle("slow");
			$(this).toggleClass("sh_toggle_text_opened");
		}
	); 
	
	setImageModal(); 
	
	// Set Tips
	$('#contentBox .tip').hover(function(){
		if($(this).attr('tips-id')==undefined)
			$(this).attr('tips-id', 'tips-'+randomString(5));
		var tipsID = $(this).attr('tips-id');
		if($('#'+tipsID).length==0){
			var pos = $(this).position();
			$('#contentBoxContainer').append($('<div id="'+tipsID+'" class="meta-tips">'+$(this).attr('rel')+'<span><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="10" height="10"><polygon points="0,0 10,0 10,10" /></svg></span></div>'));
			$('#'+tipsID).css({top:(pos.top-$('#'+tipsID).height()-21)+'px', opacity:'0', left:(pos.left-$('#'+tipsID).width()-20+$(this).width()/2)+'px'});
		}
		$('#'+tipsID).stop().delay(100).animate({opacity:'1'});
	}, function(){
		var tipsID = $(this).attr('tips-id');
		$('#'+tipsID).stop().delay(100).animate({opacity:'0'}, function(){
			$(this).remove();
		});
	});
	
	setImageAnimations();
	
	// Form Focus
	$('#contentBox .dform input[type=text], #contentBox .dform select, #contentBox .dform textarea').focus(function(){
		$(this).parent().addClass('dFormInputFocus');
	}).blur(function(){
		$(this).parent().removeClass('dFormInputFocus');
	});
	
	// Button Animation
	$('#contentBox .buttonSmall, #contentBox .buttonMedium').hover(function(){
		$(this).stop().animate({opacity:'.50'}, 400);
	}, function(){
		$(this).stop().animate({opacity:'1'}, 400);
	});
	
	var $applications = $('#contentBox .portfolioitems');
	var $data = $applications.clone();
	
	$('#contentBox .portfolioFilter li a').click(function(e) {
		$(this).parent().parent().find('a').removeClass('selected');
		$(this).addClass('selected');
	
		var dataValue = $(this).parent().attr('data-value');
		if (dataValue=='all'){
			var $filteredData = $data.find('li');
		} else {
			var $filteredData = $data.find('li[data-type~="cat-' + dataValue + '"]');
		}

		// finally, call quicksand
		$('.hoverWrapper, .hoverWrapper a').hide();
		$applications.quicksand($filteredData, {
		  duration: 800,
		  easing: 'easeInOutQuad',
		  enhancement: function(){ 
			setImageModal();
			setImageAnimations();
			}
		}, function(){
			//
		});
	});
	
	if(historySupport && historyApiEnable){
		$('#searchform').unbind('submit').attr('onsubmit','');
		$('#searchform').submit(function(){
			openPage(defaultURL+'/?s='+$('.searchbox').val(), true);
			return false;
		});
	}
	
	$("#contentBox").fitVids();
	
	// First Load FlexSlider
	applyFlexSlider('#contentBox .flexslider');
	
}

/* Flex Slider */
function applyFlexSlider(target){
	$(target).flexslider();
	$(target+" .flex-control-nav, "+target+" .flex-direction-nav").css("opacity","0");
	$(target).hover(function(){
		$(this).find(".flex-control-nav, .flex-direction-nav").animate({opacity:"1"}, 300);
	},
	function(){
		$(this).find(".flex-control-nav, .flex-direction-nav").animate({opacity:"0"}, 300);
	});
}

function setImageModal(){
	var modalid = randomString(5);
	$('#contentBox .image_frame a img').not('.nomodal').parent().attr('rel','gallery[photo'+modalid+']');
	$('#contentBox a[rel^="gallery["]').not('.nomodal').click(function(){
		if(tempThumbs=='')
			tempThumbs = $('#bgImages').html();
		if(tempActive=='')
			tempActive = $('#bgImage').html();
		tempbgPaused = bgPaused;
		pauseBg();		
		$('#bgImages li').remove();
		ytplayer = null;
		$('#contentBox a[rel="'+$(this).attr('rel')+'"]').not('.nomodal').each(function(){
			var addCaption = '';
			var addDescription = '';
			if($.trim($(this).find('img').attr('title'))!='')
				addCaption = '<h3>'+$.trim($(this).find('img').attr('title'))+'</h3>';
			if($.trim($(this).find('img').attr('alt'))!='')
				addDescription = '<p>'+$.trim($(this).find('img').attr('alt'))+'</p>';
			
			var mediaType = getMediaType($(this).attr('href'));
			if(! ((mediaType=='youtube' || mediaType=='vimeo' || mediaType=='jwplayer' || mediaType=='flash') && mobileDevice && videoSkipMobile) )
				$('#bgImages').append($('<li><a href="'+$(this).attr('href')+'"><img class="thumb" src="'+$(this).find('img').attr('src')+'" /></a>'+addCaption+addDescription+'</li>'));
		});
		galleryThumbs($(this).attr('href'), 'fit');
		return false;
	});
}

function setImageAnimations(){
	// Image Animation
	$('#contentBox .image_frame a img').each(function(){
		// Set First Position and Size for Image Hover
		if(vie8) $(this).parent().find('.disk1, .disk2').css('opacity', '0.5');
		$(this).parent().find('.hoverWrapperBg').css({width:$(this).width()+'px', height:$(this).height()+'px', opacity:'0'});
		$(this).parent().find('.hoverWrapper').css({width:$(this).width()+'px', height:$(this).height()+'px'});
		$(this).parent().find('.hoverWrapper h3, .hoverWrapper .enter-text').css({opacity:'0'});
		$(this).parent().find('.hoverWrapper span').css({opacity:'0'});
		$(this).parent().find('.hoverWrapper span').hover(function(){
			$(this).animate({backgroundPosition:'-40px 0'}, 300);
		}, function(){
			$(this).animate({backgroundPosition:'0 0'}, 300);
		});
		$(this).parent().find('.hoverWrapper span.hoverWrapperLink').click(function(event){
			event.preventDefault();
			event.stopImmediatePropagation();
			if(historySupport && historyApiEnable)
				openPage($(this).attr('rel'), true);
			else
				window.location = $(this).attr('rel');
			return false;
		});
		$(this).parent().click(function(event){
			event.stopPropagation();
		});
		// Set Image Hover Animation
		if(!mobileDevice){
			$(this).parent().parent().hover(imageAniHover, imageAniHout);
		}else{
			$(this).parent().click(function(event){
				if(parseInt($(this).parent().find('.hoverWrapper span.link').css('opacity'))==1){
					
				}else{
					event.preventDefault();
					event.stopImmediatePropagation();
					imageAniHover(event, this);
					return false;
				}
			});
		}
	});
}
function imageAniHover(event, obj){
	obj = (obj==undefined)?this:obj;
	event.stopPropagation();
	$(obj).find('.hoverWrapperModal').stop().delay(500).animate({opacity:'1', right:'20'}, 200 );
	$(obj).find('.hoverWrapperLink').stop().delay(700).animate({opacity:'1', right:'20'}, 200);
	$(obj).find('.hoverWrapperBg').stop().css({opacity:'1'});
	var lside = $(obj).find('.hoverWrapperBg').height();
	if($(obj).find('.hoverWrapperBg').width()>$(obj).find('.hoverWrapperBg').height())
		lside = $(obj).find('.hoverWrapperBg').width();
	$(obj).find('.disk1').css('width', parseInt(lside*1.5)+'px');
	$(obj).find('.disk1').css('height', parseInt(lside*1.5)+'px');
	$(obj).find('.disk2').css('width', parseInt(lside*1)+'px');
	$(obj).find('.disk2').css('height', parseInt(lside*1)+'px');
	$(obj).find('.disk1').stop().css({left:($(obj).find('.disk1').width()*-1)+'px', top:$(obj).find('.hoverWrapperBg').height()+'px'});
	$(obj).find('.disk1').stop().animate({left:0, top:($(obj).find('.hoverWrapperBg').height()-$(obj).find('.disk1').height())}, 500, 'easeOutQuad');
	$(obj).find('.disk2').stop().css({left:($(obj).find('.hoverWrapperBg').width())+'px', top:'-'+$(obj).find('.disk2').height()+'px'});
	$(obj).find('.disk2').stop().animate({left:($(obj).find('.disk2').width()/3*-1), top:($(obj).find('.hoverWrapperBg').height()-($(obj).find('.disk2').height()/3))}, 500, 'easeOutQuad');
	
	$(obj).find('.hoverWrapper span').animate({backgroundPosition:'0px 0'}, 300);
}
function imageAniHout(event, obj){
	obj = (obj==undefined)?this:obj;
	event.stopPropagation();
	$(obj).find('.hoverWrapperModal').stop().animate({opacity:'0', right:'0'}, 200);
	$(obj).find('.hoverWrapperLink').stop().delay(100).animate({opacity:'0', right:'0'}, 200);
	$(obj).find('.disk1').stop().animate({left:$(obj).find('.hoverWrapperBg').width(), top:($(obj).find('.disk1').height()*-1)}, 500, 'easeOutQuad');
	$(obj).find('.disk2').stop().animate({left:($(obj).find('.disk2').width()*-1), top:($(obj).find('.hoverWrapperBg').height())}, 500, 'easeOutQuad', function(){
		$(obj).find('.hoverWrapperBg').stop().css({opacity:'0'});
		$(obj).find('.hoverWrapper span').animate({backgroundPosition:'0px 0'}, 300);
	});
};


function subMenuDo(obj){
	clearTimeout(subMenuTimer);
	if(typeof(obj)!='undefined'){
		if($(obj).parent().find('> ul').length>0){
			subMenuDoOpen($(obj).parent());
		}else{
			subMenuDoClose($(obj).parent().parent());
		}
	}else{
		subMenuDoClose($('ul.menu'));
	}
}

function subMenuDoOpen(obj){
	$(obj).find('> ul').show();
	$(obj).find('> ul >li').each(function(i,n){
		$(this).stop(true).delay(i*50).animate({opacity:'1', left:0, top:0}, 300, 'easeOutQuad');
	});
	subMenuDoClose($(obj).parent(), $(obj).attr('id'));
}
function subMenuDoClose(obj, except){
	var subquery = 'ul'
	if(typeof(except)!='undefined') subquery = 'li:not([id='+except+']) > ul';
	$(obj).find(subquery).each(function(){
		var lasti = $(this).find('> li').length-1;
		$(this).find('> li').each(function(i,n){
			if(i!=lasti)
				$(this).stop(true).delay(i*50).animate({opacity:'0', left:40, top:20}, 300, 'easeOutQuad');
			else
				$(this).stop(true).delay(i*50).animate({opacity:'0', left:40, top:20}, 300, 'easeOutQuad', function(){
					$(this).parent().hide();
				});
		});
	});
}



// Main Menu Item over Animation
function menuItemOver(obj){
	clearTimeout(menuTimer);			
	if(audioSupport){
		btnSound.play();
	}
}

// Main Menu Show Animation
function showMenu(){
	$('#mainmenuleft').mouseenter(function(){ subMenuDoClose('#mainmenuright ul'); });
	$('#mainmenuright').mouseenter(function(){ subMenuDoClose('#mainmenuleft ul'); });

	$('ul.menu li').each(function(i,el){
		$(el).find('> a').hover(function(event){
			clearTimeout(mainmenutimer);
			subMenuDo(this);
			menuItemOver(this);
		}, function(){
			subMenuTimer = setTimeout(subMenuDo, menuTime);
		});
	});
}

function setCaptionPosition(){
	if(showBgCaption)
		$('#bgText').stop().animate({opacity:'1'}, 500, 'easeOutQuad');
	else
		$('#bgText').stop().animate({opacity:'0'}, 500, 'easeOutQuad');
}

/*Time Bar*/
function playerBarMouseDown(event){
	$(document).bind('selectstart dragstart', rFalse);
	var firstX = event.pageX-$('#playerBar').offset().left;
	setBarPosition(firstX);
	$(document).bind('mousemove', {pageX:event.pageX, firstWidth:firstX}, playerMouseMove);
	$(document).bind('mouseup', playerMouseUp);
	$('#playerBar').unbind('mousedown', playerBarMouseDown);
}
function playerMouseMove(event){
	var newWidth = event.data.firstWidth+(event.pageX-event.data.pageX);
	if(newWidth<0)
		newWidth=0;
	if(newWidth>$('#playerBar').width())
		newWidth=$('#playerBar').width();
	
	setBarPosition(newWidth);
}
function playerMouseUp(event){
	$(document).unbind('selectstart dragstart', rFalse);
	$(document).unbind('mousemove', playerMouseMove);
	$(document).unbind('mouseup', playerMouseUp);
	$('#playerBar').bind('mousedown', playerBarMouseDown);
}
function setBarPosition(barX){
	if(!myAudio.paused){
		var posW=parseInt((myAudio.duration/$('#playerBar').width())*barX);
		myAudio.currentTime = posW;
	}
}

/*Volume Bar*/
function volumeBarMouseDown(event){
	$(document).bind('selectstart dragstart', rFalse);
	var firstX = event.pageX-$('#volumeBar').offset().left;
	setVolumeBarPosition(firstX);
	$(document).bind('mousemove', {pageX:event.pageX, firstWidth:firstX}, volumeMouseMove);
	$(document).bind('mouseup', volumeMouseUp);
	$('#volumeBar').unbind('mousedown', volumeBarMouseDown);
}
function volumeMouseMove(event){
	var newWidth = event.data.firstWidth+(event.pageX-event.data.pageX);
	if(newWidth<0)
		newWidth=0;
	if(newWidth>$('#volumeBar').width())
		newWidth=$('#volumeBar').width();
	
	setVolumeBarPosition(newWidth);
}
function volumeMouseUp(event){
	$(document).unbind('selectstart dragstart', rFalse);
	$(document).unbind('mousemove', volumeMouseMove);
	$(document).unbind('mouseup', volumeMouseUp);
	$('#volumeBar').bind('mousedown', volumeBarMouseDown);
}
function setVolumeBarPosition(barX){
	var posW=(1/$('#volumeBar').width())*barX;
	myAudio.volume = posW;
}

/*Audio Functions*/
function setPlaylist(){
	if(audioSupport)
	{
		myAudio = new Audio();
		var audioTagSupport = !(myAudio.canPlayType);
		{
			$(myAudio).bind('timeupdate', function(){
				var rem = parseInt(myAudio.duration - myAudio.currentTime, 10),
				activeWidth = (myAudio.currentTime / myAudio.duration)*$('#playerBar').width(),
				volWidth = (myAudio.volume / 1)*$('#volumeBar').width(),
				Dmins = Math.floor(parseInt(myAudio.duration,10)/60,10),
				Dsecs = parseInt(myAudio.duration,10) - Dmins*60;
				Cmins = Math.floor(parseInt(myAudio.currentTime,10)/60,10),
				Csecs = parseInt(myAudio.currentTime,10) - Cmins*60;
				$('#playerBarActive').css('width', activeWidth+'px');
				$('#volumeBarActive').css('width', volWidth+'px');
				if( !(isNaN(Cmins) || isNaN(Csecs)) )
					$('#playerSongDuration .current').html(Cmins+':'+(Csecs>9?Csecs:'0'+Csecs));
				else
					$('#playerSongDuration .current').html('');
				if( !(isNaN(Dmins) || isNaN(Dsecs)) )
					$('#playerSongDuration .total').html(' / '+Dmins+':'+(Dsecs>9?Dsecs:'0'+Dsecs));
				else
					$('#playerSongDuration .total').html('');
			});
			$('#playerBar').bind('mousedown', playerBarMouseDown);
			$('#volumeBar').bind('mousedown', volumeBarMouseDown);
			
			$('#playerController .pause').click(function(){
				if(myAudio.duration>0)
				{
					myAudio.pause();
					$('#playerController .pause').hide();
					$('#playerController .play').show();
				}
				return false;
			});
			$('#playerController .play').click(function(){
				if(myAudio.duration>0)
				{
					myAudio.play();
					$('#playerController .pause').show();
					$('#playerController .play').hide();
					return false;
				}
			});
			$('#playerController .stop').click(function(){
				if(myAudio.duration>0)
				{
					myAudio.pause();
					myAudio.currentTime=0;
					$('#playerController .play').show();
					$('#playerController .pause').hide();
				}
				return false;
			});
			$('#playerController .loop').click(function(){
				loop = false;
				$('#playerController .loop').hide();
				$('#playerController .nextsong').show();
			});
			$('#playerController .nextsong').click(function(){
				loop = true;
				$('#playerController .loop').show();
				$('#playerController .nextsong').hide();
			});

			$('.soundiconBG, #playerController .unmute').click(doMute);
			$('.soundmuteBG, #playerController .mute').click(doUnMute);
			
			btnSound = new Audio();
			var canPlayMp3 = !!btnSound.canPlayType && "" != btnSound.canPlayType('audio/mpeg');
			if(canPlayMp3)
				btnSound.src = btnSoundUrlMp3;
			else
				btnSound.src = btnSoundUrlOgg;
			
			$('a').mouseover(function(){
				btnSound.play();
			});
			
			if(autoPlay){
				playAudio($('#audioList li:first-child'), 'auto');
			}else{
				$('#playerController .pause').hide();
			}
			if(loop)
				$('#playerController .nextsong').hide();
			else
				$('#playerController .loop').hide();
		}
	}
	$('#audioList ul li').click(function(){
		playAudio(this, 'direct');
	});
}

function doUnMute(e){
	if(e!=undefined){
		muteAudioChangedBy = e.target.nodeName;
		muteAudioChangedStatus = 'unmute';
	}
	myAudio.muted = false;
	if($('#audioList ul li').length>0){
		$('.soundiconBG').css('display', 'block');
		$('.soundmuteBG').hide();
	}
	$('#playerController .mute').hide();
	$('#playerController .unmute').show();
}
function doMute(e){
	if(e!=undefined){
		muteAudioChangedBy = e.target.nodeName;
		muteAudioChangedStatus = 'mute';
	}
	myAudio.muted = true;
	if($('#audioList ul li').length>0){
		$('.soundiconBG').hide();
		$('.soundmuteBG').css('display', 'block');
	}
	$('#playerController .mute').show();
	$('#playerController .unmute').hide();
}

// Play Background Audio
function playAudio(obj, type){
	
	if(audioSupport){
		var isPlaying = !myAudio.paused;
		var canPlayMp3 = !!myAudio.canPlayType && "" != myAudio.canPlayType('audio/mpeg');
		var canPlayOgg = !!myAudio.canPlayType && "" != myAudio.canPlayType('audio/ogg; codecs="vorbis"');
		if(canPlayMp3)
			myAudio.src = $(obj).attr('data-mp3');
		else if(canPlayOgg)
			myAudio.src = $(obj).attr('data-ogg');
		
		$('#playerSongName').text($(obj).text());

		myAudio.removeEventListener('ended', arguments.callee, false);
		myAudio.addEventListener('ended', audioAddEndedListener , false);
		
		
		if(autoPlay || isPlaying || type=='direct')
		{
			$(obj).parent().find('li').removeClass('active');
			$(obj).addClass('active');
			myAudio.play();
			$('#playerController .pause').show();
			$('#playerController .play').hide();
		}else{
			$('#playerController .play').show();
			$('#playerController .pause').hide();
		}
	}
}
function audioAddEndedListener() 
{
	if(loop){
	this.currentTime = 0;
	this.play();
	}else{
		this.removeEventListener('ended', arguments.callee, false);
		if(!$('#audioList li.active').is(':last-child'))
			$('#audioList li.active').removeClass('active').next().addClass('active');
		else
			$('#audioList li.active').removeClass('active').parent().find('li:first-child').addClass('active');
		playAudio($('#audioList li.active'), 'auto');
		myAudio.addEventListener('ended', audioAddEndedListener, false);
	}
}

// Randoma string generator
function randomString(size) {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var randomstring = '';
	for (var i=0; i<size; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}
function isCanvasSupported(){
  var elem = document.createElement('canvas');
  return !!(elem.getContext && elem.getContext('2d'));
}
function addionalCharacter(pageLoadingURL){
	if(pageLoadingURL.indexOf('/')>0){
		files = pageLoadingURL.split('/');
		pageName = files[files.length-1];
	}else{
		pageName = pageLoadingURL;
	}
	if(pageName.indexOf('?')>'-1')
		return '&';
	else
		return '?';
}

// Addional wp
function setShareURL(shareurl){
	if(defaultURL != shareurl)
		shareurl=defaultURL+'/'+shareurl;
	shareurl = shareurl.replace('/#!', '');
	$('.shareBL a:not(.mOpener)').each(function(){
		if($(this).attr('rel'))
			$(this).attr('href', $(this).attr('rel').replace('%%url%%', shareurl));
	});
}

//Function to convert hex format to a rgb color
var hexDigits = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
function rgb2hex(rgb){
	rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
	return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}
function hex(x){  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];  }

