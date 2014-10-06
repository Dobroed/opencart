<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
	  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
	  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	  <?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box"> 
	  <div class="heading">
		<h1><img src="view/image/module.png" alt="" /><?php echo $heading_title; ?></h1>
		<div class="buttons">
			<a onclick="sav_con()" class="button"><?php echo $button_save_stay; ?></a>
			<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
			<a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
		</div>
	  </div>
	  
	  <div class="content">
		
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="vtabs">
				<?php $module_row = 1; ?>
				<?php foreach ($modules as $module) { ?>
					<a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>">
						<?php echo $tab_module . ' ' . $module_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" />
					</a>
					<?php $module_row++; ?>
				<?php } ?>
				<span id="module-add">
					<?php echo $button_add_module; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addModule();" />
				</span> 
			</div>
			
			<?php $module_row = 1; ?>
			<?php foreach ($modules as $module) { ?>
				<div id="tab-module-<?php echo $module_row; ?>" class="vtabs-content">
					
					<div id="settings-<?php echo $module_row; ?>" class="htabs">
						<a href="#tab-common-<?php echo $module_row; ?>">
							<?php echo $tab_text_common; ?>
						</a>
						
						<a href="#tab-endedsorting-<?php echo $module_row; ?>">
							<?php echo $tab_text_endedsorting; ?>
						</a>
						
						<a href="#tab-sorting-<?php echo $module_row; ?>">
							<?php echo $tab_text_sorting; ?>
						</a>
	
						<a href="#tab-carousel-<?php echo $module_row; ?>">
							<?php echo $tab_text_carousel; ?>
						</a>		
					</div>
					
					<div id="tab-common-<?php echo $module_row; ?>">
						<table class="form">
							<tr>
								<td><?php echo $entry_headingtitle; ?></td>
								<td>
									<?php foreach ($languages as $language) { ?>
									  <input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][headingtitle][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['headingtitle'][$language['language_id']]) ? $module['headingtitle'][$language['language_id']] : ''; ?>"  size="60" />
									  &nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
									<?php } ?>
								</td>
							</tr>
							
							<tr>
								<td><?php echo $entry_adding_class_to_box; ?></td>
								<td><input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][adding_class_to_box]" value="<?php echo $module['adding_class_to_box']; ?>" size="60" />
								</td>							
							</tr>
							
							<tr>
								<td><?php echo $entry_adding_id_to_box; ?></td>
								<td><input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][adding_id_to_box]" value="<?php echo $module['adding_id_to_box']; ?>" size="60" />
								</td>							
							</tr>
							
							<tr>
								<td><?php echo $entry_category; ?></td>
								<td>
								<div class="scrollbox">
								  <?php $class = 'odd'; ?>
								  <?php foreach ($categories as $category) { ?>				  
									  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
									  <div class="<?php echo $class; ?>"> 					
										<?php if (isset($module['category'][$category['category_id']]) && ($category['category_id'] == $module['category'][$category['category_id']])) { ?>						
										<input type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][category][<?php echo $category['category_id']; ?>]" value="<?php echo $category['category_id']; ?>" checked="checked" />
										
										<a href="<?php echo $category['href']; ?>" target="_blank"><?php echo $category['name']; ?></a>
																
										<?php } else { ?>
										<input type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][category][<?php echo $category['category_id']; ?>]" value="<?php echo $category['category_id']; ?>" />
										
										<a href="<?php echo $category['href']; ?>" target="_blank"><?php echo $category['name']; ?></a>
										
										<?php } ?>
									  </div>
								  <?php } ?>
								</div>
								<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
								</td>
							</tr>
							
							<tr>
								<td><?php echo $entry_image; ?></td>
								<td><input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
								<input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
								
								<?php if (isset($error_image[$module_row])) { ?>
								<span class="error"><?php echo $error_image[$module_row]; ?></span>
								<?php } ?>
								</td>							
							</tr>
							
							<tr>
								<td><?php echo $entry_limit; ?></td>
								<td><input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="1" />
								<?php if (isset($error_limit[$module_row])) { ?>
								<span class="error"><?php echo $error_limit[$module_row]; ?></span>
								<?php } ?>							
								</td>							
							</tr>	
						
							<tr>
								<td><?php echo $entry_output; ?></td>						
								<td>
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][output]">
									<?php if ($module['output'] == 'random') { ?>
										<option value="random" selected="selected"><?php echo $text_output_random; ?></option>
										<option value="sequential"><?php echo $text_output_sequential; ?></option>
									<?php } else { ?>
										<option value="random"><?php echo $text_output_random; ?></option>
										<option value="sequential" selected="selected"><?php echo $text_output_sequential; ?></option>
									<?php } ?>
									</select>
								</td>		
							</tr>
							
							<tr>
								<td><?php echo $entry_graphic_output; ?></td>						
								<td>
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][graphic_output]">
									<?php if ($module['graphic_output'] == 'graphic_output_normal') { ?>
										<option value="graphic_output_normal" selected="selected"><?php echo $text_graphic_output_normal; ?></option>
										<option value="graphic_output_carousel"><?php echo $text_graphic_output_carousel; ?></option>
									<?php } else { ?>
										<option value="graphic_output_normal"><?php echo $text_graphic_output_normal; ?></option>
										<option value="graphic_output_carousel" selected="selected"><?php echo $text_graphic_output_carousel; ?></option>
									<?php } ?>
									</select>
								</td>		
							</tr>
							
						</table>
						
						<table id="module" class="list">
							<thead>
							  <tr>						
								<td class="left"><?php echo $entry_layout; ?></td>
								<td class="left"><?php echo $entry_position; ?></td>
								<td class="left"><?php echo $entry_status; ?></td>
								<td class="right"><?php echo $entry_sort_order; ?></td>
							  </tr>
							</thead>
							
							<tbody id="module-row<?php echo $module_row; ?>">
								<tr>
									<td class="left">
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][layout_id]">
									<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $module['layout_id']) { ?>
									<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
									<?php } ?>
									<?php } ?>
									</select></td>
									
									<td class="left">
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][position]">
									<?php if ($module['position'] == 'content_top') { ?>
									<option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
									<?php } else { ?>
									<option value="content_top"><?php echo $text_content_top; ?></option>
									<?php } ?>  
									<?php if ($module['position'] == 'content_bottom') { ?>
									<option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
									<?php } else { ?>
									<option value="content_bottom"><?php echo $text_content_bottom; ?></option>
									<?php } ?>     
									<?php if ($module['position'] == 'column_left') { ?>
									<option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
									<?php } else { ?>
									<option value="column_left"><?php echo $text_column_left; ?></option>
									<?php } ?>
									<?php if ($module['position'] == 'column_right') { ?>
									<option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
									<?php } else { ?>
									<option value="column_right"><?php echo $text_column_right; ?></option>
									<?php } ?>
									</select>
									</td>
									
									<td class="left">
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][status]">
									<?php if ($module['status']) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
									</select>
									</td>
								  
									<td class="right">
									<input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div id="tab-endedsorting-<?php echo $module_row; ?>">
						<table class="form">
						
							<tr>
								<td><?php echo $entry_finalsorting; ?></td>
								<td>
									<?php if ( (isset($module['recomended'])) && ($module['recomended'] == 'yes') ) { ?>
										<input id="recomended" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][recomended]" value="yes" checked="checked" />
										<?php echo $text_recomended; ?>
									<?php } else { ?>
									<input id="recomended" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][recomended]" value="no" />
										<?php echo $text_recomended; ?>
									<?php } ?>
									
									&nbsp;&nbsp;&nbsp;
									
									<?php if ( (isset($module['specials'])) && ($module['specials'] == 'yes') ) { ?>
										<input id="specials" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][specials]" value="yes" checked="checked" />
										<?php echo $text_specials; ?>
									<?php } else { ?>
									<input id="specials" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][specials]" value="no" />
										<?php echo $text_specials; ?>
									<?php } ?>
									
									&nbsp;&nbsp;&nbsp;
									
									<?php if ( (isset($module['bestsellers'])) && ($module['bestsellers'] == 'yes') ) { ?>
										<input id="bestsellers" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][bestsellers]" value="yes" checked="checked" />
										<?php echo $text_bestsellers; ?>
									<?php } else { ?>
									<input id="bestsellers" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][bestsellers]" value="no" />
										<?php echo $text_bestsellers; ?>
									<?php } ?>
									
									&nbsp;&nbsp;&nbsp;
									
									<?php if ( (isset($module['latest'])) && ($module['latest'] == 'yes') ) { ?>
										<input id="latest" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][latest]" value="yes" checked="checked" />
										<?php echo $text_latest; ?>
									<?php } else { ?>
									<input id="latest" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][latest]" value="no" />
										<?php echo $text_latest; ?>
									<?php } ?>
									
									&nbsp;&nbsp;&nbsp;
									
									<?php if ( (isset($module['popular'])) && ($module['popular'] == 'yes') ) { ?>
										<input id="popular" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][popular]" value="yes" checked="checked" />
										<?php echo $text_popular; ?>
									<?php } else { ?>
									<input id="popular" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][popular]" value="no" />
										<?php echo $text_popular; ?>
									<?php } ?>
									
								</td>  
							</tr>
																				
							<tr>
								<td ><?php echo $text_rating; ?></td>
								<td>
								  <?php echo $text_rating_from; ?>
								  <select name="jv_products_in_m_module[<?php echo $module_row; ?>][rating_sorting_from]">
									<?php foreach ($rating_parametrs as $rating_parametr) { ?>
									<?php if ($rating_parametr['rating_parametrs_id'] == $module['rating_sorting_from']) { ?>
									<option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>" selected="selected"><?php echo $rating_parametr['name']; ?>
									</option>
									<?php } else { ?>
									<option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>"><?php echo $rating_parametr['name']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								  </select>
								  
								  &nbsp;&nbsp;&nbsp;
								  
								  <?php echo $text_rating_to; ?>
								  <select name="jv_products_in_m_module[<?php echo $module_row; ?>][rating_sorting_to]">
									<?php foreach ($rating_parametrs as $rating_parametr) { ?>
									<?php if ($rating_parametr['rating_parametrs_id'] == $module['rating_sorting_to']) { ?>
									<option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>" selected="selected"><?php echo $rating_parametr['name']; ?>
									</option>
									<?php } else { ?>
									<option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>"><?php echo $rating_parametr['name']; ?>
									</option>
									<?php } ?>
									<?php } ?>
								  </select>
								</td> 
							</tr>

							<tr>
								<td ><?php echo $text_quantity; ?></td>
								<td>
								    <?php echo $text_quantity_from; ?>
									<input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][quantity_sorting_from]" value="<?php echo $module['quantity_sorting_from']; ?>" size="6" />
									
									&nbsp;&nbsp;&nbsp;
									
									<?php echo $text_quantity_to; ?>
									<input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][quantity_sorting_to]" value="<?php echo $module['quantity_sorting_to']; ?>" size="6" />
									
									<?php if (isset($error_quantity_sorting[$module_row])) { ?>
									<span class="error"><?php echo $error_quantity_sorting[$module_row]; ?></span>
									<?php } ?>
								
								</td> 
							</tr>

							
						</table>
					</div>
					
					<div id="tab-sorting-<?php echo $module_row; ?>">
						<table class="form">						
							
							<tr>
								<td><?php echo $entry_sorting; ?></td>				
								<td>
								  <select name="jv_products_in_m_module[<?php echo $module_row; ?>][sorting_parametr]">
									<?php foreach ($sorting_parametrs as $sorting_parametr) { ?>
									<?php if ($sorting_parametr['sorting_parametrs_id'] == $module['sorting_parametr']) { ?>
									<option value="<?php echo $sorting_parametr['sorting_parametrs_id']; ?>" selected="selected"><?php echo $sorting_parametr['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $sorting_parametr['sorting_parametrs_id']; ?>"><?php echo $sorting_parametr['name']; ?></option>
									<?php } ?>
									<?php } ?>
								  </select>
								  
								  <select name="jv_products_in_m_module[<?php echo $module_row; ?>][sorting_type]">
									<?php if ($module['sorting_type'] == 'DESC') { ?>
									<option value="DESC" selected="selected"><?php echo $text_sorting_type_desc; ?></option>
									<option value="ASC"><?php echo $text_sorting_type_asc; ?></option>
									<?php } else { ?>
									<option value="ASC" selected="selected"><?php echo $text_sorting_type_asc; ?></option>
									<option value="DESC"><?php echo $text_sorting_type_desc; ?></option>
									<?php } ?>
								  </select>
								</td>		
							</tr>
						
						</table>
					</div>
					
					<div id="tab-carousel-<?php echo $module_row; ?>">
						<table class="form">
						
							<tr>
								<td><?php echo $entry_carousel_scroll; ?></td>
								<td><input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][carousel_scroll]" value="<?php echo $module['carousel_scroll']; ?>" size="1" />
								<?php if (isset($error_carousel_scroll[$module_row])) { ?>
								<span class="error"><?php echo $error_carousel_scroll[$module_row]; ?></span>
								<?php } ?>							
								</td> 
								
							</tr>
							
							<tr>
								<td><?php echo $entry_carousel_direction; ?></td>
								<td>
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][carousel_direction]">
									<?php if ($module['carousel_direction'] == 'carousel_direction_ltr') { ?>
										<option value="carousel_direction_ltr" selected="selected"><?php echo $text_carousel_direction_ltr; ?></option>
										<option value="carousel_direction_rtl"><?php echo $text_carousel_direction_rtl; ?></option>
									<?php } else { ?>
										<option value="carousel_direction_ltr"><?php echo $text_carousel_direction_ltr; ?></option>
										<option value="carousel_direction_rtl" selected="selected"><?php echo $text_carousel_direction_rtl; ?></option>
									<?php } ?>
									</select>
								</td> 
							</tr>

							<tr>
								<td><?php echo $entry_carousel_wrap; ?></td>
								<td>
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][carousel_wrap]">
										<?php foreach ($carousel_wrap_parametrs as $carousel_wrap_parametr) { ?>	
											<?php if ($module['carousel_wrap'] == $carousel_wrap_parametr['carousel_wrap_parametrs_id']) { ?>
												<option value="<?php echo $carousel_wrap_parametr['carousel_wrap_parametrs_id']; ?>" selected="selected"><?php echo $carousel_wrap_parametr['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $carousel_wrap_parametr['carousel_wrap_parametrs_id']; ?>"><?php echo $carousel_wrap_parametr['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>								
								</td> 
							</tr>
							
							<tr>
								<td><?php echo $text_carousel_autoscroll; ?></td>
								<td>
									<select name="jv_products_in_m_module[<?php echo $module_row; ?>][carousel_autoscroll]">
										<?php if ($module['carousel_autoscroll']) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							
							<tr>
								<td><?php echo $entry_carousel_time_autoscroll; ?></td>
								<td><input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][carousel_time_autoscroll]" value="<?php echo $module['carousel_time_autoscroll']; ?>" size="1" />
								<?php if (isset($error_carousel_time_autoscroll[$module_row])) { ?>
								<span class="error"><?php echo $error_carousel_time_autoscroll[$module_row]; ?></span>
								<?php } ?>							
								</td> 	
							</tr>
						
						</table>
					</div>
		
				</div>
				<?php $module_row++; ?>
			<?php } ?>
			
		</form>
	  </div>
	
	</div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';
	
	html += '  <div id="settings-' + module_row + '" class="htabs">';
	html += '    <a href="#tab-common-' + module_row + '"><?php echo $tab_text_common; ?></a>';
	html += '    <a href="#tab-endedsorting-' + module_row + '"><?php echo $tab_text_endedsorting; ?></a>';
	html += '    <a href="#tab-sorting-' + module_row + '"><?php echo $tab_text_sorting; ?></a>';
	html += '    <a href="#tab-carousel-' + module_row + '"><?php echo $tab_text_carousel; ?></a>';
	html += '  </div>';

	
	// tab-common  //
	html += '  <div id="tab-common-' + module_row + '">';
	html += '  	<table class="form">';

	html += '    <tr>';
	html += '      <td><?php echo $entry_headingtitle; ?></td>';
	html += '	   <td>';
						<?php foreach ($languages as $language) { ?>
	html += '			  <input type="text" name="jv_products_in_m_module[<?php echo $module_row; ?>][headingtitle][<?php echo $language['language_id']; ?>]" value=""  size="60" /> &nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br /> ';
						<?php } ?>
	html += '	</td>  ';
	html += '    </tr>';
	
	html += '    <tr>';
	html += '      <td><?php echo $entry_category; ?></td>';
	html += '<td> <div class="scrollbox">';
		<?php $class = 'odd'; ?>
        <?php foreach ($categories as $category) { ?>
			<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
			html += '	<div class="<?php echo $class; ?>">  ';	
			<?php $category['name'] = str_replace('\'' , '\\\'' , $category['name']); ?>			
			html += '	<input type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][category][<?php echo $category['category_id']; ?>]" value="<?php echo $category['category_id']; ?>" /><?php echo $category['name']; ?>     ';
			html += '	</div>   ';	
		<?php } ?>	
	html += '	</div>   ';	
	html += '	<a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a> ';
	html += '	</td>  ';
	html += '    </tr>';
	
	html += '    <tr>';
	html += '      <td><?php echo $entry_image; ?></td>';
	html += '    <td><input type="text" name="jv_products_in_m_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="jv_products_in_m_module[' + module_row + '][image_height]" value="80" size="3" /></td>';	
	html += '    </tr>';
	
	html += '    <tr>';
	html += '      <td><?php echo $entry_limit; ?></td>';
	html += '    <td><input type="text" name="jv_products_in_m_module[' + module_row + '][limit]" value="5" size="1" /></td>';
	html += '    </tr>';
	
	html += '    <tr>';
	html += '      <td><?php echo $entry_output; ?></td>';
	html += '    <td><select name="jv_products_in_m_module[' + module_row + '][output]">';
    html += '      <option value="random"><?php echo $text_output_random; ?></option>';
    html += '      <option value="sequential"  selected="selected"><?php echo $text_output_sequential; ?></option>';
    html += '    </select></td>';
	html += '    </tr>';
	
	html += '    <tr>';
	html += '      <td><?php echo $entry_graphic_output; ?></td>';
	html += '    <td><select name="jv_products_in_m_module[' + module_row + '][graphic_output]">';
    html += '      <option value="graphic_output_normal" selected="selected"><?php echo $text_graphic_output_normal; ?></option>';
    html += '      <option value="graphic_output_carousel"><?php echo $text_graphic_output_carousel; ?></option>';
    html += '    </select></td>';
	html += '    </tr>';	
	
	html += '   </table';
	
	html += '  	<table class="form">';
	html += '   <table id="module" class="list">';
	html += '    <thead>';
	html += '    	<tr>';					
	html += '    		<td class="left"><?php echo $entry_layout; ?></td>';	
	html += '    		<td class="left"><?php echo $entry_position; ?></td>';
	html += '    		<td class="left"><?php echo $entry_status; ?></td>';
	html += '    		<td class="right"><?php echo $entry_sort_order; ?></td>';
	html += '    	</tr>';
	html += '    </thead>';

	html += '    <tbody id="module-row<?php echo $module_row; ?>">';
	html += '    	<tr>';
	
	html += '    		<td class="left"><select name="jv_products_in_m_module[' + module_row + '][layout_id]">';
							<?php foreach ($layouts as $layout) { ?>
	html += '      				<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
							<?php } ?>
	html += '    		</select></td>';
	
	html += '    		<td class="left"><select name="jv_products_in_m_module[' + module_row + '][position]">';
	html += '      			<option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      			<option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      			<option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      			<option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    		</select></td>';
	
	html += '    		<td class="left"><select name="jv_products_in_m_module[' + module_row + '][status]">';
    html += '      			<option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      			<option value="0"><?php echo $text_disabled; ?></option>';
    html += '    		</select></td>';
	
	html += '    		<td class="right"><input type="text" name="jv_products_in_m_module[' + module_row + '][sort_order]" value="" size="3" /></td>';

	html += '    	</tr>';
	html += '    </tbody>';
	
	html += '  </table>'; 
	
	html += '  </div> ';
	// tab-common  //

	// tab-endedsorting  //
	html += '  <div id="tab-endedsorting-' + module_row + '">';
	html += '  	<table class="form">';
	
	html += '	<tr>';
	html += '		<td><?php echo $entry_finalsorting; ?></td>';
	html += '		<td><input id="recomended" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][recomended]" value="no" /><?php echo $text_recomended; ?>';
	html += '		&nbsp;&nbsp;&nbsp;';
	html += '		<input id="specials" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][specials]" value="no" /><?php echo $text_specials; ?>';
	
	html += '		&nbsp;&nbsp;&nbsp;';
	html += '		<input id="bestsellers" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][bestsellers]" value="no" /><?php echo $text_bestsellers; ?>';
	
	html += '		&nbsp;&nbsp;&nbsp;';
	html += '		<input id="latest" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][latest]" value="no" /><?php echo $text_latest; ?>';
	
	html += '		&nbsp;&nbsp;&nbsp;';
	html += '		<input id="popular" type="checkbox" name="jv_products_in_m_module[<?php echo $module_row; ?>][popular]" value="no" /><?php echo $text_popular; ?>';
	
	html += '	   	</td>';	
	html += '	</tr>';	
	
	
	html += '    <tr>';
	html += '      <td><?php echo $text_rating; ?></td>';
	
	html += '	 <td><?php echo $text_rating_from; ?><select name="jv_products_in_m_module[' + module_row + '][rating_sorting_from]">';
	<?php foreach ($rating_parametrs as $rating_parametr) { ?>
	<?php if ($rating_parametr['rating_parametrs_id'] == 0) { ?>
	html += '	 <option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>" selected="selected"><?php echo $rating_parametr['name']; ?></option>';
	<?php } else { ?>
	html += '	 <option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>"><?php echo $rating_parametr['name']; ?></option>';
	<?php } ?>
	<?php } ?>
	html += '	 </select>';
	
	html += '        &nbsp;&nbsp;&nbsp;';
	
    html += '	 <?php echo $text_rating_to; ?><select name="jv_products_in_m_module[' + module_row + '][rating_sorting_to]">';
	<?php foreach ($rating_parametrs as $rating_parametr) { ?>
	<?php if ($rating_parametr['rating_parametrs_id'] == 5) { ?>
	html += '	 <option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>" selected="selected"><?php echo $rating_parametr['name']; ?></option>';
	<?php } else { ?>
	html += '	 <option value="<?php echo $rating_parametr['rating_parametrs_id']; ?>"><?php echo $rating_parametr['name']; ?></option>';
	<?php } ?>
	<?php } ?>
    html += '	 </select></td>'; 
	html += '    </tr>';
	
	
	html += '    <tr>';
	html += '      <td><?php echo $text_quantity; ?></td>';
	html += '      <td>';
	html += '        <?php echo $text_quantity_from; ?>';
	html += '        <input type="text" name="jv_products_in_m_module[' + module_row + '][quantity_sorting_from]" value="0" size="6" />';
	html += '        &nbsp;&nbsp;&nbsp;';
	html += '        <?php echo $text_quantity_to; ?>';
	html += '        <input type="text" name="jv_products_in_m_module[' + module_row + '][quantity_sorting_to]" value="100000" size="6" />';						
	html += '      </td>';
	html += '    </tr>';
	
	
	html += '   </table';
	html += '  </div> </div>';
	// tab-endedsorting  //
	
	// tab-sorting  //
	html += '  <div id="tab-sorting-' + module_row + '">';
	html += '  	<table class="form">';	
								
	html += '    <tr>';
	html += '      <td><?php echo $entry_sorting; ?></td>';
	html += '    <td><select name="jv_products_in_m_module[' + module_row + '][sorting_parametr]">';
	<?php foreach ($sorting_parametrs as $sorting_parametr) { ?>
	html += '      <option value="<?php echo $sorting_parametr['sorting_parametrs_id']; ?>"><?php echo $sorting_parametr['name']; ?></option>';
	<?php } ?>
	html += '    </select>';
	html += '    <select name="jv_products_in_m_module[' + module_row + '][sorting_type]">';
	html += '      <option value="ASC" selected="selected"><?php echo $text_sorting_type_asc; ?></option>';
	html += '      <option value="DESC"><?php echo $text_sorting_type_desc; ?></option>';
	html += '    </select></td>';
	html += '    </tr>';	

	html += '   </table';
	html += '  </div> </div>';
	// tab-sorting  //
	
	// tab-carousel  //
	html += '  <div id="tab-carousel-' + module_row + '">';
	html += '  	<table class="form">';
	
	html += '    <tr>';
	html += '      <td><?php echo $entry_carousel_scroll; ?></td>';
	html += '      <td><input type="text" name="jv_products_in_m_module[' + module_row + '][carousel_scroll]" value="3" size="1" /></td>';
	html += '    </tr>';	
	
	html += '    <tr>';
	html += '      <td>';
	html += '			<?php echo $entry_carousel_direction; ?>';
	html += '      </td>';	
	html += '      <td>';
	html += '    		<select name="jv_products_in_m_module[' + module_row + '][carousel_direction]">';
	html += '      			<option value="carousel_direction_ltr" selected="selected"><?php echo $text_carousel_direction_ltr; ?></option>';
	html += '      			<option value="carousel_direction_rtl"><?php echo $text_carousel_direction_rtl; ?></option>';
	html += '    		</select>';
	html += '      </td>';
	html += '    </tr>';		
	
	html += '    <tr>';
	html += '      <td><?php echo $entry_carousel_wrap; ?></td>';	
	html += '      <td>';
	html += '    	<select name="jv_products_in_m_module[' + module_row + '][carousel_wrap]">';
						<?php foreach ($carousel_wrap_parametrs as $carousel_wrap_parametr) { ?>
	html += '      			<option value="<?php echo $carousel_wrap_parametr['carousel_wrap_parametrs_id']; ?>"><?php echo $carousel_wrap_parametr['name']; ?></option>';
						<?php } ?>
	html += '    	</select>';
	html += '      </td>';
	html += '    </tr>';
	
	html += '    <tr>';
	html += '      	<td><?php echo $text_carousel_autoscroll; ?></td>';
	html += '    	<td>';
	html += '    		<select name="jv_products_in_m_module[' + module_row + '][carousel_autoscroll]">';
    html += '      			<option value="1"><?php echo $text_enabled; ?></option>';
    html += '      			<option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
    html += '    		</select>';
	html += '    	</td>';
	html += '    </tr>';	

	html += '    <tr>';
	html += '      	<td><?php echo $entry_carousel_time_autoscroll; ?></td>';
	html += '    	<td><input type="text" name="jv_products_in_m_module[' + module_row + '][carousel_time_autoscroll]" value="2" size="1" /></td>';
	html += '    </tr>';
	
	html += '   </table';
	html += '  </div> </div>';
	// tab-carousel  //
	
	html += '  </div>';

	
	$('#form').append(html);
	
	$('#settings-' + module_row + ' a').tabs();
	
	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><?php echo $tab_module; ?> ' + module_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');

	$('.vtabs a').tabs();
	
	$('#module-' + module_row).trigger('click');
	
	module_row++;
}
//--></script> 

<script type="text/javascript"><!--
$('.vtabs a').tabs();
//--></script> 

<script type="text/javascript"><!--
<?php $module_row = 1; ?>
<?php foreach ($modules as $module) { ?>
$('#settings-<?php echo $module_row; ?> a').tabs();
<?php $module_row++; ?>
<?php } ?> 
//--></script> 

<script type="text/javascript"><!--
function sav_con(){
	$('#form').append('<input type="hidden" id="save_continue" name="save_continue" value="1"  />');
	$('#form').submit();
}
//--></script>

<script type="text/javascript"><!--
$('#recomended, #specials, #bestsellers, #latest, #popular, #carousel_autoscroll').live('click', function(){  
  if ($(this).prop("checked")) {
	$(this).val('yes');
	$(this).attr("checked", "checked");}
     else {
	$(this).val('no');
	$(this).removeAttr("checked");
     }
});
//--></script>

<?php echo $footer; ?>