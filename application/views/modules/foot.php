<section class="section-footer">
        <div class="container">

          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="footer-column">
              <h2>
                <span class="icon-holder">
                  <i class="fa fa-info"></i>
                  <span class="triangle"></span>
                </span>
                <?= lang("footer_informations"); ?>
              </h2>
              <ul class="footer-links-holder">
                <li><a href="<?= site_url('home'); ?>"><?= lang("menu_home"); ?></a></li> 
              </ul>
            </div>
          </div>

          <!--<div class="col-xs-12 col-sm-6 col-md-3">
            <div class="footer-column">
              <h2>
                <span class="icon-holder">
                  <i class="fa  fa-check"></i>
                  <span class="triangle"></span>
                </span>
                <?= lang("footer_customercare"); ?>
              </h2>
              <ul class="footer-links-holder">
                <li><a href="#">Link</a></li>
              </ul>
            </div>
          </div>-->

          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="footer-column">
              <h2>
                <span class="icon-holder">
                  <i class="fa  fa-user"></i>
                  <span class="triangle"></span>
                </span>
                <?= lang("footer_youraccount"); ?>
              </h2>
              <ul class="footer-links-holder">
              <?php
              if(!$is_logged)
              {
              ?>
                <li><a href="<?= site_url('auth'); ?>"><?= lang("menu_login"); ?></a></li>
                <li><a href="<?= site_url('auth?p=signup'); ?>"><?= lang("menu_signup"); ?></a></li>
                <li><a href="<?= site_url('cart'); ?>"><?= lang("menu_cart"); ?></a></li>
              <?php
              }
              else
              {
              ?>
                <li><a href="<?= site_url('profile'); ?>"><?= lang("menu_myaccount"); ?></a></li>
                <li><a href="<?= site_url('auth/logout'); ?>"><?= lang("menu_logout"); ?></a></li>
                <li><a href="<?= site_url('profile/wishlist'); ?>"><?= lang("menu_mywishlist"); ?></a></li>
              <?php
              }
              ?>
              </ul>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="footer-column">
              <h2>
                <span class="icon-holder">
                  <i class="fa  fa-phone"></i>
                  <span class="triangle"></span>
                </span>
                <?= lang("footer_getintouch"); ?>
              </h2>
              <p>
                <strong><?= $this->config->item('general_email') ?></strong><br>
              </p>
              <ul class="social-icons triangled">
                <!--<li><a href="#" class="fa fa-facebook"></a><div class="triangle"></div></li> 
                <li><a href="#" class="fa fa-google-plus"></a><div class="triangle"></div></li> 
                <li><a href="#" class="fa fa-rss"></a><div class="triangle"></div></li>
                <li><a href="#" class="fa fa-linkedin"></a><div class="triangle"></div></li>-->
              </ul>
            </div>
          </div>
        </div>
      </section>

      <section class="section-copyright">
        <div class="container">
          <div class="copyright col-xs-12 col-sm-5">
            <p>
              <strong>© GetYourGames</strong>. All rights reserved.<br>
              Designed and Made by <a href="http://leohub.com.ve" target="_blank">LeoHub</a>
              
            </p>
          </div>
          <div class="copyright-links col-xs-12 col-sm-7">
            <!--<ul class="inline">
              <li><a href="#">privacy policy</a></li>
              <li><a href="#">terms &amp; conditions</a></li>
              <li><a href="#">site map</a></li>
            </ul>-->
          </div>
        </div>
      </section>
      
      <a class="goto-top" href="#gotop" style="opacity: 1;"></a>

      <script src="<?= asset_url(); ?>js/jquery-3.1.1.min.js"></script>
      <script src="<?= asset_url(); ?>js/bootstrap.min.js"></script>
      <script src="<?= asset_url(); ?>js/bootstrap-hover-dropdown.min.js"></script>
      <script src="<?= asset_url(); ?>js/lobibox.min.js"></script>
      <script src="<?= asset_url(); ?>js/jquery.uploadfile.min.js"></script>
      <script src="<?= asset_url(); ?>js/main.js"></script>

      <?php if(isset($notification)): ?>
      <div id="notification-box" class="modal modal-message modal-<?= $notification['type']; ?> fade" aria-hidden="true">
        <div class="vertical-alignment-helper">
          <div class="modal-dialog vertical-align-center">
              <div class="modal-content">
                  <div class="modal-header">
                      <i class="glyphicon glyphicon-check"></i>
                  </div>
                  <div class="modal-title"><?= $notification['title']; ?></div>
                  <div class="modal-body"><?= $notification['content']; ?></div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-<?= $notification['type']; ?>" data-dismiss="modal">OK</a>
                  </div>
              </div> <!-- / .modal-content -->
          </div> <!-- / .modal-dialog -->
        </div>
      </div>
      <script>
      jQuery(document).ready(function($) {
      $('#notification-box').modal('show');
      });
      </script>
      <?php endif; ?>

      <?php 
      if($admin_not)
      {
      ?>
      <script>
      jQuery(document).ready(function($) {
      <?php 
      foreach ($admin_not as $admin_notification) 
      {
      ?>

        <?php
        if($admin_notification->type == 1)
        {
        ?>
          espnotification('info','<?= lang("admin_name"); ?> : <?=$admin_notification->data['data']['name']; ?> <br> <?= lang("form_email"); ?> : <?=$admin_notification->data['data']['email']; ?> ',<?=$admin_notification->id; ?>, '<?= lang("admin_not_newuser"); ?>');
        <?php
        }
        ?>

        <?php
        if($admin_notification->type == 2)
        {
        ?>
          espnotification('info','<?= lang("admin_not_newinvoice"); ?> : <?= $admin_notification->data->cart_hash ?>',<?=$admin_notification->id; ?>,'<?= lang("admin_not_newinvoice"); ?>','<?= site_url('admin/invoice/'.$admin_notification->data->cart_hash) ?>');
        <?php
        }
        ?>

        <?php
        if($admin_notification->type == 3)
        {
        ?>
          espnotification('info','<?= lang("admin_not_newpayment"); ?>: <?= $admin_notification->value ?>',<?=$admin_notification->id; ?>,'<?= lang("admin_not_newblockchain"); ?>','<?= site_url('admin/invoice/'.$admin_notification->data->cart_hash) ?>');
        <?php
        }
        ?>

        <?php
        if($admin_notification->type == 4)
        {
        ?>
          espnotification('info','<?= lang("admin_not_newsteam"); ?>: <?= $admin_notification->steam ?>',<?=$admin_notification->id; ?>,'<?= lang("admin_not_newsteam"); ?>','<?= site_url('admin/invoice/'.$admin_notification->data->cart_hash) ?>');
        <?php
        }
        ?>



      <?php
      }
      ?>
    });
    </script>

    <?php 
    }
    ?>


