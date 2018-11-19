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
                  <li><a href="<?= site_url('profile'); ?>"><?= lang("bread_profile"); ?></a></li>
                  <li class="active"><?= lang("bread_wishlist"); ?></li>
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
                <?php if($wishlist != NULL): 
                
                ?>
                
                <div class="table-responsive cart-table">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th class="col-xs-12 col-md-2">preview</th>
                        <th class="col-xs-12 col-md-5">product</th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($wishlist as $product) {

                    ?>
                      <tr class="pid-<?= $product->product_id ?>">
                        <td>
                          <div class="thumb">
                            <img alt="" src="<?= $product->product_image ?>">
                          </div>
                        </td>
                        <td>
                          <div class="desc">
                              <h3><?= $product->product_name ?></h3>
                              <div class="tag-line">
                                <?= $product->product_desc ?>.
                              </div>
                              <div class="pid">Product Code: <?= $product->product_id ?></div>
                          </div>

                        </td>
                        
                        <td>

                          <div class="delete">
                            <a class="close-btn removefromwish" pid="<?= $product->product_id ?>" href="javascript:void(0)"></a>
                          </div>

                        </td>
                      </tr>
                      <?php
                      }
                      ?>

                      
                      



                    </tbody>
                  </table>


                </div>


                <?php 
                  
                  else:
                  
                    ?>
                    <h2><a href="<?= site_url('home'); ?>"><?= lang("pagedata_keepshop"); ?></a></h2>
                    <?php
                  endif;
                  ?>          
              </div>
            </div>
          </div>
        </div>
      </section>


      <?php include_once('modules/foot.php'); ?>
      
    </div>
  </body>
</html>
