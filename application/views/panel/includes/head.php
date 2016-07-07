

<meta charset="UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">




<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>css/estilos.css" media="all" />

<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>fonts/fonts.css" type="text/css">

<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>camera/camera.css" type="text/css">

<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>css/estilos.css" type="text/css">

<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>css/hover-button/demo-page.css">

<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>css/hover-button/hover.css">

<!-- animate -->

<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>css/animate.css">

<link rel="stylesheet" href="<?php echo base_url().PATH_RESOURCE_MAIN; ?>scroll-theme/jquery.mCustomScrollbar.css">

<!-- sharethis -->

<script type="text/javascript">var switchTo5x=true;</script>

<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>

<script type="text/javascript">stLight.options({publisher: "b243f16b-8744-4a45-a34b-84b246cf546a", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

<!--  -->

<script type='text/javascript' src='<?php echo base_url().PATH_RESOURCE_MAIN; ?>js/animated/wow.min.js'></script>

<!--  -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script type='text/javascript' src='<?php echo base_url().PATH_RESOURCE_MAIN; ?>scroll-theme/jquery.mCustomScrollbar.concat.min.js'></script>

<!--  -->

<script type='text/javascript' src='<?php echo base_url().PATH_RESOURCE_MAIN; ?>js/jquery-1.8.3.min.js'></script>

<script type='text/javascript' src='<?php echo base_url().PATH_RESOURCE_MAIN; ?>camera/jquery.mobile.customized.min.js'></script>

<script type='text/javascript' src='<?php echo base_url().PATH_RESOURCE_MAIN; ?>camera/jquery.easing.1.3.js'></script>

<script type='text/javascript' src='<?php echo base_url().PATH_RESOURCE_MAIN; ?>camera/camera.min.js'></script>

<script type='text/javascript' src="<?php echo base_url().PATH_RESOURCE_MAIN; ?>js/jquery.lbslider.js"></script>

<script type='text/javascript' src='<?php echo base_url().PATH_RESOURCE_MAIN; ?>js/cargar.js'></script>

<script>

    jQuery(function(){

        jQuery('#camera_wrap_4').camera({

            height: 'auto',

            loader: 'none',

            pagination: true,

            hover: false,

            opacityOnGrid: true,

            imagePath: '../images/',

            thumbnails: false,

            playPause: false,

            navigationHover: false,

            autoAdvance : true,

            autoAdvance: false

        });

    });

    // scroll

    (function($){

        $(window).load(function(){

            $("document ").mCustomScrollbar();

        });

    })(jQuery);

    // wow-animated



    new WOW().init();

</script>