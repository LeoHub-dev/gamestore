<html>

  <head>

    <?php include_once('modules/head.php'); ?>

  </head>

  <body>

    <div id="preloader">
      <div id="status">&nbsp;</div>
      <noscript>JavaScript is off. Please enable to view full site.</noscript>
    </div>

    <div class="wrapper">

      <header>

        <?php include_once('modules/nav.php'); ?>
      </header>

      <section id="breadcrumb">

        <div class="container">
          <div class="le-breadcrumb inline">
            <div class="iconic-nav-bar">
              <div class="icon-holder">
                <i class="fa fa-chain"></i>
                <span class="triangle"></span>
              </div>
              <div class="bar">
                <ul>
                  <li class="active"><?= lang("bread_profile"); ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- PAGE CONTENT -->
      <section id="checkout" class="page-holder ">
        <div class="container no-padding">

          <div class="col-xs-12 col-md-8">
            <div class="box">
              <div class="icon-holder small badge-style">
                <i class="fa fa-dollar "></i>
                <span class="triangle"></span>
              </div>
                  
              <div class="box-holder">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <h2>Menu</h2>
                    <div class="body">
                    <p>
                      <label> - <?= lang("profile_listshop"); ?></label>
                    </p>
                    <p>
                      <div class="button-holder">
                        <a href="<?= site_url('profile/history/'); ?>" class="le-btn small"><?= lang("admin_menu_listshop"); ?></a>
                      </div>
                    </p>

                    <p>
                      <label> - <?= lang("profile_listwishlist"); ?></label>
                    </p>
                    <p>
                      <div class="button-holder">
                        <a href="<?= site_url('profile/wishlist'); ?>" class="le-btn small"><?= lang("menu_mywishlist"); ?></a>
                      </div>
                    </p>

                    <p>
                      <label> - <?= lang("menu_logout"); ?></label>
                    </p>
                    <p>
                      <div class="button-holder">
                        <a href="<?= site_url('auth/logout/'); ?>" style="background-color: red" class="le-btn small"><?= lang("menu_logout"); ?></a>
                      </div>
                    </p>

                    <?php if($user['data']['id_user'] == 1) { ?>
                    <p>
                      <label> - Admin</label>
                    </p>
                    <p>
                      <div class="button-holder">
                        <a href="<?= site_url('admin'); ?>" class="le-btn small">Admin</a>
                      </div>
                    </p>
                    <?php } ?>

                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="box sidebar">
              <div class="widget simple-widget">
                <div class="icon-holder small badge-style">
                  <i class="fa fa-dollar"></i>
                  <span class="triangle"></span>
                </div>
                <h2><?= lang("bread_profile"); ?> :</h2>
                <div class="body">
                  <p>
                    <label> - <?= lang("form_email"); ?></label>
                  </p>
                  <p>
                    <?= $user['data']['email']; ?>
                  </p>

                  <p>
                    <label> - <?= lang("form_first_name"); ?></label>
                  </p>
                  <p>
                    <?= $user['data']['name']; ?>
                  </p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      <?php include_once('modules/foot.php'); ?>
      
    </div>
  </body>
</html>
