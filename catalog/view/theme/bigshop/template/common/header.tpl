<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<meta name="HandheldFriendly" content="True" /><meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />

<link rel="stylesheet" type="text/css" href="catalog/view/theme/bigshop/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/theme/bigshop/js/modernizr.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/bigshop/js/jquery.easing-1.3.min.js"></script>
<!--<script src="http://code.jquery.com/jquery-migrate-git.js"></script>-->
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui.min.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/theme/bigshop/js/custom.js"></script>

<script type="text/javascript" src="catalog/view/theme/bigshop/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="catalog/view/theme/bigshop/js/cloud_zoom.js"></script>
<script type="text/javascript" src="catalog/view/theme/bigshop/js/respond.js"></script>

<script src="catalog/view/theme/bigshop/js/dimensions.js" type="text/javascript"></script>
<script src="catalog/view/theme/bigshop/js/autocomplete.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bigshop/stylesheet/autocomplete.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bigshop/stylesheet/dcverticalmegamenu.css" />
<script src="catalog/view/theme/bigshop/js/jquery.menu-aim.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(function(){
	    setAutoComplete("filter_name", "results", "getdata.php?q=");
	});
});
</script>

<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php

// Load custom.css

$filename = 'catalog/view/theme/bigshop/stylesheet/custom.css'; 

if (file_exists($filename)) { ?>
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/bigshop/stylesheet/custom.css" />
<?php } 

// If bigshop module is enabled

if($this->config->get('bigshop_status')== 1) {

	if($this->config->get('bigshop_title_font')!='' || $this->config->get('bigshop_body_font')!='' || $this->config->get('bigshop_small_font') != '' ) {
		
		$regfonts = array('Arial', 'Verdana', 'Helvetica', 'Lucida Grande', 'Trebuchet MS', 'Times New Roman', 'Tahoma', 'Georgia' );
		
		// Titles font
		if (in_array($this->config->get('bigshop_title_font'), $regfonts)==false) { 
			?><link href='//fonts.googleapis.com/css?family=<?php echo $this->config->get('bigshop_title_font') ?>&v1' rel='stylesheet' type='text/css'><?php 
		} // Body font
		if (in_array($this->config->get('bigshop_body_font'), $regfonts)==false) { 
			?><link href='//fonts.googleapis.com/css?family=<?php echo $this->config->get('bigshop_body_font') ?>&v1' rel='stylesheet' type='text/css'><?php 
		} // Small text font
		if (in_array($this->config->get('bigshop_small_font'), $regfonts)==false) { 
			?><link href='//fonts.googleapis.com/css?family=<?php echo $this->config->get('bigshop_small_font') ?>&v1' rel='stylesheet' type='text/css'>
	<?php 

		} 
	} 
?>
<style type="text/css">
body {  <?php if($this->config->get('bigshop_background_color')!='') {
?>  background-color: <?php echo $this->config->get('bigshop_background_color');
?>;
 <?php
}
 if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') $path_image = HTTPS_IMAGE;
 else $path_image = HTTP_IMAGE;
 if($this->config->get('bigshop_custom_image')!='') {
?>  background-image: url("<?php echo $path_image . $this->config->get('bigshop_custom_image') ?>");
 background-position: top center;
 background-repeat: no-repeat;
 <?php
}
else if($this->config->get('bigshop_custom_pattern')!='') {
?>  background-image: url("<?php echo $path_image . $this->config->get('bigshop_custom_pattern') ?>");

 <?php
}
else if($this->config->get('bigshop_pattern_overlay')!='none') {
?>  background-image: url("catalog/view/theme/bigshop/image/patterns/<?php echo $this->config->get('bigshop_pattern_overlay'); ?>.png");
 <?php
}
else { ?>  background-image: none;
 <?php
}
?>
}
<?php
 if($this->config->get('bigshop_theme_color')!='') {
?>
a.button, input.button, .box-product > div .cart a.button:hover, .box-product > div .cart input.button:hover, .product-grid > div .cart a.button:hover, .product-grid > div .cart input.button:hover, .product-list > div .cart a.button:hover, .product-info .price-tag, .product-list > div .cart input.button:hover, #header #cart .heading h4, .pagination .links b, #button-cart{
 background-color: <?php echo $this->config->get('bigshop_theme_color');
?>;
}
#header #welcome a:hover, #header .links:hover, #currency:hover, #language:hover, .box-product .price, .box-category > ul > li ul li a:hover, .list-item a:hover, .box-product .name a:hover, .product-list .name a:hover, .product-list .price, .product-grid .wishlist a:hover, .product-grid .compare a:hover, .product-list .wishlist a:hover, .product-list .compare a:hover, .pagination .links a:hover, .product-grid .price, .product-grid .name a:hover, .product-info .price, a.wishlist:hover, .product-info .review a:hover, .sitemap li a:hover, .breadcrumb a:hover{
color: <?php echo $this->config->get('bigshop_theme_color');
?>;
}
.pagination .links b, .box .box-heading span{
border-color: <?php echo $this->config->get('bigshop_theme_color');
?>;
}
<?php }
 if($this->config->get('bigshop_button_color')!='') {
?>  #menu{
 background-color: <?php echo $this->config->get('bigshop_button_color');
?>;
}
#menu > ul > li:hover > a, #menu > ul > li > div{
 background-color: <?php echo $this->config->get('bigshop_button_hover_color');
?>;
}
#menu > ul > li > a, #menu > span {
 color: <?php echo $this->config->get('bigshop_button_text_color');
?>;
}
 <?php
}
if ($this->config->get('bigshop_body_font') != '' ) {
			$fontpre =  $this->config->get('bigshop_body_font');
			$font = str_replace("+", " ", $fontpre);
		?>

		body, p { font-family:<?php echo $font ?>; }

		<?php } 
			if($this->config->get('bigshop_title_font')!='') {
			$fontpre =  $this->config->get('bigshop_title_font');
			$font = str_replace("+", " ", $fontpre);
		?>

		.welcome, h1, h2, h3, .box .box-heading, .checkout-heading, .manufacturer-heading, #menu > ul > li > a{
			font-family:<?php echo $font ?>;
		}

		<?php } ?>
</style>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body>
<div class="main-wrapper">
<div id="header"><div id="welcome">
  <?php echo $currency; ?>
  <div class="links">
  <?php echo $text_account; ?>
  <ul>
  <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
  <li><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a></li>
  <li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
  <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
  </ul>
  </div>
    <?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>    
  </div>
<?php if ($logo) { ?>
 <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
<?php } ?>
  <div id="search">
    <div class="button-search"></div>
    <?php if ($filter_name) { ?>
    <input type="text" id="filter_name" name="filter_name" value="" />
    <?php } else { ?>
    <input type="text" id="filter_name" name="filter_name" value="" onClick="this.value = '';" onKeyDown="this.style.color = '#333';" />
    <?php } ?>
  </div>
  
  <?php echo $cart; ?>
  <!--<div class="links"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></div>-->
</div>
<?php if ($categories)  {  ?>
<div id="menu">
<span>Меню</span>
  <ul>
   <li class="home"><a  title="<?php echo $text_home; ?>" href="<?php echo $home; ?>"><span><?php echo $text_home; ?></span></a></li>
   
   <li><a href=""></a></li>
   <?php foreach ($categories as $category) { ?>
    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <!--<?php if ($category['children']) { ?>
      <div>
        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>
          <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div> -->
      <?php } ?>
    </li>
    <?php } ?> 
  </ul>
</div>
<?php } ?>
<div id="container">
<div id="notification"></div>