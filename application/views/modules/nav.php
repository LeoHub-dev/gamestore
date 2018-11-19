<?php

if(isset($admin_on))
{
  if($admin_on)
  {
    if(get_http_response_code('https://api.blockchain.info/v2/receive/checkgap?xpub='.$this->config->item('blockchain_xpub').'&key=eb60842a-f5d5-476a-94b9-eb541e037459') != "200")
    {
      echo "Can't connect to xpub";
    }
    else
    {      
      $xpub = json_decode(file_get_contents('https://api.blockchain.info/v2/receive/checkgap?xpub='.$this->config->item('blockchain_xpub').'&key=eb60842a-f5d5-476a-94b9-eb541e037459'));
      if(isset($xpub->gap))
      {
        if($xpub->gap == 20)
        {
          echo '<div class="col-xs-12 text-center" style="background-color:red; color:white;">XPUB GAP ES 20 - CAMBIE EL XPUB</div>';
        }
      }
    }
  }
}
?>

<div id="messageBox" class="modal modal-message fade" style="display: none;" aria-hidden="true">
  <div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center">
        <div class="modal-content">
            <div class="modal-header">
                <i class="glyphicon glyphicon-check"></i>
            </div>
            <div class="modal-title">Title</div>
            <div class="modal-body">You have done great!</div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">OK</a>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
  </div>
</div>


