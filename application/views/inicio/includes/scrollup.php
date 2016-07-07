		<div id="scrollUp"><img src="<?php echo base_url().PATH_RESOURCE_MAIN; ?>images/icon/icon_subir2.png" alt=""></div>
		<style>
			#scrollUp{
				position: fixed;
				bottom: 25px;
				right: 25px;
				/*width: 20px;*/
				/*height: 20px;*/
				cursor: pointer;
				display: none;
				z-index: 999;
			}
			#scrollUp img{
				width: 60px;
			}
		</style>
		<script>
			$(window).scroll(function(){
				if ($(this).scrollTop() > 100) {
					$('#scrollUp').fadeIn();
				} else {
					$('#scrollUp').fadeOut();
				}
			});

			$('#scrollUp').click(function(){
				$("html, body").animate({ scrollTop: 0 }, 1100);
				return false;
			});
		</script>