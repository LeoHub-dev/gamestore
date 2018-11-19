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
                  <li class="active"><?= lang("bread_invoice"); ?> #<?= $invoice->id_invoice; ?></li>
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
                    <h2><?= lang("bread_invoice"); ?> #<?= $invoice->id_invoice; ?></h2>
                    <div class="body">
                    <blockquote>


                    
                    <li><strong><?= lang("pagedata_listproducts"); ?> :</strong>
                    
                   <ul class="normal-ul">
                      
                    
                    <?php
                    foreach ($invoice as $key => $product) {
                      if(is_numeric($key))
                      {
                        echo '<li class="list-unstyled">'.$product->product_name.' x'.$product->product_qty.' = '.$product->product_price*$product->product_qty.' '.$product->product_coin .'</li>';
                      }
                      else
                      {
                        continue;
                      }
                    }?>
                    </li>

                    </ul>

                    </blockquote>

                    <p>
                    <h4>- <?= lang("pagedata_total_usd"); ?></h4>
                    <?= $invoice->total_in_usd; ?> $
                    </p>
                    <p>
                    <h4>- <?= lang("pagedata_total_btc"); ?></h4>
                    <?= $invoice->total_in_btc; ?> Btc
                    </p>

                    <p>

                    - <?= lang("note_accountbuy"); ?>

                    </p>

                    <p>
                      <div class="button-holder">
                        <a href="<?= site_url('invoice/report/'.$invoice->cart_hash); ?>" target="_blank" class="le-btn small"><?= lang("pagedata_pdf_invoice"); ?></a>
                      </div>
                    </p>
           



                
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
                <h2><?php if($invoice->status == 1) echo lang("pagedata_payment"); else { echo lang("table_status").': '; invoiceStatus($invoice->status); } ?></h2>
                <div class="body">
                <?php if($invoice->status == 1): ?>
                  <p>
                    <div class="button-holder">
                      <a href="<?= site_url('invoice/paybtc/'.$invoice->cart_hash); ?>" class="le-btn small"><?= lang("pagedata_pay"); ?> <?= $invoice->total_in_btc; ?> <?= lang("pagedata_with"); ?> Blockchain</a>
                    </div>
                  </p>
                  <p><?= lang("pagedata_or"); ?></p>
                  <p>
                    <div class="button-holder">
                    

                      <a href="#" onclick="callPayKeys();" class="le-btn small"><?= lang("pay_keys_send"); ?> <?= ceil($invoice->total_in_usd/2); ?> <?= lang("pay_keys_text"); ?> </a>
                    
                    </div>
                  </p>
                  <?php else : ?>

                    <?php 
                  
                    echo ($invoice->status == $this->config->item('status')['paid']) ? '<form action="'.site_url('invoice/claim/').'" class="inline-block" method="post" accept-charset="utf-8"><button type="submit" name="id" value="'.$invoice->cart_hash.'" class="le-btn small">'.lang("pagedata_claim").'</button> </form>' : '';

                    echo ($invoice->status == $this->config->item('status')['claimed']) ? '<a href="'.site_url('invoice/showproducts/'.$invoice->cart_hash).'" target="_blank" class="le-btn small">'.lang("pagedata_viewproducts").'</a>' : '';

                    echo ($invoice->status == $this->config->item('status')['steam']) ? '<a href="#" onclick="callPayKeys();" class="le-btn small">'.lang("pay_keys_send").' '.ceil($invoice->total_in_usd/2).' '.lang("pay_keys_text").'</a> <p> '.lang("note_steamwaiting").' </p>' : '';

                    endif;
                    ?>

                  <script>
                  function callPayKeys()
                  {
                    var msg = '<p><?= lang("pay_keys_send"); ?> <font color="red"> <?= ceil($invoice->total_in_usd/2); ?> <?= lang("pay_keys_text"); ?></font> <?= lang("pay_keys_account"); ?> </p><p><code> <a href="https://steamcommunity.com/tradeoffer/new/?partner=40577209&token=b79f8xN8" target="_blank"><font color="#c7254e">https://steamcommunity.com/tradeoffer/new/?partner=40577209&token=b79f8xN8</font></a></code></p> <div class="caption italic"><strong><?= lang("pay_keys_note"); ?> :</strong><p><?= lang("pay_keys_notetxt"); ?></p> </div> <div class="caption"><strong><?= lang("pay_keys_notice"); ?> :</strong><p><?= lang("pay_keys_noticetxt"); ?> <font color="red"><?= lang("form_send"); ?></font>.</p> </div><form action="<?= site_url('invoice/paykeys'); ?>" class="inline-block" method="post" accept-charset="utf-8"><div class="field-group"><label><?= lang("pay_keys_steam"); ?> : </label> <input type="text" name="steamuser" id="steamuser_input" class="le-input placeholder" data-placeholder="GetYourGames"><input type="hidden" name="invoice_hash" value="<?= $invoice->cart_hash; ?>"></div><button type="submit" class="btn btn-success"><?= lang("form_send"); ?></button></form>';

                    notificationCenterBox('success','<?= lang("pagedata_pay"); ?> <?= lang("pagedata_with"); ?> <?= lang("pay_keys_text"); ?>',msg,'#','ok',{ active: true, id_name: 'id', val: 'sas'},false);

                  }
                  </script>



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