<div class="top-bar">
          <div class="container">
            <div class="col-xs-12 col-sm-6">
              <ul class="info-inline">
                <!--<li>
                  <i class="fa fa-phone"></i> (+90 212) 123 4567
                </li>-->
                <li>
                  <i class="fa fa-envelope"></i> <?= $this->config->item('general_email') ?>
                </li>
              </ul>
            </div>

            <div class="col-xs-12 col-sm-6">
              <ul class="social-icons small">
                <!--<li>
                  <a href="#" class="fa fa-facebook-square"></a>
                </li>
                <li>
                  <a href="#" class="fa fa-twitter-square"></a>
                </li>
                <li>
                  <a href="#" class="fa fa-pinterest-square"></a>
                </li>
                <li>
                  <a href="#" class="fa fa-linkedin-square"></a>
                </li>
                <li>
                  <a href="#" class="fa fa-google-plus-square"></a>
                </li>-->
              </ul>
            </div>                 


          </div>
        </div>

        <div class="container header-row">


          <div class="col-xs-12 col-md-3">
            <div class="buttons-holder">
              <div class="btn-group le-dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                  <?= $lang; ?>
                </a>
                <ul class="dropdown-menu">
                  <?php foreach ($lang_list as $lang_n) { if(substr($lang_n['lang_name'], 0, 3) == $lang) { continue; } ?>
                    <li><a href="<?= site_url('home/setlang/').substr($lang_n['lang_name'], 0, 3).'?gob='.base_url(uri_string()); ?>"><?= $lang_n['lang_name']; ?></a></li>
                  <?php } ?>
                  
                </ul>
              </div>

              <div class="btn-group le-dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                  <i class="fa fa-usd"></i> usd
                </a>
                <ul class="dropdown-menu">
                  <li><a href="#"><i class="gly glyphicon glyphicon-btc"></i> Btc</a></li>
                </ul>
              </div>
            </div>

          </div>


          <div class="col-xs-12 col-md-6">
            <div class="logo">
              <a href="<?= site_url('home'); ?>">
                <img src="<?= asset_url(); ?>images/logo.png" style="display: initial;" class="img-responsive" width="250px" alt="logo">
                <!--<span>KeyStore</span>-->
              </a>
            </div>
          </div>
          <div class="col-xs-12 col-md-3">
            <ul class="link-list inline">
              <?php
              if(!$is_logged)
              {
              ?>
              <li><a href="<?= site_url('auth'); ?>"><?= lang("menu_login"); ?></a></li>
              <li><a href="<?= site_url('auth?p=signup'); ?>"><?= lang("menu_signup"); ?></a></li>
              <li><a href="<?= site_url('cart'); ?>"><?= lang("menu_cart"); ?></a></li>
              <?php
              }
              else
              {
                if(isset($admin_on)) { ?> <li><a href="<?= site_url('admin'); ?>">Admin</a></li> <?php }
              ?>

              <li><a href="<?= site_url('profile'); ?>"><?= lang("menu_myaccount"); ?></a></li>
              <li><a href="<?= site_url('auth/logout'); ?>"><?= lang("menu_logout"); ?></a></li>
              <li><a href="<?= site_url('profile/wishlist'); ?>"><?= lang("menu_mywishlist"); ?></a></li>
              <?php
              }
              ?>
              
            </ul>
          </div>


        </div>

        <div class="container ">

          <div class="top-nav-holder">
          <?php $show_cart = (isset($show_cart)) ? '0' : '1'; ?>
            <div class="row" <?php if($show_cart == 0) { ?> style="margin-right: 0px !important;" <?php } ?>>

              <div class="col-xs-12 col-md-6 col-lg-8  nav-menu top-menu-holder">
                <nav class="hidden-xs visible-sm visible-lg visible-md ">
                  <ul class="nav">

                    <li>
                      <a href="<?= site_url('home'); ?>"><?= lang("menu_home"); ?></a>
                    </li>
                    <?php if($category_nav_list) :
                    foreach ($category_nav_list as $category) {?>
                      <li><a href="<?= site_url('home/category/'.$category->category_id); ?>"><?= $category->category_name ?></a></li>
                    <?php }
                    endif;?>
                    <li>
                      <a href="<?= site_url('cart'); ?>"><?= lang("menu_cart"); ?></a>
                    </li>

                  </ul>

                </nav>

                <select class="top-drop-menu nav hidden-md hidden-sm visible-xs hidden-lg">
      


                  <option label="Homepage" value="<?= site_url('home'); ?>">
                    <?= lang("menu_home"); ?>
                  </option>

                  <?php if($category_nav_list) :
                  foreach ($category_nav_list as $category) {?>
                    <option value="<?= site_url('home/category/'.$category->category_id); ?>"><?= $category->category_name ?></option>
                  <?php }
                  endif;?>

                  <option value="<?= site_url('cart'); ?>">
                    <?= lang("menu_cart"); ?>
                  </option>
                

            
                </select>
              </div>

              <div class="col-xs-12 col-md-3 col-lg-2 no-margin search-holder" <?php if($show_cart == 0) { ?> style="float:right !important" <?php } ?>>
                <div class="searchbox">
                  <a href="" class="fa fa-search search-button">

                  </a>
                  <div class="field">
                    <?= form_open('home/search/');?>
                      <input name="inf" type="text" placeholder="Enter Keyword Here...">
                    </form>
                  </div>
                </div>
              </div>
              <?php 

              

              
              if($show_cart != 0)
              {
              ?>
              

              <div class="col-xs-12 col-md-3 col-lg-2 basket-holder">
                <div class="basket">

                  <div class="dropdown">
                    <a class="dropdown-toggle" data-hover="dropdown" href="#">
                      <div class="basket-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="48px" height="48px" viewBox="0 0 48 48" enable-background="new 0 0 48 48" xml:space="preserve" class="svg replaced-svg">
                        <path d="M38.592,14.169V8.855c0-3.418-2.727-6.2-6.145-6.2H15.693c-3.418,0-6.201,2.781-6.201,6.2v5.313H3.018  c-1.49,0-2.698,1.208-2.698,2.698v5.865c0,1.49,1.208,2.698,2.698,2.698h0.804L6.77,41.624c0.233,1.282,1.351,2.214,2.654,2.214  h29.292c1.304,0,2.42-0.932,2.654-2.215l2.947-16.194h0.75c1.49,0,2.698-1.208,2.698-2.698v-5.865c0-1.49-1.208-2.698-2.698-2.698  H38.592z M14.49,8.855c0-0.652,0.551-1.202,1.203-1.202h16.755c0.652,0,1.147,0.55,1.147,1.202v5.313H14.49V8.855z M18.222,34.196  c0,1.037-0.829,1.877-1.866,1.877c-1.036,0-1.866-0.84-1.866-1.877V23.892c0-1.037,0.83-1.877,1.866-1.877  c1.038,0,1.866,0.841,1.866,1.877V34.196z M25.94,34.196c0,1.037-0.83,1.877-1.866,1.877c-1.036,0-1.867-0.84-1.867-1.877V23.892  c0-1.037,0.831-1.877,1.867-1.877c1.037,0,1.866,0.841,1.866,1.877V34.196z M33.658,34.196c0,1.037-0.83,1.877-1.866,1.877  c-1.037,0-1.866-0.84-1.866-1.877V23.892c0-1.037,0.83-1.877,1.866-1.877c1.036,0,1.866,0.841,1.866,1.877V34.196z"></path>
                        </svg>
                        <span class="item-count">
                          <?= $cart_nitems; ?>
                        </span>
                      </div>

                      <span class="total-price cart-total">
                        <?= $cart_total; ?>
                      </span>
                      <span class="total-price">
                        <?= $lang_coin; ?> 
                      </span>
                      
                    </a>
                    <ul id="top-cart-list-ul" class="dropdown-menu <?= ($cart_nitems > 0) ? '' : 'hidden' ?>">
                    <?php
                    if(!$cart_empty):
                    foreach ($cart as $product) 
                    { ?>
                      <li class="pid-<?= $product->product_id ?>">
                        <div class="basket-item">
                          <div class="row">
                            <div class="col-xs-12 col-sm-2 col-md-4">
                              <div class="thumb">
                                <img alt="" src="<?= $product->product_image; ?>">
                              </div>
                            </div>
                            <div class="col-xs-12 col-sm-10 col-md-8">
                              <div class="title"><?= $product->product_name; ?></div>
                              <div class="price"><?= $product->product_price*$product->product_qty.' '.$product->product_coin; ?></div>
                            </div>
                          </div>
                          <a class="close-btn removefromcart" pid="<?= $product->product_id ?>" href="javascript:void(0)"></a>
                        </div>
                      </li>
                      <?php 
                    }endif;
                    ?>



                      <li class="checkout">
                        <div class="merged-buttons">
                          <a href="<?= site_url('checkout'); ?>" class="btn-add-to-cart le-btn "><?= lang("pagedata_checkout"); ?></a>
                          <a href="<?= site_url('cart'); ?>" class="btn-add-to-wishlist le-btn "><?= lang("pagedata_showcart"); ?></a>
                        </div>

                      </li>
                    </ul>

                  </div>

                </div>
              </div>

              <?php 
              }
              ?>


            </div>

          </div>
        </div>