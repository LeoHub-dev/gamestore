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
                  <li><a href="<?= site_url('home'); ?>"><?= lang("bread_home"); ?></a></li>
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

          <div class="col-xs-12 col-md-8">
            <div class="box">
              <div class="icon-holder small badge-style">
                <i class="fa fa-user-circle"></i>
                <span class="triangle"></span>
              </div>
                  
              <div <?= (isset($error) || $signup != FALSE) ? ($signup == 'signup' || $error['form'] == 'signup') ? 'style="display: none;"' : '' : ''; ?> class="box-holder login-form">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("menu_login"); ?></h2>
                    <div class="table-form ">
                      <?= form_open('auth/login');?>
                        <div class="field-group">
                          <label><?= lang("form_email"); ?></label>
                          <input type="email" name="email" id="email_input" class="le-input placeholder" placeholder="example@mail.com" required>
                        </div>  
                        <div class="field-group">
                          <label><?= lang("form_password"); ?></label>
                          <input name="password" id="password_input" type="password" placeholder="password" class="le-input placeholder" required>
                        </div> 

                        <?= (isset($error)) ? ($error['form'] == 'login') ? $error['error'] : '' : ''; ?>

                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("form_button_login"); ?></button>
                        </div>
                        <?= form_close();?>

                    </div>
                  </div>
                </div>
                


                </div>
                
              </div>

              <div <?= (isset($error) || $signup != FALSE) ? ($error['form'] == 'signup'  || $signup == 'signup') ? '' : 'style="display: none;"' : 'style="display: none;"'; ?>  class="box-holder signup-form">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("menu_signup"); ?></h2>
                    <div class="table-form ">
                      <?= form_open('auth/signup');?>
                        <div class="field-group">
                          <label><?= lang("form_email"); ?></label>
                          <input type="email" name="email" id="email_input" class="le-input placeholder" placeholder="example@mail.com" required>
                        </div> 

                        <div class="field-group">
                          <label><?= lang("form_first_name"); ?></label>
                          <input type="text" name="name" id="name_input" class="le-input placeholder" placeholder="Name" required>
                        </div>

                        <div class="field-group">
                          <label><?= lang("form_password"); ?></label>
                          <input name="password" id="password_input" type="password" placeholder="password" class="le-input placeholder" required>
                        </div> 

                        <div class="field-group">
                          <label><?= lang("form_passwordconfirm"); ?></label>
                          <input name="repassword" id="repassword_input" type="password" placeholder="password" class="le-input placeholder" required>
                        </div> 

                        <?= (isset($error)) ? ($error['form'] == 'signup') ? $error['error'] : '' : ''; ?>
                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("form_button_signup"); ?></button>
                        </div>
                        <?= form_close();?>

                    </div>
                  </div>
                
                </div>
                
                </div>
                
              </div>

              <div style="display: none;" class="box-holder forgot-form">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("menu_forgot"); ?></h2>
                    <div class="table-form ">
                      <?= form_open('auth/forgotpw',array('id'=>'formForgotPassword'));?>


                        <div class="field-group">
                          <label><?= lang("form_email"); ?></label>
                          <input type="email" name="email" id="email_input" class="le-input placeholder" placeholder="example@mail.com" required>
                        </div>  

                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("form_button_forgot"); ?></button>
                        </div>
                        <?= form_close();?>

                    </div>
                  </div>
                
                </div>
                
                </div>
                
              </div>
         


            </div>
          </div>

          <div class="col-xs-12 col-md-4">


            <div <?= (isset($error) || $signup != FALSE) ? ($error['form'] == 'signup'  || $signup == 'signup') ? 'style="display: none;"' : '' : ''; ?> class="box sidebar login-form">
              <div class="widget simple-widget">
                <div class="icon-holder small">
                  <i class="fa fa-user-circle"></i>
                  <span class="triangle"></span>
                </div>

                <h2><?= lang("menu_signup"); ?></h2>
                <div class="body">
                  <p><?= lang("login_text_noaccount"); ?>
                    <div class="button-holder">
                      <a href="javascript:void(0)" class="le-btn small signup-button"><?= lang("form_button_signup"); ?></a>
                    </div>
                  </p>
                  <p><?= lang("login_text_forgot"); ?>
                    <div class="button-holder">
                      <a href="javascript:void(0)" class="le-btn small forgot-button"><?= lang("button_forgotpw"); ?></a>
                    </div>
                  </p>
                </div>

              </div>
            </div>


            <div <?= (isset($error) || $signup != FALSE) ? ($error['form'] == 'signup'  || $signup == 'signup') ? '' : 'style="display: none;"' : 'style="display: none;"'; ?> class="box sidebar signup-form">
              <div class="widget simple-widget">
                <div class="icon-holder small">
                  <i class="fa fa-user-circle"></i>
                  <span class="triangle"></span>
                </div>

                <h2><?= lang("menu_login"); ?></h2>
                <div class="body">
                  <p><?= lang("login_text_login"); ?>
                    <div class="button-holder">
                      <a href="javascript:void(0)" class="le-btn small login-button"><?= lang("form_button_login"); ?></a>
                    </div>
                  </p>
                </div>
              </div>
            </div>

            <div style="display: none;" class="box sidebar forgot-form">
              <div class="widget simple-widget">
                <div class="icon-holder small">
                  <i class="fa fa-user-circle"></i>
                  <span class="triangle"></span>
                </div>

                <h2><?= lang("menu_login"); ?></h2>
                <div class="body">
                  <p><?= lang("login_text_login"); ?>
                    <div class="button-holder">
                      <a href="javascript:void(0)" class="le-btn small login-button"><?= lang("form_button_login"); ?></a>
                    </div>
                  </p>
                </div>
              </div>
            </div>



          </div>
        </div>
      </section>

 


      <?php include_once('modules/foot.php'); ?>

      <script>
        $("#formForgotPassword").on("submit",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();

          var data = $(this).serialize(); 
          var link = $(this).attr('action');


          $.ajax({
            url : link,
            type: "POST",
            data : data,
            dataType: 'json',
            beforeSend: function ()
            {
              
            },
            success: function(data, textStatus, jqXHR)
            {

              notification(data.msg_type,data.msg_text);
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              console.log(errorThrown);
              console.log(textStatus);
              console.log(jqXHR);
            }
          });
        });
        </script>
      
    </div>
  </body>
</html>
