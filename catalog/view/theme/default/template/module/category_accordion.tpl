<script type="text/javascript" src="catalog/view/theme/bigshop/js/jquery.dcjqaccordion.js"></script> 

<div class="box">

	<div class="box-heading"><?php echo $heading_title; ?></div>

	<div class="box-content box-category"><?php echo $category_accordion; ?></div>
	
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#custom_accordion').customAccordion({
		classExpand : 'cid<?php echo $category_accordion_cid; ?>',
		menuClose: false,
		autoClose: true,
		saveState: false,
		disableLink: false,		
		autoExpand: true
	});
});
</script>
