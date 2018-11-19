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
                  <li><a href="<?= site_url('cart'); ?>"><?= lang("bread_cart"); ?></a></li>
                  <li class="active"><?= lang("bread_checkout"); ?></li>
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
                                <?= $product->product_name ?>.
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
                            <?= $product->product_qty ?>
                          </div>
                        </td>

                        <td>

                          <div class="price">
                            <?= $product->product_price*$product->product_qty.' '.$product->product_coin ?>
                          </div>

                        </td>

                        <td>

                        </td>
                      </tr>
                      <?php
                      }
                      ?>
                      
                      <tr>
                        <td>
                          <div class="thumb">
                            
                          </div>
                        </td>
                        <td>
                         
                        </td>
                        <td>

                      

                        </td>
                        <td>
                          <div class="price">
                            <strong><?= lang("table_subtotal"); ?> :</strong>
                          </div>
                        </td>

                        <td>

                          <div class="price price-qty-<?= $product->product_id ?>">
                            <?= $product->product_price*$product->product_qty.' '.$product->product_coin ?>
                          </div>

                        </td>

                        <td>

                         

                        </td>
                      </tr>

                      <tr>
                        <td>
                          <div class="thumb">
                            
                          </div>
                        </td>
                        <td>
                         
                        </td>
                        <td>

                      

                        </td>
                        <td>
                          <div class="price">
                            <strong>Tax :</strong>
                          </div>
                        </td>

                        <td>

                          <div class="price price-qty-<?= $product->product_id ?>">
                            <?= $product->product_price*$product->product_qty.' '.$product->product_coin ?>
                          </div>

                        </td>

                        <td>

                         

                        </td>
                      </tr>

                      <tr>
                        <td>
                          <div class="thumb">
                            
                          </div>
                        </td>
                        <td>
                         
                        </td>
                        <td>

                      

                        </td>
                        <td>
                          <div class="price">
                            
                            <strong><?= lang("table_total"); ?> :</strong>
                            
                          </div>
                        </td>

                        <td>

                          <div class="price price-qty-<?= $product->product_id ?>">

                            <?= $product->product_price*$product->product_qty.' '.$product->product_coin ?>
                            
                          </div>

                        </td>

                        <td>

                         

                        </td>

                      </tr>




                    </tbody>
                  </table>


                </div>

                <div class="merged-buttons cart-table">
                  <a href="<?= site_url('cart'); ?>" class="le-btn small "><?= lang("pagedata_gobcart"); ?></a>
                  <?= form_open('checkout/confirm',array('class'=>'inline-block','method'=>'post'));?>
                  <button type="submit" name="confirm" value="TRUE" class="le-btn small link-button"><?= lang("pagedata_confirmpay"); ?></button>  
                  <?= form_close();?>
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
