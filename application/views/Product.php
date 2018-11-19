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
                  <li class="active"><?= $product->product_name ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- PAGE CONTENT -->
      <section id="single-product-wide" class="page-holder full-width">
        <div class="container">
        

          <div class="col-xs-12">



            <div id="single-product" class="row">
              <div class="no-margin col-xs-12 col-sm-5 gallery-holder">
                <div class="product-item-holder size-big single-product-gallery small-gallery">
                  <div class="icon-holder small">
                    <i class="fa fa-search-plus "></i>
                    <span class="triangle"></span>
                  </div>

                  <div class="single-product-slider owl-carousel owl-theme" style="opacity: 1; display: block;">
                    <div class="owl-wrapper-outer">
                    <div class="owl-wrapper" style="width: 3632px; left: 0px; display: block; transform: translate3d(0px, 0px, 0px);">
                    <div class="owl-item" style="width: 454px;">
                    <div class="single-product-gallery-item" id="slide1">
                      <a href="<?= $product->product_image ?>" target="_blank">
                        <img class="lazy" alt="" src="<?= $product->product_image ?>" data-original="<?= $product->product_image ?>" style="display: inline;">
                      </a>
                    </div>
                    </div>
                    </div>
                    </div>

                    

                    

                    

                  </div>


                </div>
              </div>

              <div class="no-margin col-xs-12 col-sm-7 body-holder">
                <div class="body">
                  
                  <h3><?= $product->product_name ?></h3>


                  <div class="desc">
                    <p>
                      <?= $product->product_desc ?>
                    </p>
                  </div>


                  <div class="price">
                    <div class="price-current">
                      <span class="currency">$</span><?= $product->product_price ?>
                    </div>
                  </div>







                  <div class="buttons-holder">

                   



                    <div class="inline qnt-holder">
                      <div class="le-quantity">
                            <form style="height: 20px">
                              <a class="minus" href="#reduce"></a>
                              <input id="page-product-qty" name="quantity" readonly="readonly" type="text" value="1">
                              <a class="plus" href="#add"></a>
                            </form>
                      </div>

                    </div>

                    <div class="merged-buttons">
                      <button class="btn-add-to-cart le-btn btn-iconic addtocart" pid="<?= $product->product_id ?>"><?= lang("pagedata_addcart"); ?></button>  
                      <button class="btn-add-to-wishlist le-btn btn-iconic addtowish" pid="<?= $product->product_id ?>"><?= lang("pagedata_wishlist"); ?></button> 
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
