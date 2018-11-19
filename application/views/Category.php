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
                  <li class="active"><?= lang("bread_home"); ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php if(is_array($products_list)): ?>
      <h2 class="text-center"><?= lang("pagedata_products"); ?></h2>
      <!-- PAGE CONTENT -->
      <section id="bestsellers">
        <div class="container">


          <div  class="products-holder simple-grid">

            <?php

            
              foreach ($products_list as $product) {
                if(getStockById($product->product_id) == 0) { $out = TRUE; } else { $out = FALSE; }

            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 ">
              <div class="product-item">
                <div class="head">
                  


                  <div class="thumb">
                    <a href="<?=site_url('home/product/'.$product->product_id) ?>"><img alt="" src="<?= $product->product_image ?>" /></a>
                  </div>

                  <div class="price">

                    <div <?= ($out) ? 'style="background-color: #ec1a3a;"' : ''; ?> class="price-current no-shadow">

                      <?= ($out) ? lang("notif_cart_outstock") : $product->product_fprice ?>
                    </div>
                  </div>

                </div>

                <div class="body">
                  <h3><a href="single-product.html"><?= $product->product_name ?></a></h3>
                
                  <div class="excerpt">
                    <?= substr($product->product_desc, 0, 20); ?> ... <a href="<?=site_url('home/product/'.$product->product_id) ?>"><?= lang("pagedata_seemore"); ?></a>
                  </div>

                  <div class="merged-buttons">
                    <button class="btn-add-to-cart le-btn btn-iconic addtocart" qty="1" pid="<?= $product->product_id ?>"><?= lang("pagedata_addcart"); ?></button>  
                    <button class="btn-add-to-wishlist le-btn btn-iconic addtowish" pid="<?= $product->product_id ?>"><?= lang("pagedata_wishlist"); ?></button> 
                  </div>
                </div>
              </div>
            </div>

           <?php
            }
            $npages = $products_n / 12;
            echo '<p class="text-center col-sm-12">';
            for ($i=1; $i < $npages+1; $i++) { 
              if($i == $actual_page)
              {
                echo '<a href="javascript:void(0)" class="le-btn pnumber small">'.$i.'</a>';
              }
              else
              {
                echo '<a href="'.site_url('home/category/'.$catid.'?p='.$i).'" class="le-btn pnumber small">'.$i.'</a>';
              }
              
            }
            echo '</p>';
            
            else:?>

            <h2 class="text-center"><?= lang("pagedata_noproducts"); ?></h2>
            
            <?php
            endif;
            ?>
          </div>
        </div> 
      </section>


      <?php include_once('modules/foot.php'); ?>
      
    </div>
  </body>
</html>
