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

        <?php $show_cart = 0; include_once('modules/nav.php'); ?>
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
                  <li><?= lang("bread_cart"); ?></li>
                  <li><?= lang("bread_checkout"); ?></li>
                  <li><?= lang("bread_invoice"); ?></li>
                  <li class="active"><?= lang("bread_claim"); ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- PAGE CONTENT -->
      <section id="checkout" class="page-holder ">
        <div class="container no-padding">

          <div class="col-xs-12 col-md-12">
            <div class="box">
              <div class="icon-holder small badge-style">
                <i class="fa fa-dollar "></i>
                <span class="triangle"></span>
              </div>
                  
              <div class="box-holder">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("claim_title"); ?></h2>
                    <div class="body">

                    <?php
                    foreach ($products_claimed as $key => $product) {
                      if(is_numeric($key))
                      {
                        /*for ($i=0; $i < $product->product_qty; $i++) { 
                          echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 text-center"><p>'.$product->product_name.'</p>';
                          echo '<code>'.$products_claimed['data_'.$product->product_id]->product_content_data.'</code></div>';
                        }*/

                        foreach ($products_claimed['data_'.$product->product_id] as $key) {
                          echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 text-center"><p>'.$product->product_name.'</p>';
                          echo '<code>'.$key->product_content_data.'</code></div>';
                        }
                      }
                      else
                      {
                        continue;
                      }
                    }?>
                
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
