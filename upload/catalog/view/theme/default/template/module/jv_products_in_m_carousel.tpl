<?php if ($products) { ?>

	<div class="box <?php echo $adding_class_to_box; ?>" <?php if ( isset($adding_id_to_box) && !empty($adding_id_to_box) ) { ?>  id="<?php echo $adding_id_to_box; ?>" <?php } ?> >
	
	  <div class="box-heading"><?php echo $heading_title; ?></div>
	  <div class="box-content">
		<div id="mycarousel<?php echo $module; ?>">
		  <ul class="jcarousel-skin-opencart">		
			<?php foreach ($products as $product) { ?>
			<li>
				<div class="box-product">  
				  <div style="margin-bottom: 0px; margin-right: 0px;">
					<?php if ($product['thumb']) { ?>
					<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
					<?php } ?>
					<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
					<?php if ($product['price']) { ?>
					<div class="price">
					  <?php if (!$product['special']) { ?>
					  <?php echo $product['price']; ?>
					  <?php } else { ?>
					  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
					  <?php } ?>
					</div>
					<?php } ?>
					<?php if ($product['rating']) { ?>
					<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
					<?php } ?>
					<div class="cart"><a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><span><?php echo $button_cart; ?></span></a></div>
				  </div>
				</div>  
			</li>
			<?php } ?>
		  </ul>
		</div>
	  </div>
	</div>

	<?php if ($carousel_autoscroll == '0') { ?>
		<script type="text/javascript"><!--
		jQuery(document).ready(function() {
			$('#mycarousel<?php echo $module; ?> ul').jcarousel({
				<?php if ( ($position == 'content_top') || ($position == 'content_bottom') ) { ?>
					vertical: false,
				<?php } else { ?>
					vertical: true,
				<?php } ?>
				
				scroll:<?php echo $scroll; ?>,
				
				<?php if ( $carousel_direction == 'carousel_direction_ltr' ) { ?>
					rtl: true,
				<?php } else { ?>
					rtl: false,
				<?php } ?>
				
				wrap: '<?php echo $carousel_wrap; ?>',
				
				auto: 0,
				
				animation: 800
			});
		});	
		//--></script>
	<?php } ?>

	<?php if ($carousel_autoscroll == '1') { ?>
		<script type="text/javascript"><!--
		jQuery(document).ready(function() {	
			$('#mycarousel<?php echo $module; ?> ul').jcarousel({
				<?php if ( ($position == 'content_top') || ($position == 'content_bottom') ) { ?>
					vertical: false,
				<?php } else { ?>
					vertical: true,
				<?php } ?>
				
				scroll:<?php echo $scroll; ?>,
				
				<?php if ( $carousel_direction == 'carousel_direction_ltr' ) { ?>
					rtl: true,
				<?php } else { ?>
					rtl: false,
				<?php } ?>
				
				wrap: '<?php echo $carousel_wrap; ?>',
				
				auto: <?php echo $carousel_time_autoscroll; ?>,
				
				animation: 800,
				
				initCallback: mycarousel_initCallback
			});
		});		
		
		function mycarousel_initCallback(carousel)
		{
			// Disable autoscrolling if the user clicks the prev or next button.
			carousel.buttonNext.bind('click', function() {
				carousel.startAuto(0);
			});

			carousel.buttonPrev.bind('click', function() {
				carousel.startAuto(0);
			});

			// Pause autoscrolling if the user moves with the cursor over the clip.
			carousel.clip.hover(function() {
				carousel.stopAuto();
			}, function() {
				carousel.startAuto();
			});
		};
		//--></script>
	<?php } ?>

<?php } ?>	