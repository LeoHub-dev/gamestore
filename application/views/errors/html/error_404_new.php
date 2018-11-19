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
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- PAGE CONTENT -->
      <section id="cart" class="page-holder ">
        <div class="container">
          <div class="row ">
            <div class="col-xs-12">
              <div class="shopping-cart-page box">
                <div class="icon-holder small badge-style">
                  <i class="fa fa-shopping-cart "></i>
                  <span class="triangle"></span>
                </div>
           
                <div class="table-responsive cart-table">
                  
                  
                    <h2><?php echo $heading; ?> - <?php echo $message; ?></h2>
                 
                         
              </div>
            </div>
          </div>
        </div>
      </section>


      <?php include_once('modules/foot.php'); ?>
      
    </div>
  </body>
</html>
