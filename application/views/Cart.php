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
                  <li class="active"><?= lang("bread_cart"); ?></li>
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
                <?php if(!$cart_empty) 
                {
                  ?>
                
                <div class="table-responsive cart-table">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th class="col-xs-12 col-md-2"><?= lang("table_preview"); ?></th>
                        <th class="col-xs-12 col-md-5"><?= lang("table_product"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("table_price"); ?></th>
                        <th class="col-xs-12 col-md-2"><?= lang("table_qty"); ?></th>
                        <th class="col-xs-12 col-md-1 price-column"><?= lang("table_total"); ?></th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($cart as $product) {

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

                          <div class="price">
                            <?= $product->product_fprice ?>
                          </div>

                        </td>
                        <td>
                          <div class="le-quantity">
                            <form>
                              <a class="minus" href="#reduce"></a>
                              <input class="item-qty" pid="<?= $product->product_id ?>" name="quantity" readonly="readonly" type="text" value="<?= $product->product_qty ?>">
                              <a class="plus" href="#add"></a>
                            </form>
                          </div>
                        </td>

                        <td>

                          <div class="price price-qty-<?= $product->product_id ?>">
                            <?= $product->product_price*$product->product_qty.' '.$product->product_coin ?>
                          </div>

                        </td>

                        <td>

                          <div class="delete">
                            <a class="close-btn removefromcart" pid="<?= $product->product_id ?>" href="javascript:void(0)"></a>
                          </div>

                        </td>
                      </tr>
                      <?php
                      }
                      ?>

                      
                      



                    </tbody>
                  </table>


                </div>

                <div class="merged-buttons cart-table">
                  <a href="<?= site_url('home'); ?>" class="le-btn small "><?= lang("pagedata_keepshop"); ?></a>
                  <a href="<?= site_url('checkout'); ?>" class="le-btn small"><?= lang("pagedata_checkout"); ?></a>
                </div>  

                <?php 
                  }
                  else
                  {
                    ?>
                    <h2><?= lang("pagedata_cartempty"); ?> - <a href="<?= site_url('home'); ?>"><?= lang("pagedata_keepshop"); ?></a></h2>
                    <?php
                  }
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
