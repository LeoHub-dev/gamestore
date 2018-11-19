<html>

  <head>

    <?php include_once('modules/head.php'); ?>

  </head>

  <body>


  <div id="adminedit" role="dialog" class="modal fade">
    <div class="vertical-alignment-helper">
      <div class="modal-dialog vertical-align-center">
          <div class="modal-content">
              <div class="modal-header">
                  <i class="glyphicon glyphicon-pencil"></i>  <?= lang("admin_edit"); ?>
              </div>
              <div class="modal-title"></div>
              <div class="modal-body">
              
              <?php 
              if($format == 1) //Edit user
              {
                ?>
                <form action="<?= site_url('admin/edit'); ?>" class="block" method="post" id="formEdit" accept-charset="utf-8">
                <input type="hidden" name="edit-id" id="edit-id" required>
                <input type="hidden" name="edit-type" id="edit-type" required>
                    <?php foreach ($lang_list as $lang_n) { ?>
                      <div class="field-group col-sm-12">
                      <label><?= lang("admin_name"); ?> <?= $lang_n['lang_name'] ?></label> 
                      <input type="text" name="name[<?= $lang_n['lang_id'] ?>]" id="name-<?= $lang_n['lang_id'] ?>" class="le-input">
                      </div>
                    <?php } ?>


                  

                  <div class="field-group">
                    <label><?= lang("admin_image"); ?></label>
                    <div id="imageupload">Subir</div>
                    <input type="hidden" name="image" id="image_input" class="le-input" required>
                  </div> 



                  <?php foreach ($lang_list as $lang_n) { ?>
                    <div class="field-group col-sm-6">
                      <label><?= lang("admin_desc"); ?> <?= $lang_n['lang_name'] ?></label>
                      <textarea name="desc[<?= $lang_n['lang_id']?>]" id="desc-<?= $lang_n['lang_id'] ?>" class="le-input" rows="5" cols="30"></textarea>
                    </div>
                  <?php } ?>

                <div class="field-group col-sm-6">
                  <label><?= lang("admin_category"); ?></label>
                  <select id="list_category" name="category" class="le-input" required>
                  <?php if($category_list) :
                  foreach ($category_list as $category) {?>
                    <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                  <?php } 
                  else :

                    echo '<option disabled selected value>'.lang("admin_empty").'</option>';

                  endif;?>
                  </select>
                </div> 

                <div class="field-group col-sm-3">
                  <label><?= lang("admin_price"); ?></label>
                  <input type="number" name="price" id="price_input" class="le-input placeholder" data-placeholder="0" step="any" required>
                </div> 

                <div class="field-group col-sm-3">
                    <label><?= lang("table_status"); ?></label>
                    <select id="product-status" name="status" class="le-input" required>
                    <option value="0"><?= lang("admin_inactive"); ?></option>
                    <option value="1"><?= lang("admin_active"); ?></option>
                    </select>
                  </div>

                <button type="submit" class="btn btn-success le-btn btn-block"><?= lang("form_send"); ?></button>

                </form>
              <?php 
              } 
              ?>

              <?php 
              if($format == 2) //Edit Stock
              {
                ?>
                <form action="<?= site_url('admin/edit'); ?>" class="block" method="post" id="formEdit" accept-charset="utf-8">
                <input type="hidden" name="edit-id" id="edit-id" required>
                <input type="hidden" name="edit-type" id="edit-type" required>
        
                  <div class="field-group col-sm-6">
                    <label><?= lang("admin_product"); ?></label>
                    <select id="stock-idproduct" class="le-input" name="product" required>
                    <?php if($products_list) :
                    foreach ($products_list as $product) {?>
                      <option value="<?= $product->product_id ?>"><?= $product->product_name ?></option>
                    <?php } 
                    else :

                      echo '<option disabled selected value>'.lang("admin_empty").'</option>';

                    endif;?>
                    </select>
                  </div>

                  <div class="field-group col-sm-6">
                    <label><?= lang("table_status"); ?></label>
                    <select id="stock-status" name="status" class="le-input" required>
                    <option value="0"><?= lang("admin_notclaim"); ?></option>
                    <option value="1"><?= lang("admin_claim"); ?></option>
                    </select>
                  </div>

                  <div class="field-group col-sm-12">
                    <label><?= lang("table_data"); ?> </label>
                    <textarea name="data" id="stock-data" class="le-input" rows="5" cols="30" required></textarea>
                  </div>

                <button type="submit" class="btn btn-success le-btn btn-block"><?= lang("form_send"); ?></button>

                </form>
              <?php 
              } 
              ?>

              <?php 
              if($format == 3) //Edit user
              {
                ?>
                <form action="<?= site_url('admin/edit'); ?>" class="block" method="post" id="formEdit" accept-charset="utf-8">
                <input type="hidden" name="edit-id" id="edit-id" required>
                <input type="hidden" name="edit-type" id="edit-type" required>
        
                  
                  <div class="field-group col-sm-6">
                    <label><?= lang("admin_name"); ?></label>
                    <input type="text" name="name" id="name_input" class="le-input placeholder" data-placeholder="http://image.com" required>
                  </div>

                  <div class="field-group col-sm-6">
                    <label><?= lang("form_email"); ?></label>
                    <input type="email" name="email" id="email_input" class="le-input" placeholder="email@email.com" required>
                  </div> 

                  <div class="field-group col-sm-6">
                    <label><?= lang("form_password"); ?></label>
                    <input type="password" name="password" id="password_input" class="le-input" placeholder="*******" required>
                  </div> 

                  <div class="field-group col-sm-6">
                    <label><?= lang("table_status"); ?></label>
                    <select id="user-status" name="status" class="le-input" required>
                    <option value="0"><?= lang("admin_inactive"); ?></option>
                    <option value="1"><?= lang("admin_active"); ?></option>
                    </select>
                  </div>

                  

                <button type="submit" class="btn btn-success le-btn btn-block"><?= lang("admin_edit"); ?></button>

                </form>
              <?php 
              } 
              ?>

              <?php 
              if($format == 4) //Edit invoice
              {
                ?>
                <form action="<?= site_url('admin/edit'); ?>" class="block" method="post" id="formEdit" accept-charset="utf-8">
                <input type="hidden" name="edit-id" id="edit-id" required>
                <input type="hidden" name="edit-type" id="edit-type" required>

                  <div class="field-group col-sm-6">
                    <label><?= lang("admin_user"); ?></label>
                    <select id="invoice_user" class="le-input" name="user" required>
                    <?php if($users_list) :
                    foreach ($users_list as $user) {?>
                      <option value="<?= $user->id_user ?>"><?= $user->email ?></option>
                    <?php } 
                    else :

                      echo '<option disabled selected value>'.lang("admin_empty").'</option>';

                    endif;?>
                    </select>
                  </div>

                  <div class="field-group col-sm-6">
                    <label><?= lang("table_total"); ?> $</label>
                    <input type="number" name="totalusd" id="invoice_totalusd" class="le-input" step="any" min="0.0001" required>
                  </div> 

                  <div class="field-group col-sm-6">
                    <label><?= lang("table_status"); ?></label>
                    <select id="invoice_status" class="le-input" name="status" required>
                    <?php $status_list = invoiceStatusList() ; if($status_list) :
                    foreach ($status_list as $status) {?>
                      <option value="<?= $status->id_status ?>"><?= $status->name ?></option>
                    <?php } 
                    else :

                      echo '<option disabled selected value>'.lang("admin_empty").'</option>';

                    endif;?>
                    </select>
                  </div>
  
                <button type="submit" class="btn btn-success le-btn btn-block"><?= lang("admin_edit"); ?></button>

                </form>
              <?php 
              } 
              ?>


              </div> 
              <div class="modal-footer">
                  <a href="#" class="btn btn-danger le-btn danger" data-dismiss="modal"><?= lang("admin_close"); ?></a>
              </div>
          </div> <!-- / .modal-content -->
      </div> <!-- / .modal-dialog -->
    </div>
  </div>

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
                  <li class="active"><?= lang("bread_list"); ?></li>
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

                if($total_list != FALSE):
                ?>
                
                <div class="table-responsive cart-table">
                  <table class="table ">
                    <thead>

                    <?php 
                    if($format == 1)//Products
                    {
                      ?>

                      <tr>
                        <th class="col-xs-12 col-md-1 price-column">#</th>
                        <th class="col-xs-12 col-md-2"><?= lang("table_preview"); ?></th>
                        <th class="col-xs-12 col-md-4"><?= lang("table_product"); ?></th>
                        <th class="col-xs-12 col-md-1"><?= lang("table_price"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("table_status"); ?></th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    <?php 
                    } 
                    ?>

                    <?php 
                    if($format == 2) //Stock
                    {
                      ?>
                      <tr>
                        <th class="col-xs-12 col-md-1 price-column">#</th>
                        <th class="col-xs-12 col-md-3"><?= lang("table_product"); ?></th>
                        <th class="col-xs-12 col-md-5"><?= lang("table_data"); ?></th>
                        <th class="col-xs-12 col-md-3"><?= lang("table_status"); ?></th>
                        <th class="col-xs-12 col-md-1">&nbsp;</th>
                      </tr>
                    <?php 
                    } 
                    ?>

                    <?php 
                    if($format == 3) //Users
                    {
                      ?>
                      <tr>
                        <th class="col-xs-12 col-md-1 price-column">#</th>
                        <th class="col-xs-12 col-md-4"><?= lang("form_first_name") ?></th>
                        <th class="col-xs-12 col-md-5"><?= lang("form_email") ?></th>
                        <th class="col-xs-12 col-md-2"><?= lang("table_status"); ?></th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    <?php 
                    } 
                    ?>

                    <?php 
                    if($format == 4) //Compras
                    {
                      ?>
                      <tr>
                        <th class="col-xs-12 col-md-1">#</th>
                        <th class="col-xs-12 col-md-5"><?= lang("bread_invoice"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("table_total"); ?></th>
                        <th class="col-xs-12 col-md-2"><?= lang("table_status"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("table_date"); ?></th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    <?php 
                    } 
                    ?>

                    <?php 
                    if($format == 5) //Blockchain
                    {
                      ?>
                      <tr>
                        <th class="col-xs-12 col-md-1">#</th>
                        <th class="col-xs-12 col-md-5"><?= lang("bread_invoice"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("pay_btc_amountpaid"); ?></th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    <?php 
                    } 
                    ?>

                    <?php 
                    if($format == 6) //Steam
                    {
                      ?>
                      <tr>
                        <th class="col-xs-12 col-md-1">#</th>
                        <th class="col-xs-12 col-md-5"><?= lang("bread_invoice"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("pay_keys_steam"); ?></th>
                        <th class="col-xs-12 col-md-2 price-column"><?= lang("table_date"); ?></th>
                        <th class="col-xs-12 col-md-2">&nbsp;</th>
                      </tr>
                    <?php 
                    } 
                    ?>


                    </thead>
                    <tbody>
                    <?php

                    foreach ($total_list as $list) {

                      if($format == 1)
                      {

                    ?>
                      <tr class="pid-<?= $list->product_id ?>">
                        <td>
                          <div class="price">
                            <?= $nh ?>
                          </div>
                        </td>
                        
                        <td>
                        <div class="thumb">
                            <img alt="" src="<?= $list->product_image ?>">
                          </div>
                          
                        </td>

                        <td>
                          <div class="desc">
                            <h3><?= $list->product_name ?></h3>
                            <div class="tag-line">
                              <?= $list->product_desc ?>.
                            </div>
                          </div>

                        </td>

                        <td>

                          <div class="price">
                            <?= $list->product_price ?>
                          </div>

                        </td>

                        <td>
                          <h3><?= ($list->product_active == 0) ? lang("admin_inactive") : lang("admin_active") ?></h3>
                        </td>

                        <td>

                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" pid="<?= $list->product_id ?>" style="background-color: red" class="le-btn small delete-product"><?= lang("admin_delete"); ?></a>
                            </div>
                          </p>

                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" onclick="getInfoEdit(<?= $list->product_id ?>,'product');" class="le-btn small edit-product"><?= lang("admin_edit"); ?></a>
                            </div>
                          </p>

                        </td>

                        </td>
                      </tr>
                      <?php
                      }
                      else if($format == 2) //Stock
                      {

                    ?>
                      <tr class="pid-<?= $list->stock_id ?>">

                        <td>
                          <div class="price">
                            <?= $nh ?>
                          </div>
                        </td>

                        <td>
                          <div class="desc">
                            <h3><?= $list->product_name ?></h3>
                          </div>

                        </td>

                        <td>
                          <div class="desc">
                            <h3><?= $list->product_data ?></h3>
                          </div>

                        </td>

                        <td>

                          <div class="price">
                            <?= ($list->product_status == 0) ? lang("admin_notclaim") : lang("admin_claim") ?>
                          </div>

                        </td>

                
                        <td>
                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" pid="<?= $list->stock_id ?>" style="background-color: red" class="le-btn small delete-stock"><?= lang("admin_delete"); ?></a>
                            </div>
                          </p>

                          <p>
                            <div class="button-holder">
                              <a pid="<?= $list->stock_id ?>" href="javascript:void(0)" onclick="getInfoEdit(<?= $list->stock_id ?>,'stock');" class="le-btn small edit-product"><?= lang("admin_edit"); ?></a>
                            </div>
                          </p>

                        </td>

                        </td>
                      </tr>
                      <?php
                      }else if($format == 3) //User
                      {

                    ?>
                      <tr class="pid-<?= $list->id_user ?>">

                        <td>
                          <div class="price">
                            <?= $nh ?>
                          </div>
                        </td>


                        <td>
                          <div class="desc">
                            <h3><?= $list->name ?></h3>
                          </div>
                        </td>
                        
                        

                        <td>
                          <div class="desc">
                            <h3><?= $list->email ?></h3>
                          </div>

                        </td>

                        <td>

                          <div class="price">
                            <h3><?= ($list->active == 0) ? 'Inactivo' : 'Activo' ?></h3>
                          </div>

                        </td>

                        <td>
                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" pid="<?= $list->id_user ?>" style="background-color: red" class="le-btn small delete-user"><?= lang("admin_delete"); ?></a>
                            </div>
                          </p>

                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" onclick="getInfoEdit(<?= $list->id_user ?>,'user');" class="le-btn small"><?= lang("admin_edit"); ?></a>
                            </div>
                          </p>

                          
                        </td>

                       

                      
                      </tr>
                      <?php
                      }else if($format == 4)
                      {

                    ?>
                      <tr class="pid-<?= $list->id_invoice ?>">

                        <td>
                          <div class="price">
                            <?= $nh ?>
                          </div>
                        </td>
                        <td>
                          <div class="desc">
                            <a href="<?= site_url('admin/invoice/'.$list->cart_hash); ?>"><h3><?= $list->cart_hash ?></h3></a>
                          </div>
                          <div class="tag-line">
                            <?= lang("form_first_name") ?> : <?php $user = getUserById($list->id_user); echo $user->email; echo ' ('.$user->name.')'; ?>.
                          </div>

                        </td>
                        <td>

                          <div class="price">
                            <?= $list->total_in_usd ?>
                          </div>

                        </td>
                        <td>
                          <h3><?= invoiceStatus($list->status) ?></h3>
                        </td>

                        <td>
                          <div class="price">
                            <?= $list->date ?>
                          </div>
                        </td>

                        <td>

                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" pid="<?= $list->id_invoice ?>" style="background-color: red" class="le-btn small delete-invoice"><?= lang("admin_delete"); ?></a>
                            </div>
                          </p>

                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" onclick="getInfoEdit(<?= $list->id_invoice ?>,'invoice');" class="le-btn small"><?= lang("admin_edit"); ?></a>
                            </div>
                          </p>

                          <p>
                            <div class="button-holder">
                              <a href="<?= site_url('invoice/report/'.$list->cart_hash); ?>" target="_blank" class="le-btn small">PDF</a>
                            </div>
                          </p>

                        </td>

                        

                       

                      
                      </tr>
                      <?php
                      }else if($format == 5) //BLOCKCHAIN
                      {

                    ?>
                      <tr class="pid-<?= $list->transaction_hash ?>">

                        <td>
                          <div class="price">
                            <?= $nh ?>
                          </div>
                        </td>
                        <td>
                          <div class="desc">
                            <a href="<?= site_url('admin/invoice/'.$list->cart_hash); ?>"><h3><?= $list->cart_hash ?></h3></a>
                          </div>
                          <div class="tag-line">
                            Address : <?= $list->address ?>
                          </div>


                        </td>
                        <td>

                          <div class="price">
                            <?= $list->value ?>
                          </div>

                        </td>
                       

                        <td>


                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" pid="<?= $list->transaction_hash ?>" style="background-color: red" class="le-btn small delete-blockchain"><?= lang("admin_delete"); ?></a>
                            </div>
                          </p>

                         

                        </td>

                    
                      </tr>
                      <?php
                      }else if($format == 6) //STEAM
                      {

                    ?>
                      <tr class="pid-<?= $list->id_csgo ?>">

                        <td>
                          <div class="price">
                            <?= $nh ?>
                          </div>
                        </td>
                        <td>
                          <div class="desc">
                            <a href="<?= site_url('admin/invoice/'.$list->cart_hash); ?>"><h3><?= $list->cart_hash ?></h3></a>
                          </div>

                        </td>
                        <td>

                          <div class="desc">
                            <?= $list->steam_name ?>
                          </div>

                        </td>

                        <td>

                          <div class="price">
                            <?= $list->date ?>
                          </div>

                        </td>
                       

                        <td>


                          <p>
                            <div class="button-holder">
                              <a href="javascript:void(0)" pid="<?= $list->id_csgo ?>" style="background-color: red" class="le-btn small delete-steam"><?= lang("admin_delete"); ?></a>
                            </div>
                          </p>

     
                        </td>

                    
                      </tr>
                      <?php
                      }
                      $nh++;
                      }
                      ?>

                      
                      



                    </tbody>
                  </table>


                </div>

          

                <?php 
                  else:
                    ?>
                    <h2><?= lang("admin_empty"); ?></h2>
                    <?php
                  endif;
                  ?>          
              </div>
            </div>
          </div>
        </div>
      </section>


      <?php include_once('modules/foot.php'); ?>

      <script type="text/javascript">

          $("#imageupload").uploadFile({
            url:"uploadimg/",
            dragDropStr: "<span><b>Arrastra & Suelta tu Imagen</b></span>",
            uploadStr:"Subir",
            fileName:"imgPelicula",
            showPreview:true,
            previewHeight: "100px",
            previewWidth: "100px",
            acceptFiles:"image/*",
            showDelete: true,
            onSuccess:function(files,data,xhr,pd)
            {
              var img = JSON.parse(data);

              $("#image_input").val(img);
            }
          });

          $(".delete-product").on("click",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            if (confirm('<?= lang("admin_not_delproduct"); ?>')) {
              
            } else {
              return;
            }

            

            var id = $(this).attr('pid');

            $.ajax({
                url : "../admin/removeproduct",
                type: "POST",
                data : {
                  "id": id
                },
                dataType: 'json',
                beforeSend: function ()
                {
                  //disableForm(this);
                },
                success: function(data, textStatus, jqXHR)
                {
                    console.log(data);
                    
                    notification(data.msg_type,data.msg_text);

                    if(data.msg_type != 'error')
                    {
                      $('.pid-'+id).fadeOut(function() {

                        $(this).remove();

                        if($('.cart-table tbody tr').length <= 0)
                        {
                          $('.cart-table').html('<h2><?= lang("admin_empty"); ?></h2>');
                        }
                      })

                      
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
          });

          $(".delete-stock").on("click",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            if (confirm('<?= lang("admin_not_delstock"); ?>')) {
              
            } else {
              return;
            }

            

            var id = $(this).attr('pid');

            $.ajax({
                url : "../admin/removestock",
                type: "POST",
                data : {
                  "id": id
                },
                dataType: 'json',
                beforeSend: function ()
                {
                  //disableForm(this);
                },
                success: function(data, textStatus, jqXHR)
                {
                    console.log(data);
                    
                    notification(data.msg_type,data.msg_text);

                    if(data.msg_type != 'error')
                    {
                      $('.pid-'+id).fadeOut(function() {

                        $(this).remove();

                        if($('.cart-table tbody tr').length <= 0)
                        {
                          $('.cart-table').html('<h2><?= lang("admin_empty"); ?></h2>');
                        }
                      })

                      
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
          });

          $(".delete-user").on("click",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            if (confirm('<?= lang("admin_not_deluser"); ?>')) {
              
            } else {
              return;
            }

            

            var id = $(this).attr('pid');

            $.ajax({
                url : "../admin/removeuser",
                type: "POST",
                data : {
                  "id": id
                },
                dataType: 'json',
                beforeSend: function ()
                {
                  //disableForm(this);
                },
                success: function(data, textStatus, jqXHR)
                {
                    console.log(data);
                    
                    notification(data.msg_type,data.msg_text);

                    if(data.msg_type != 'error')
                    {
                      $('.pid-'+id).fadeOut(function() {

                        $(this).remove();

                        if($('.cart-table tbody tr').length <= 0)
                        {
                          $('.cart-table').html('<h2><?= lang("admin_empty"); ?></h2>');
                        }
                      })

                      
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
          });

          $(".delete-invoice").on("click",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            if (confirm('<?= lang("admin_not_delinvoice"); ?>')) {
              
            } else {
              return;
            }

          
            var id = $(this).attr('pid');

            $.ajax({
                url : "../admin/removeinvoice",
                type: "POST",
                data : {
                  "id": id
                },
                dataType: 'json',
                beforeSend: function ()
                {
                  //disableForm(this);
                },
                success: function(data, textStatus, jqXHR)
                {
                    console.log(data);
                    
                    notification(data.msg_type,data.msg_text);

                    if(data.msg_type != 'error')
                    {
                      $('.pid-'+id).fadeOut(function() {

                        $(this).remove();

                        if($('.cart-table tbody tr').length <= 0)
                        {
                          $('.cart-table').html('<h2><?= lang("admin_empty"); ?></h2>');
                        }
                      })

                      
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
          });

          $(".delete-blockchain").on("click",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            if (confirm('<?= lang("admin_not_delblock"); ?>')) {
              
            } else {
              return;
            }

            

            var id = $(this).attr('pid');

            $.ajax({
                url : "../admin/removeblockchain",
                type: "POST",
                data : {
                  "id": id
                },
                dataType: 'json',
                beforeSend: function ()
                {
                  //disableForm(this);
                },
                success: function(data, textStatus, jqXHR)
                {
                    console.log(data);
                    
                    notification(data.msg_type,data.msg_text);

                    if(data.msg_type != 'error')
                    {
                      $('.pid-'+id).fadeOut(function() {

                        $(this).remove();

                        if($('.cart-table tbody tr').length <= 0)
                        {
                          $('.cart-table').html('<h2><?= lang("admin_empty"); ?></h2>');
                        }
                      })

                      
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
          });

          $(".delete-steam").on("click",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            if (confirm('<?= lang("admin_not_delsteam"); ?>')) {
              
            } else {
              return;
            }

            

            var id = $(this).attr('pid');

            $.ajax({
                url : "../admin/removesteam",
                type: "POST",
                data : {
                  "id": id
                },
                dataType: 'json',
                beforeSend: function ()
                {
                  //disableForm(this);
                },
                success: function(data, textStatus, jqXHR)
                {
                    console.log(data);
                    
                    notification(data.msg_type,data.msg_text);

                    if(data.msg_type != 'error')
                    {
                      $('.pid-'+id).fadeOut(function() {

                        $(this).remove();

                        if($('.cart-table tbody tr').length <= 0)
                        {
                          $('.cart-table').html('<h2><?= lang("admin_empty"); ?></h2>');
                        }
                      })

                      
                    }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    console.log(textStatus);
                    console.log(jqXHR);
                }
            });
          });

          $.fn.serializeObject = function()
          {
              var o = {};
              var a = this.serializeArray();
              $.each(a, function() {
                  if (o[this.name] !== undefined) {
                      if (!o[this.name].push) {
                          o[this.name] = [o[this.name]];
                      }
                      o[this.name].push(this.value || '');
                  } else {
                      o[this.name] = this.value || '';
                  }
              });
              return o;
          };

          $("#formEdit").on("submit",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            if (confirm('<?= lang("admin_not_edit"); ?>')) {
              
            } else {
              return;
            }

            

            var data = $(this).serialize(); 
            var link = $(this).attr('action');

            var new_data = $(this).serializeObject();

            console.log(new_data);

            $.ajax({
              url : link,
              type: "POST",
              data : data,
              dataType: 'json',
              beforeSend: function ()
              {
                
              },
              success: function(data, textStatus, jqXHR)
              {
                console.log(data);
                  
                notification(data.msg_type,data.msg_text);

                updateInfoTable(new_data);

                /*setTimeout(function(){
                  location.reload();
                }, 1000);*/

                $("#adminedit").modal('hide');

              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(jqXHR);
              }
            });
          });

          function invoiceStatusText(id)
          {
            if(id == 1)
            {
              return '<font color="red"><?= lang("status_notpaid") ?></font>';
            }

            if(id == 2)
            {
              return '<font color="#1da796"><?= lang("status_paid") ?></font>';
            }

            if(id == 3)
            {
              return '<font color="black"><?= lang("status_claimed") ?></font>';
            }

            if(id == 4)
            {
              return '<font color="black"><?= lang("status_steam") ?></font>';
            }
          }

          function statusText(id)
          {
            if(id == 1)
            {
              return '<?= lang("admin_active") ?>';
            }

            if(id == 0)
            {
              return '<?= lang("admin_inactive") ?>';
            }

          }

          $('#adminedit').on('hidden.bs.modal', function () {
            $('#formEdit').trigger("reset");
          })

          function updateInfoTable(formData)
          {
            if(formData['edit-type'] == 'product')
            {
              if(formData['image'].toLowerCase().indexOf("http") >= 0)
              {
                $('.pid-'+formData['edit-id']+' td:nth-child(2)').children().children('img').attr('src',formData['image']);
              }
              else
              {
                $('.pid-'+formData['edit-id']+' td:nth-child(2)').children().children('img').attr('src','<?= asset_url().'pimg/'; ?>'+formData['image']);
              }
              $('.pid-'+formData['edit-id']+' td:nth-child(3)').children().children('.tag-line').html(formData['desc[<?= $lang_id ?>]']);
              $('.pid-'+formData['edit-id']+' td:nth-child(3)').children().children('h3').html(formData['name[<?= $lang_id ?>]']);
              $('.pid-'+formData['edit-id']+' td:nth-child(4)').children().html(formData['price']);
              $('.pid-'+formData['edit-id']+' td:nth-child(5)').children().html(statusText(formData['status']));
            }
            else if(formData['edit-type'] == 'stock')
            {
              $('.pid-'+formData['edit-id']+' td:nth-child(2)').children().children().html($("#stock-idproduct option[value='"+formData['product']+"']").text());
              $('.pid-'+formData['edit-id']+' td:nth-child(3)').children().children().html(formData['data']);
              $('.pid-'+formData['edit-id']+' td:nth-child(4)').children().html($("#stock-status option[value='"+formData['status']+"']").text());
            }
            else if(formData['edit-type'] == 'user')
            {
              $('.pid-'+formData['edit-id']+' td:nth-child(2)').children().children().html(formData['name']);
              $('.pid-'+formData['edit-id']+' td:nth-child(3)').children().children().html(formData['email']);
              $('.pid-'+formData['edit-id']+' td:nth-child(4)').children().children().html(statusText(formData['status']));
            }
            else if(formData['edit-type'] == 'invoice')
            {
              $('.pid-'+formData['edit-id']+' td:nth-child(2)').children('.tag-line').html("<?= lang("form_first_name") ?> : "+$("#invoice_user option[value='"+formData['user']+"']").text());
              $('.pid-'+formData['edit-id']+' td:nth-child(3)').children().html(formData['totalusd']);
              $('.pid-'+formData['edit-id']+' td:nth-child(4)').children().children().html(invoiceStatusText(formData['status']));
            }
          }


          function loadInfoEditModal(data,type)
          {
            $("#adminedit").modal();

            if(type == 'product')
            {
              $.each(data.product_name, function(i){
                $('#name-'+i).val(data.product_name[i]);
              })
              $('#image_input').val(data.product_image);
              $.each(data.product_desc, function(i){
                $('#desc-'+i).val(data.product_desc[i]);
              })
              $('#category_list').val(data.product_category);
              $('#price_input').val(data.product_price);
              $('#product-status').val(data.product_status);

            }
            else if(type == 'stock')
            {
              $('#stock-idproduct').val(data.stock_idproduct);
              $('#stock-status').val(data.stock_status);
              $('#stock-data').val(data.stock_data);
            }
            else if(type == 'user')
            {
              $('#name_input').val(data.name);
              $('#email_input').val(data.email);
              $('#user-status').val(data.active);
              $('#password_input').val(data.password);
            }
            else if(type == 'invoice')
            {
              $('#invoice_user').val(data.id_user);
              $('#invoice_totalusd').val(data.total_in_usd);
              $('#invoice_status').val(data.status);
            }

          }

          function getInfoEdit(id,type)
          {

            $.ajax({
                url : "../admin/getinfo",
                type: "POST",
                data : {
                  "id": id,
                  "type": type
                },
                dataType: 'json',
                success: function(data, textStatus, jqXHR)
                {
                  $('#edit-id').val(id);
                  $('#edit-type').val(type);

                  console.log(data);
                  
                  loadInfoEditModal(data,type);

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  console.log(errorThrown);
                  console.log(textStatus);
                  console.log(jqXHR);
                }
            });
          }

      </script>
      
      
    </div>
  </body>
</html>
