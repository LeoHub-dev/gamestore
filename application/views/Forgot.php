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
                  <li class="active"><?= lang("bread_auth"); ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- PAGE CONTENT -->
      <section id="checkout" class="page-holder ">
        <div class="container no-padding">

          <div class="col-xs-12 col-md-12 text-center">
            <div class="box">
              <div class="icon-holder small badge-style">
                <i class="fa fa-user-circle"></i>
                <span class="triangle"></span>
              </div>
                  
              <div class="box-holder login-form">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("menu_forgot"); ?></h2>
                    <div class="table-form ">
                      <?= form_open('auth/resetpassword');?>
                      <input type="hidden" name="hash" class="le-input" value="<?= $hash; ?>" required>
                      <input type="hidden" name="email" class="le-input" value="<?= $email; ?>" required>
                        <div class="field-group">
                          <label><?= lang("form_newpassword"); ?></label>
                          <input type="password" name="password" placeholder="******" class="le-input" required>
                        </div>  
                        <div class="field-group">
                          <label><?= lang("form_newpasswordconfirm"); ?></label>
                          <input name="confirm_password" id="password_input" type="password" placeholder="******" class="le-input placeholder" required>
                        </div> 

                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("form_button_modifypassword"); ?></button>
                        </div>
                        <?= form_close();?>

                    </div>
                  </div>
                </div>
                


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
