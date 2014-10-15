<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
      <div id="tabs" class="htabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
    <div id="tab_general">
      <form action="<?php echo $yml_import; ?>" method="post" enctype="multipart/form-data" id="yml_import">
        <table class="form">
          <tr>
            <td><?php echo $entry_import; ?></td>
            <td><input type="file" name="yml_import" /></td>
            <td><a onclick="$('#yml_import').submit();" class="button"><span><?php echo $button_restore; ?></span></a></td>
          </tr>
        </table>
      </form>
  
  </div>
  
 </div>
 <script type="text/javascript"><!--
$.tabs('#tabs a');
//--></script>
<?php echo $footer; ?>