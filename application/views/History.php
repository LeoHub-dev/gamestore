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
                  <li class="active"><?= lang("bread_history"); ?></li>
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
                <?php 

                $nh = 1;

                if($history != FALSE):
                ?>
                
                <div class="table-responsive cart-table">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th class="col-xs-12 col-md-2">#</th>
                        <th class="col-xs-12 col-md-5"><?= lang("bread_invoice"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("table_total"); ?></th>
                        <th class="col-xs-12 col-md-2"><?= lang("table_status"); ?></th>
                        <th class="col-xs-12 col-md-1 price-column"></th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($history as $invoice) {

                    ?>
                      <tr>
                        <td>
                          <div class="price">
                            <?= $nh ?>
                          </div>
                        </td>
                        <td>
                          <div class="desc">
                            <a href="<?= site_url('invoice/id/'.$invoice->cart_hash); ?>"><h3><?= $invoice->cart_hash ?></h3></a>
                          </div>

                        </td>
                        <td>

                          <div class="price">
                            <?= $invoice->total_in_usd ?>
                          </div>

                        </td>
                        <td>
                          <h3><?= invoiceStatus($invoice->status) ?></h3>
                        </td>

                        <td>

                          <p>
                            <div class="button-holder">
                              <?php 
                              echo ($invoice->status == $this->config->item('status')['notpaid']) ? '<a href="'.site_url('invoice/id/'.$invoice->cart_hash).'" target="_blank" class="le-btn small">'.lang("pagedata_pay").'</a>' : '';

                              echo ($invoice->status == $this->config->item('status')['paid']) ? '<form action="'.site_url('invoice/claim/').'" class="inline-block" method="post" accept-charset="utf-8"><button type="submit" name="id" value="'.$invoice->cart_hash.'" class="le-btn small">'.lang("pagedata_claim").'</button> </form>' : '';

                              echo ($invoice->status == $this->config->item('status')['claimed']) ? '<a href="'.site_url('invoice/showproducts/'.$invoice->cart_hash).'" target="_blank" class="le-btn small">'.lang("pagedata_viewproducts").'</a>' : '';

                              echo ($invoice->status == $this->config->item('status')['steam']) ? '<a href="'.site_url('invoice/id/'.$invoice->cart_hash).'" target="_blank" class="le-btn small">Send steam name</a>' : '';
                              ?>
                            </div>
                          </p>
                          <p>
                            <div class="button-holder">
                              <a href="<?= site_url('invoice/report/'.$invoice->cart_hash); ?>" target="_blank" class="le-btn small">PDF</a>
                            </div>
                          </p>

                        </td>

                        <td>

                         

                        </td>
                      </tr>
                      <?php
                      $nh++;
                      }
                      ?>

                      
                      



                    </tbody>
                  </table>


                </div>

          

                <?php 
                  else:
                    ?>
                    <h2>History Empty</h2>
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
