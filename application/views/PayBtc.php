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
                  <li><a href="<?= site_url('invoice/id/'.$invoice->cart_hash); ?>"><?= lang("bread_invoice"); ?> #<?= $invoice->id_invoice; ?></a></li>
                  <li class="active"><?= lang("bread_paybtc"); ?></li>
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
                    <h2><?= lang("bread_paybtc"); ?></h2>
                    <div class="body">

                    <h2><?= lang("pay_btc_send"); ?></h2><p id="amount-to-pay" class="label-success"><?= $total_in_btc ?> Btc</p>
                    <h2><?= lang("pay_btc_address"); ?></h2><p id="address" class="label-success"><?= $blockchain_address; ?></p>
                    <h2><?= lang("pay_btc_amountpaid"); ?></h2><p id="amount-paid" class="label-danger">0 Btc</p>
                    
           
                      
                
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>

          


        </div>
      </section>




      <?php include_once('modules/foot.php'); ?>


      <script>
          $(document).ready(function() {
            var check_url = "<?= site_url('invoice/verifypaymentblockchain/'); ?>";
            var root = "https://blockchain.info/";
            var input_address = "<?= $blockchain_address; ?>";
            var amount_to_pay = <?= $total_in_btc ?>;
            function checkBalance() {
                $.ajax({
                    type: "GET",
                    url: root + 'q/getreceivedbyaddress/'+input_address,
                    data : {format : 'plain'},
                    success: function(response) {
                      console.log(response);
                        if (!response) return;

                        var value = parseInt(response);
                        var value_to_btc = value / 100000000;

                        var ndecimals = decimalPlaces(value_to_btc);

                        if (value_to_btc > 0) {
                          
                            $('#amount-paid').html(value_to_btc.toFixed(ndecimals) + " Btc");

                            if(amount_to_pay <= value_to_btc)
                            {

                              $.ajax({
                                  url : check_url,
                                  type: "POST",
                                  data : {
                                    "id": '<?= $invoice->cart_hash ?>'
                                  },
                                  dataType: 'json',
                                  beforeSend: function ()
                                  {
                                      //disableForm(this);
                                  },
                                  success: function(data, textStatus, jqXHR)
                                  {
                                      console.log(data);

                                      if(data.msg_type == 'success')
                                      {
                                        notificationCenterBox('success','Success','Your payment was recieved','<?= site_url('invoice/claim/'); ?>','Claim your product',{ active: true, id_name: 'id', val: '<?= $invoice->cart_hash ?>'});
                                        $('#amount-paid').removeClass('label-danger');
                                        $('#amount-paid').addClass('label-success');

                                      }
                                      else
                                      {
                                        setTimeout(checkBalance, 5000);
                                      }
                                  },
                                  error: function (jqXHR, textStatus, errorThrown)
                                  {
                                      console.log(errorThrown);
                                      console.log(textStatus);
                                      console.log(jqXHR);
                                  }
                              });
 
                          }
                          else
                          {
                            setTimeout(checkBalance, 5000);
                          }
                        } else {
                            setTimeout(checkBalance, 5000);
                        }
                    }
                });
            }
            checkBalance();
            try {
              ws = new WebSocket('wss://ws.blockchain.info/inv');

              if (!ws) return;

              ws.onmessage = function(e) {
                  try {
                      var obj = $.parseJSON(e.data);

                      if (obj.op == 'utx') {
                          var tx = obj.x;

                          var result = 0;
                          for (var i = 0; i < tx.out.length; i++) {
                              var output = tx.out[i];

                              if (output.addr == input_address) {
                                  result += parseInt(output.value);
                              }
                          }
                      }

                      $('#amount-paid').html(result);

                      ws.close();
                  } catch(e) {
                      console.log(e);

                      console.log(e.data);
                  }
              };

              ws.onopen = function() {
                  ws.send('{"op":"addr_sub", "addr":"'+ input_address +'"}');
              };
          } catch (e) {
              console.log(e);
          }

         
          window.onbeforeunload = function() {
              return "Are u sure ? / Estas seguro ?"
          }

        });


      </script>
      
    </div>
  </body>
</html>
