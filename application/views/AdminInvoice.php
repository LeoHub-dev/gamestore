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
                  <li><a href="<?= site_url('admin'); ?>"><?= lang("bread_admin"); ?></a></li>
                  <li class="active"><?= lang("bread_invoice"); ?></li>
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
                    <h2></h2>
                    <div class="body">

                      <div class="col-sm-6">

                      <h2><?= lang("admin_invoicedata"); ?> :</h2>

                      <p>
                      <label>Hash : </label> <?= $invoice->cart_hash ?>
                      </p>
                      <p>
                      <label><?= lang("admin_user"); ?> : </label> <?= $userinfo['name'] ?> (<?= $userinfo['email'] ?>)
                      </p>
                      <p>
                      <label><?= lang("table_total"); ?> : </label> <?= $invoice->total_in_usd ?> <?= $lang_coin ?>
                      </p>
                      <p>
                      <label><?= lang("table_date"); ?> : </label> <?= $invoice->date ?>
                      </p>
                      <p>
                      <label><?= lang("table_status"); ?> : </label> <?= invoiceStatus($invoice->status) ?>
                      </p>




                      <h2><?= lang("pagedata_listproducts"); ?> :</h2>
                      <div class="table-responsive cart-table">
                      <table class="table ">
                        <thead>
                          <tr>
                            <th class="col-xs-12 col-md-1 price-column">#</th>
                            <th class="col-xs-12 col-md-3"><?= lang("table_product"); ?></th>
                            <th class="col-xs-12 col-md-2 price-column"><?= lang("table_qty"); ?></th>
                            <th class="col-xs-12 col-md-1 price-column"><?= lang("table_total"); ?></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $nh = 1;
                        foreach ($invoice as $key => $product) 
                        {
                          if(is_numeric($key))
                          {
                            ?>
                           <tr>
                              <td>

                                <div class="price">
                                  <?= $nh ?>
                                </div>

                              </td>
                              <td>
                                <div class="desc">
                                    <?= $product->product_name ?>
                                </div>

                              </td>
                              <td>

                                <div class="price">
                                  <?= $product->product_qty ?>
                                </div>

                              </td>
                              <td>
                                <div class="price">
                                  <?= $product->product_price*$product->product_qty.' '.$product->product_coin ?>
                                </div>
                              </td>

                             
                            </tr>

                          <?php
                          $nh++;
                          }
                          
                        }?>
                        </tbody>
                      </table>



                      </div>
                      </div>

                      <div class="col-sm-6">


                        <h2><?= lang("admin_paymentmade"); ?> (Blockchain):</h2>

                        <?php
                          if($blockchain != FALSE):
                        ?>
                        <p><small>To this address : <?= $blockchain[0]->address ?></small></p>
                        <div class="table-responsive cart-table">
                        <table class="table ">
                          <thead>
                            <tr>
                              <th class="col-xs-12 col-md-3">Hash</th>
                              <th class="col-xs-12 col-md-1 price-column"><?= lang("table_total"); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          
                          foreach ($blockchain as $payment) 
                          {
                            
                              ?>
                             <tr>
                                <td>
                                  <div class="desc">
                                      <?= $payment->transaction_hash ?>
                                  </div>

                                </td>
                                <td>

                                  <div class="price">
                                    <?= $payment->value ?>
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
                          else :
                            ?>
                            <p><?= lang("admin_empty"); ?></p>
                            <?php
                          endif;
                          ?>  
                        


                        <h2><?= lang("admin_steamsend"); ?> :</h2>
                        <?php
                          if($steam != FALSE):
                        ?>
                        <div class="table-responsive cart-table">
                        <table class="table ">
                          <thead>
                            <tr>
                              <th class="col-xs-12 col-md-3">Steam</th>
                              <th class="col-xs-12 col-md-1 price-column"><?= lang("table_date"); ?></th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          
                          foreach ($steam as $payment) 
                          {
                            
                              ?>
                             <tr>
                                <td>
                                  <div class="desc">
                                      <?= $payment->steam_name ?>
                                  </div>

                                </td>
                                <td>

                                  <div class="price">
                                    <?= $payment->date ?>
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
                          else :
                            ?>
                            <p><?= lang("admin_empty"); ?></p>
                            <?php
                          endif;
                          ?>  


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
