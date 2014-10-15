<?php echo $header; ?>
<?php if ($attention) { ?>
<div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>

 <script type="text/javascript">
 function cmp(){var a=0;$("select[id^=pay]:not(:disabled) option:selected").each(function(){var b=$(this);var c=parseFloat(b.attr("alt"));if(a<c){a=c}});$("#osqNWyGAwJZDACKjVtkvaBUpF").html(a)}
 
 function CugwbgDoQKRH(){isPREPAY=false;$("select[id^=pay]:not(:disabled) option:selected").each(function(){if($(this).text().toLowerCase().indexOf("предоплата")>-1){isPREPAY=true}});if(isPREPAY){$("#ztojzlBzmxFh").show()}else{$("#ztojzlBzmxFh").hide()}}function QGChJGA(a){return a.replace(/^\s+/,"")}
 
function TbBfbuoeqGPWQ(){var b=document.getElementsByTagName("span");
var e=0;for(var a=0;a<b.length;a++){var d=b[a];var f=d.getAttribute("id");if(f){if(f.indexOf("EwmpToHbdZQz")===0||f.indexOf("osqNWyGAwJZDACKjVtkvaBUpF")===0){var c=parseFloat(QGChJGA(d.innerHTML));if(c){e+=c}}}}document.getElementById("kwddczNXnH").innerHTML=Math.round(e*100)/100}

    $(document).ready(function () {
        $("select[id^=pay]").change(function(){
            cmp();
            TbBfbuoeqGPWQ();
            CugwbgDoQKRH();
        });
                cmp();
        TbBfbuoeqGPWQ();
                CugwbgDoQKRH();
    });


function pay_show(e)
{
var b=document.getElementById("dev"+e);
var d=document.getElementsByTagName("select");
for(var c=0;c<d.length;c++)
{
	var a=d[c];
	var f=a.getAttribute("id");
	if(f){
		if(f.indexOf("pay"+e+"_")===0)
		{
			if(f.indexOf("pay"+e+"_"+b.value)===0)
			{
				a.disabled=false;a.style.display="block"
			}
			else
			{
				a.disabled=true;a.style.display="none"
			}
		}
	}
}
if(b.value=="2")
{
isSD=true;isPOST=false;
$("#sd"+e).show();
$("#JGCFKun").hide();
$("#BYpJCNMGujutX").hide()}

else{
if(b.value=="1")
{isPOST=true;isSD=false;
$("#sd"+e).hide();
$("#JGCFKun").show();
$("#BYpJCNMGujutX").show()}
else
{isSD=false;
isPOST=false;
$("#sd"+e).hide();
$("#JGCFKun").show();
$("#BYpJCNMGujutX").hide()}}cmp();
TbBfbuoeqGPWQ();
CugwbgDoQKRH()
}

</script>

<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?>
  </h1>
  
    <div class="cart-info">
			<table>
	        <thead>
          <tr>
            <td class="image"><?php echo $column_image; ?></td>
            <td class="name"><?php echo $column_name; ?></td>
            <td class="model"><?php echo $column_model; ?></td>
            <td class="quantity"><?php echo $column_quantity; ?></td>
            <td class="price"><?php echo $column_price; ?></td>
            <td class="total"><?php echo $column_total; ?></td>
          </tr>
        </thead>
          <?php $k=0; foreach ($products as $product) { ?>
        <tbody>
          <tr>
            <td class="image"><?php if ($product['thumb']) { ?>
              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
              <?php } ?></td>
            <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
              <?php if (!$product['stock']) { ?>
              <span class="stock">***</span>
              <?php } ?>
              <div>
                <?php foreach ($product['option'] as $option) { ?>
                - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                <?php } ?>
              </div>
              <?php if ($product['reward']) { ?>
              <small><?php echo $product['reward']; ?></small>
              <?php } ?></td>
            <td class="model"><?php echo $product['sku']; ?></td>
			<?php if($page=="cart") { ?>
            <td class="quantity"><input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" />
              &nbsp;
              <input type="image" src="catalog/view/theme/default/image/update.png" alt="<?php echo $button_update; ?>" title="<?php echo $button_update; ?>" />
              &nbsp;<a href="<?php echo $product['remove']; ?>"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a></td> <?php } else { ?>
			  <td class="quantity"><?php echo $product['quantity']; ?>
              &nbsp;</td>
			  <?php } ?>
            <td class="price"><?php echo $product['price']; ?></td>
            <td class="total"><?php echo $product['total']; ?></td>
          </tr>
		<?php  if($page=='checkout') { ?>
			<?php if($k==count($products)-1) { ?>
			<h3>Выберите способ оплаты и доставки</h3>
		    <form action=<?php echo $action; ?> method="POST">
		<table>
		  <tr>
		  <td>
		  <select name="dev" id="dev" onchange="pay_show('');">
		  <?php foreach($dev_types[$product['sku']] as $id) { ?>
		  <option value="<?php echo $id; ?>" <?php if($id==$dev) echo 'select="selected"'; ?>><?php echo $dev_names[$id]; ?></option>
		  <?php } ?>
		  </select>
		  </td>
			<td>
			<?php foreach($dev_types[$product['sku']] as $id) { ?>
			<select name="pay" id="pay_<?php echo $id; ?>" <?php if($id!=$dev) echo 'disabled="disabled" style="display: none;"' ?>>
				<?php  
				for($i=0; $i<count($pay_types[$product['sku']][$id]['id']); $i++) { ?>
					<option value="<?php echo $pay_types[$product['sku']][$id]['id'][$i]; ?>" <?php if($i==$pay) echo 'select="selected"'; ?> ><?php echo $pay_names[$pay_types[$product['sku']][$id]['id'][$i]].'  Цена доставки ('.$pay_types[$product['sku']][$id]['sum'][$i].'р)'; ?></option>
				<?php }  ?>
			</select>
			<?php } ?>
			<script>isPOST=false;isSD=false;</script>
					  </td>
		  <td colspan="4">
		  </td>
		  </tr>
		</table>
			<div id="sd"  style="display: none;">
			<h3>Выберите пункт самовывоза</h3>
			<table>
			<tr>
				<td></td>
				<td>Адрес</td>
				<td>Режим работы</td>
				<td>Телефон</td>
				<td>Срок доставки</td>
			</tr>
			<?php foreach($sdList as $sd) { ?>
			<tr>
			<td style="vertical-align: middle !important"><input type="radio" name="sd" value="<?php echo $sd->getId(); ?>"/>
				<td><?php echo $sd->getAddress(); ?></td>
				<td><?php echo $sd->getWorkTime(); ?></td>
				<td><?php echo $sd->getPhone(); ?></td>
				<td><?php echo $sd->getDeliveryTime(); ?></td>
			</tr>
			<?php } ?>
			</table>
			</div>
			
			<?php } } $k++; } ?>
					</tbody>
      </table>

    </div>

	
  <?php if(($page=="cart")||(!$page)) { ?>
  <?php if(empty($api_errors)) { ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="page" value="checkout">
  <div id="shipping" class="content" style="display: block;">
  <select name="zone">
  <?php foreach($regions as $id=>$name) { ?>
  <option value="<?php echo $id.'.'.$name; ?>" selected="selected"><?php echo $name; ?></option>
  <?php } ?>
  </select>
	<input type="submit" value="<?php echo $button_checkout; ?>" class="button" />

  </div>
  </form>
  <?php } else { 
  foreach($api_errors as $api_error) {?>
  <h3><?php echo $api_error; ?><h3>
  <?php } } } elseif($page=="checkout") { ?>
  <div id="shipping" class="content" style="display: block;">
 <script type="text/javascript"> function show_ur(b){
	var a=document.getElementById(b);
	if("none"==a.style.display){a.style.display="block"}
	else{a.style.display="none"}
	return false
	}
</script>

<?php if(isset($post_errors)) { 
	foreach($post_errors as $error) { ?>
	<h4><?php echo $error; ?></h4>
	<?php } } ?>
  
  <input type="hidden" name="page" value="checkout">
  <input type="hidden" name="zone" value="<?php echo $zone; ?>">
  <table cellspacing="10" >
  <tr>
  <td>Ваш регион:</td><td> <?php echo $region; ?></td>
  </tr>
  <tr>
  <td>ФИО получателя (*):</td>
  <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
  </tr>
  <tr>
<td>Адрес получателя (*):</td>
<td><input type="text" name="adress" value="<?php echo $adress; ?>"></td>
</tr>
  <tr>
<td>Почтовый индекс (*):</td>
<td><input type="text" name="zip" value="<?php echo $zip; ?>"></td>
</tr>
<tr>
<td>E-mail (*):</td>
<td><input type="text" name="email" value="<?php echo $email; ?>"></td>
</tr>
<tr>
<td>Основной контактный телефон (*):</td>
<td><input type="text" name="phone1" value="<?php echo $phone1; ?>"></td>
</tr>
<tr>
<td>Время, когда оператор может позвонить по первому телефону (*):</td>
<td><input type="text" name="time1" value="<?php echo $time1 ;?>"></td>
</tr>
<tr>
<td>Запасной контактный телефон:</td>
<td><input type="text" name="phone2" value="<?php echo $phone2; ?>"></td>
</tr>
<tr>
<td>Время, когда оператор может позвонить по второму телефону:</td>
<td><input type="text" name="time2" value="<?php echo $time2; ?>"></td>
</tr>
<tr>
<td>Комментарий к адресу доставки:</td>
<td><input type="text" name="comment" value="<?php echo $comment; ?>"></td>
</tr>
</table>
<a href="#" onclick="return show_ur('ur');">Безнал от юрлица</a><br/><br/>
<div id="ur" style="display:none;">
<table cellspacing="10">
<td >Юридический адрес:</td>
<td><input type="text" name="ur_adress" value="<?php echo $ur_adress; ?>"></td>
</tr>
<tr>
<td>Наименование банка:</td>
<td><input type="text" name="bank_name" value="<?php echo $bank_name; ?>"></td>
</tr>
<tr>
<td>Город банка:</td>
<td><input type="text" name="bank_city" value="<?php echo $bank_city; ?>"></td>
</tr>
<tr>
<td>БИК:</td>
<td><input type="text" name="bik" value="<?php echo $bik; ?>"></td>
</tr>
<tr>
<td>ИНН:</td>
<td><input type="text" name="inn" value="<?php echo $inn; ?>"></td>
</tr>
<tr>
<td>КПП:</td>
<td><input type="text" name="kpp" value="<?php echo $kpp; ?>"></td>
</tr>
<tr>
<td>Корреспондентский счет:</td>
<td><input type="text" name="kor_sch" value="<?php echo $kor_sch; ?>"></td>
</tr>
<tr>
<td>Наименование организации:</td>
<td><input type="text" name="org_name" value="<?php echo $org_name; ?>"></td>
</tr>
<tr>
<td>Код ОКПО:</td>
<td><input type="text" name="okpo" value="<?php echo $okpo; ?>"></td>
</tr>
<tr>
<td>Код ОКВЭД:</td>
<td><input type="text" name="okved" value="<?php echo $okved; ?>"></td>
</tr>
<tr>
<td>Расчетный счет:</td>
<td><input type="text" name="r_sch" value="<?php echo $r_sch; ?>"></td>
</tr>
<tr>
<td>Тип организации:</td>
<td><input type="text" name="org_type" value="<?php echo $org_type; ?>"></td>
</tr>
 </table>
 </div>
  <input type="submit" value="Оформить заказ" name="check" class="button">
  </form>
  </div>
  <?php } elseif($page=="sucsess") { ?>
	<h2>Заказ был оформлен. В кратчайшие сроки мы свяжемся с Вами.</h2>
	<h3>Запишите Ваш номер заказа #<?php echo $OrderId; ?> </h3>
  <?php } ?>
  
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('input[name=\'next\']').bind('change', function() {
	$('.cart-module > div').hide();
	
	$('#' + this.value).show();
});
//--></script>
<?php if ($shipping_status) { ?>
<script type="text/javascript"><!--
$('#button-quote').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/quote',
		type: 'post',
		data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($('input[name=\'postcode\']').val()),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-quote').attr('disabled', true);
			$('#button-quote').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-quote').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$('.success, .warning, .attention, .error').remove();			
						
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
					
					$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}	
							
				if (json['error']['country']) {
					$('select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['postcode']) {
					$('input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}					
			}
			
			if (json['shipping_method']) {
				html  = '<h2><?php echo $text_shipping_method; ?></h2>';
				html += '<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">';
				html += '  <table class="radio">';
				
				for (i in json['shipping_method']) {
					html += '<tr>';
					html += '  <td colspan="3"><b>' + json['shipping_method'][i]['title'] + '</b></td>';
					html += '</tr>';
				
					if (!json['shipping_method'][i]['error']) {
						for (j in json['shipping_method'][i]['quote']) {
							html += '<tr class="highlight">';
							
							if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method; ?>') {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" /></td>';
							} else {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" /></td>';
							}
								
							html += '  <td><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + '</label></td>';
							html += '  <td style="text-align: right;"><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['text'] + '</label></td>';
							html += '</tr>';
						}		
					} else {
						html += '<tr>';
						html += '  <td colspan="3"><div class="error">' + json['shipping_method'][i]['error'] + '</div></td>';
						html += '</tr>';						
					}
				}
				
				html += '  </table>';
				html += '  <br />';
				html += '  <input type="hidden" name="next" value="shipping" />';
				
				<?php if ($shipping_method) { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button" />';	
				<?php } else { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button" disabled="disabled" />';	
				<?php } ?>
							
				html += '</form>';
				
				$.colorbox({
					overlayClose: true,
					opacity: 0.5,
					width: '600px',
					height: '400px',
					href: false,
					html: html
				});
				
				$('input[name=\'shipping_method\']').bind('change', function() {
					$('#button-shipping').attr('disabled', false);
				});
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<?php } ?>
<?php echo $footer; ?>