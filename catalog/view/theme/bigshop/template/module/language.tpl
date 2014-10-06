<?php if (count($languages) > 0) { ?>
<form action="<?php echo $action; ?>" method="post" id="language_form" enctype="multipart/form-data">
  <div id="language">
  <?php echo $text_language; ?>
   <ul>
    <?php foreach ($languages as $language) { ?>
    
    <li>
    <a title="<?php echo $language['name']; ?>" onclick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code']; ?>'); $('#language_form').submit();" >
    <img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?>
    </a>
   </li>
    
    <?php } ?>
    </ul>
    <input type="hidden" name="language_code" value="" />
    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
  </div>
</form>
<?php } ?>
