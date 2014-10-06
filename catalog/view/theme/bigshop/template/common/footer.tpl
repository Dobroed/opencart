</div>
</div>
<div id="footer">

    <?php if($this->config->get('bigshop_facebook_id') != '') { ?>
    <div id="facebook" class="social-part">
        <!--<h3><?php echo $this->config->get('bigshop_facebook_label'); ?></h3>-->
        <div class="fb-inner">
            <script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US"></script>
            <script type="text/javascript">FB.init("1690883eb733618b294e98cb1dfba95a");</script>
            <fb:fan profile_id="<?php echo $this->config->get('bigshop_facebook_id'); ?>" stream="0" connections="25" logobar="0" border="white" width="1170" height="94" css="<?php echo HTTPS_SERVER; ?>catalog/view/theme/bigshop/stylesheet/facebook.css?3.0.0.2"></fb:fan>
        </div>
    </div>
    <?php } ?>

    <?php if ($informations) { ?>
    <div class="column">
        <h3><?php echo $text_information; ?></h3>
        <ul>
            <?php foreach ($informations as $information) { ?>
            <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    <div class="column">
        <h3><?php echo $text_service; ?></h3>
        <ul>
            <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
            <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
            <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
    </div>
    <div class="column">
        <h3><?php echo $text_extra; ?></h3>
        <ul>
            <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
            <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
            <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
            <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
    </div>
    <div class="column">
        <h3><?php echo $text_account; ?></h3>
        <ul>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
            <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
    </div>

    <div class="contact">
        <ul>
            <?php if($this->config->get('bigshop_address') != '') { ?>
            <li class="address"><?php echo $this->config->get('bigshop_address'); ?></li>
            <?php } ?>

            <?php if($this->config->get('bigshop_mobile') != '') { ?>
            <li class="mobile"><?php echo $this->config->get('bigshop_mobile'); ?></li>
            <?php } ?>

            <?php if($this->config->get('bigshop_email') != '') { ?>
            <li class="email"><?php echo $this->config->get('bigshop_email'); ?> </li>
            <?php } ?>

            <?php if($this->config->get('bigshop_fax') != '') { ?>
            <li class="fax"><?php echo $this->config->get('bigshop_fax'); ?></li>
            <?php } ?>
        </ul>
    </div>
    <img src="catalog/view/theme/bigshop/template/information/function.php" height="1" width="1" />


    <div class="social">
        <?php if($this->config->get('bigshop_facebook_id') != '' || $this->config->get('bigshop_twitter_username') != '' || $this->config->get('bigshop_gplus_id') != '') { ?>

        <?php } ?>
        <?php if($this->config->get('bigshop_facebook_id') != '') { ?>
        <a href="http://facebook.com/<?php echo $this->config->get('bigshop_facebook_id'); ?>" target="_blank"> <img src="catalog/view/theme/bigshop/image/facebook.png" alt="Facebook" title="Facebook"></a>
        <?php } ?>
        <?php if($this->config->get('bigshop_twitter_username') != '') { ?>
        <a href="https://twitter.com/#!/<?php echo $this->config->get('bigshop_twitter_username'); ?>" target="_blank"> <img src="catalog/view/theme/bigshop/image/twitter.png" alt="Twitter" title="Twitter"> </a>
        <?php } ?>
        <?php if($this->config->get('bigshop_gplus_id') != '') { ?>
        <a href="https://plus.google.com/u/0/<?php echo $this->config->get('bigshop_gplus_id'); ?>" target="_blank"> <img src="catalog/view/theme/bigshop/image/gplus.png" alt="Google+" title="Google+"> </a>
        <?php } ?>
        <?php if($this->config->get('bigshop_pint_id') != '') { ?>
        <a href="http://pinterest.com/<?php echo $this->config->get('bigshop_pint_id'); ?>" target="_blank"> <img src="catalog/view/theme/bigshop/image/pinterest.png" alt="Pinterest" title="Pinterest"> </a>
        <?php } ?>
    </div>

</div>
<script>
    var $menu = $("#mega-1");

    // jQuery-menu-aim: <meaningful part of the example>
    // Hook up events to be fired on menu row activation.
    $menu.menuAim({
        activate: activateSubmenu,
        deactivate: deactivateSubmenu

    });

    function activateSubmenu(row) {
        //s	alert('activateSubmenu');
        var $row = $(row),
                submenuId = $row.data("submenuId"),
                $submenu = $("#" + submenuId),
                height = $menu.outerHeight(),
                width = $menu.outerWidth();

        // Show the submenu
        $submenu.css({
            display: "block",
            //marginTop: "-5em",
            borderLeft: "1px solid #eee",
            left: width - 1  // main should overlay submenu
                    //height: height  // padding for main dropdown's arrow
        });

        // Keep the currently activated row's highlighted look
        $row.find("a").addClass("maintainHover");
      
        //$("#content").animate({opacity:"0.1"}, 100);//вверх
    }

    function deactivateSubmenu(row) {


        var $row = $(row),
                submenuId = $row.data("submenuId"),
                $submenu = $("#" + submenuId);

        // Hide the submenu and remove the row's highlighted look
        $submenu.css("display", "none");
        $row.find("a").removeClass("maintainHover");
        $("a.maintainHover").removeClass("maintainHover");
      
    }

 $("#mega-1").hover(function () {
      
     $("#content").animate({opacity:"0.1"}, 600);//вверх
    },
            function () {
             $("#content").animate({opacity:"1"}, 200);//вверх
                $("div[class^='sub-container mega']").css("display", "none");
                $("a.maintainHover").removeClass("maintainHover");
                $menu.menuAim({
                    activate: activateSubmenu,
                    deactivate: deactivateSubmenu

                });
            });
                
 
    $("div[class^='sub-container']").hover(function () {
        //$(this).css("display", "none"); );
       $("#content").animate({opacity:"0.1"}, 600);//вверх
    },
            function () {
              $("#content").animate({opacity:"1"}, 200);//вверх
                $("div[class^='sub-container mega']").css("display", "none");
                $("a.maintainHover").removeClass("maintainHover");
                $menu.menuAim({
                    activate: activateSubmenu,
                    deactivate: deactivateSubmenu

                });
            });

    $(document).click(function () {

        // Simply hide the submenu on any click. Again, this is just a hacked
        // together menu/submenu structure to show the use of jQuery-menu-aim.
        // $(".popover").css("display", "none");


        $("div[class^='sub-container mega']").css("display", "none");
        $("a.maintainHover").removeClass("maintainHover");
        $menu.menuAim({
            activate: activateSubmenu,
            deactivate: deactivateSubmenu

        });
    });


</script>

</body></html>