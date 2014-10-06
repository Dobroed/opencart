<section class="flexslider">
<ul class="slides">
   <?php foreach ($banners as $banner) { ?>
    <?php if ($banner['link']) { ?>
    <li>
      <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
    </li>
    <?php } else { ?>
    <li>
      <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
    </li>
    <?php } ?>
    <?php } ?>
  </ul>
  
</section>
<script type="text/javascript">
 /*  $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "fade"
  });
});*/
    
    
    $(function(){
    if (($.browser.msie) && ($.browser.version < 10)) {
        $('.flexslider').flexslider({
            animation: "slide",
            slideshow: true,
            slideshowSpeed: 7000,
            animationDuration: 600,
            prevText: "Назад",
            nextText: "Вперед",
            controlNav: true
        });   
    } else {
        $('.flexslider').flexslider({
            animation: "fade",
            slideshow: true,
            slideshowSpeed: 7000,
            animationDuration: 600,
            prevText: "Назад",
            nextText: "Вперед",
            controlNav: true
        }); 
    }
});
    
  </script>