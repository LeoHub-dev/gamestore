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
                  <li class="active"><?= lang("bread_admin"); ?></li>
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
                <i class="fa fa-user-circle"></i>
                <span class="triangle"></span>
              </div>
                  <!--style="display: none;"--> 

              <!-- BOOX 1 ADD PRODUCT --> 
              <div id="addproduct" class="box-holder active">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("admin_addproduct"); ?></h2>
                    <div class="table-form ">
                      <?= form_open_multipart('admin/addproduct',array('id'=>'formAddProduct'));?>
                      
                        <div class="field-group">
                          <label><?= lang("admin_name"); ?> (<?= lang("admin_clickover"); ?>)</label>

                            <?php foreach ($lang_list as $lang_n) { ?>
                              <a href="javascript:void(0)" data-lang="<?= substr($lang_n['lang_name'], 0, 3) ?>" class="namelang"><label>> <?= $lang_n['lang_name']; ?></label></a>
                            <?php } ?>

                          
                        </div>  

                        <div class="field-group">
                          <label><?= lang("admin_image"); ?></label>
                          <div id="imageupload">Subir</div>
                          <input type="hidden" name="image" id="image_input" class="le-input" required>
                        </div> 

                        <div class="field-group description">
                          <label><?= lang("admin_desc"); ?></label>
                          
                        </div> 

                        <div class="field-group">
                          <label><?= lang("admin_category"); ?></label>
                          <select id="list_category" class="le-input list_cat" name="category" required>
                          <?php if($category_list) :
                          foreach ($category_list as $category) {?>
                            <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                          <?php } 
                          else :

                            echo '<option disabled selected value>'.lang("admin_empty").'</option>';

                          endif;?>
                          </select>
                        </div> 

                        <div class="field-group">
                          <label><?= lang("admin_price"); ?></label>
                          <input type="number" name="price" id="price_input" class="le-input placeholder" data-placeholder="0" step="any" min="0.0001" required>
                        </div> 

                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("admin_addproduct"); ?></button>
                        </div>

                    </div>
                  </div>
                </div>
                
                

                </div>
                <?= form_close();?>
              </div>
              <!-- BOOX 1 ADD PRODUCT --> 

              <!-- BOOX 1 ADD PRODUCT --> 
              <div id="addstock" style="display: none;" class="box-holder">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("admin_addstock"); ?></h2>
                    <div class="table-form ">
                      <?= form_open('admin/addstock',array('id'=>'formAddStock'));?>
                        <div class="field-group">
                          <label><?= lang("admin_product"); ?></label>
                          <select id="list_products" name="producto" required>
                          <?php if($products_list) :
                          foreach ($products_list as $product) {?>
                            <option value="<?= $product->product_id ?>"><?= $product->product_name ?> (Stock: <?= getStockById($product->product_id) ?>)</option>
                          <?php } 
                          else :

                            echo '<option disabled selected value>'.lang("admin_empty").'</option>';

                          endif;?>
                          </select>
                        </div>  
                        <div class="field-group">
                          <label><?= lang("table_data"); ?></label>
                          <textarea name="data" id="description_input" class="desc-'+lang+'" class="le-input" rows="5" cols="30" required></textarea>
                        </div> 
                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("admin_addstock"); ?></button>
                        </div>
                    </div>
                  </div>
                </div>
                
                

                </div>
                <?= form_close();?>
              </div>
              <!-- BOOX 1 ADD PRODUCT --> 

              <!-- BOOX 1 ADD PRODUCT --> 
              <div id="adduser" style="display: none;" class="box-holder">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("admin_adduser"); ?></h2>
                    <div class="table-form ">
                      <?= form_open('admin/adduser',array('id'=>'formAddUser'));?>

                        <div class="field-group">
                          <label><?= lang("form_email"); ?></label>
                          <input type="email" name="email" id="email_input" class="le-input placeholder" placeholder="example@mail.com" required>
                        </div> 

                        <div class="field-group">
                          <label><?= lang("form_first_name"); ?></label>
                          <input type="text" name="name" id="name_input" class="le-input placeholder" placeholder="Name" required>
                        </div>

                        <div class="field-group">
                          <label><?= lang("form_password"); ?></label>
                          <input name="password" id="password_input" type="password" placeholder="password" class="le-input placeholder" required>
                        </div> 

                        <div class="field-group">
                          <label><?= lang("form_passwordconfirm"); ?></label>
                          <input name="repassword" id="repassword_input" type="password" placeholder="password" class="le-input placeholder" required>
                        </div> 

                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("admin_adduser"); ?></button>
                        </div>
                    </div>
                  </div>
                </div>
                
                

                </div>
                <?= form_close();?>
              </div>
              <!-- BOOX 1 ADD PRODUCT --> 


              <!-- BOOX 1 ADD PRODUCT --> 
              <div id="addcategory" style="display: none;" class="box-holder">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2><?= lang("admin_addcat"); ?></h2>
                    <div class="table-form ">
                      
                        <div class="field-group">
                          <label><?= lang("admin_catact"); ?></label>
                          
                          <div id="link-cat-list">
                          <?php if($category_list) :
                          foreach ($category_list as $category) {?>
                            <p class="cat-<?= $category->category_id ?>"><?= $category->category_name ?> <a href="javascript:void(0)" cid="<?= $category->category_id ?>" class="delete-category"><font color="red"> > <?= lang("admin_delete"); ?></font></a></p>
                          <?php } 
                          else :

                            echo '<p>'.lang("admin_empty").'</p>';

                          endif;?>
                          </div>
                          
                        </div> 

                        <?= form_open('admin/addcategory',array('id'=>'formAddCategory'));?>
                            

                        <div class="field-group">
                          <?php foreach ($lang_list as $lang_n) { ?>

                          <label><?= lang("admin_name"); ?> <?= substr($lang_n['lang_name'], 0, 3) ?></label>
                          <input name="category_name[<?= substr($lang_n['lang_name'], 0, 3) ?>]" type="text" placeholder="Category" class="le-input placeholder" required>

                          <?php } ?>
                        </div> 
                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("admin_addcat"); ?></button>
                        </div>
                    </div>
                  </div>
                </div>
                
                

                </div>
                <?= form_close();?>
              </div>
              <!-- BOOX 1 ADD PRODUCT --> 

              <!-- BOOX 1 ADD PRODUCT --> 
              <div id="editconfig" style="display: none;" class="box-holder">
                <div class="row">
                <div class="loader">
                  <div class="col-xs-12 col-md-12">
                    <h2>Config</h2>
                    <div class="table-form ">

                        <?= form_open('admin/editconfig',array('id'=>'formEditConfig'));?>
                            

                        <div class="field-group">
                          <label>Blockchain - XPUB</label>
                        <input type="text" name="1" id="xpub_input" class="le-input placeholder" placeholder="Xpub" value="<?= $this->config->item('blockchain_xpub') ?>" required>
                        </div>

                        <div class="field-group">
                          <label>General email</label>
                        <input type="text" name="2" id="genemail_input" class="le-input placeholder" placeholder="Email" value="<?= $this->config->item('general_email') ?>" required>
                        </div>

                        <div class="field-group">

                        <label><?= lang("list_unused"); ?></label>
                        <ol>
                        <?php if($unusedaddress_list) :
                          foreach ($unusedaddress_list as $address) {?>
                          <li><?= $address['address'] ?></li>
                        <?php } 
                        else :

                          echo '<p>'.lang("admin_empty").'</p>';

                        endif;?>
                        </ol>
                        </div>

                        <a href="<?= site_url('invoice/blockchain_unused_address/').'?gob='.base_url(uri_string()); ?>" class="le-btn small">Check for unused blockchain address</a>
                        

                        <div class="text-right button-holder">
                        <button name="button" type="submit" id="button_login" class="le-btn small" value="true"><?= lang("admin_edit"); ?></button>
                        </div>
                    </div>
                  </div>
                </div>
                
                

                </div>
                <?= form_close();?>
              </div>
              <!-- BOOX 1 ADD PRODUCT --> 



            </div>
          </div>

          

          <div class="col-xs-12 col-md-4">


            <div class="box sidebar login-form">
              <div class="widget simple-widget">
                <div class="icon-holder small">
                  <i class="fa fa-user-circle"></i>
                  <span class="triangle"></span>
                </div>

                <h2>Menu</h2>
                <div class="body">

                <p><?= lang("admin_add"); ?></p>
                    <p><div class="button-holder">
                      <a href="javascript:void(0)" data-menu="#addproduct" class="le-btn small admin-menu"><?= lang("admin_addproduct"); ?></a>
                    </div>
                    </p>

                    <p><div class="button-holder">
                      <a href="javascript:void(0)" data-menu="#addcategory" class="le-btn small admin-menu"><?= lang("admin_addcat"); ?></a>
                    </div>
                    </p><p><div class="button-holder">
                    <a href="javascript:void(0)" data-menu="#addstock" class="le-btn small admin-menu"><?= lang("admin_addstock"); ?></a>
                  </div>
                  </p>

                  <p><div class="button-holder">
                      <a href="javascript:void(0)" data-menu="#adduser" class="le-btn small admin-menu"><?= lang("admin_adduser"); ?></a>
                    </div>
                    </p>


                    
                  <p><?= lang("admin_list"); ?></p>
                    <p><div class="button-holder">
                      <a href="<?= site_url('admin/listhistory'); ?>" target="_blank" class="le-btn small"><?= lang("admin_menu_listshop"); ?></a>
                    </div>
                    </p>

                    <p><div class="button-holder">
                      <a href="<?= site_url('admin/listblockpayments'); ?>" target="_blank" class="le-btn small"><?= lang("admin_menu_listpayments"); ?> - Blockchain</a>
                    </div>
                    </p>

                    <p><div class="button-holder">
                      <a href="<?= site_url('admin/liststeampayments'); ?>" target="_blank" class="le-btn small"><?= lang("admin_menu_listpayments"); ?> - Steam</a>
                    </div>
                    </p>

                    <p><div class="button-holder">
                      <a href="<?= site_url('admin/listproducts'); ?>" target="_blank" class="le-btn small"><?= lang("admin_menu_listproducts"); ?></a>
                    </div>
                    </p>

                    <p><div class="button-holder">
                      <a href="<?= site_url('admin/listusers'); ?>" target="_blank" class="le-btn small"><?= lang("admin_menu_listusers"); ?></a>
                    </div>
                    </p>

                    <p><div class="button-holder">
                      <a href="<?= site_url('admin/liststock'); ?>" target="_blank" class="le-btn small"><?= lang("admin_menu_liststock"); ?></a>
                    </div>
                    </p>

                  

                  <p>Config (Blockchain - GAP: <?= (isset($xpub_gap->gap)) ? $xpub_gap->gap : 'Xpub Error - Sin Gap o No valido' ?>)</p>
                    <p><div class="button-holder">
                      <a href="javascript:void(0)" data-menu="#editconfig" class="le-btn small admin-menu"><?= lang("admin_edit"); ?> Config (xpub, email ...)</a>
                    </div>
                    </p>
                    


                </div>
              </div>
            </div>


          </div>
        </div>
      </section>

 
      

      <?php include_once('modules/foot.php'); ?>

      <script type="text/javascript">

        $("#imageupload").uploadFile({
          url:"admin/uploadimg/",
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

        $(".admin-menu").on("click",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();

          var menu = $(this).attr('data-menu');

          var actual = $('.box-holder.active');

          if("#"+actual.attr('id') == menu){ return; }

          $(actual).removeClass('active').fadeOut(function () {
            $(menu).addClass('active').fadeIn()
          });

        });

        $(".namelang").on("click",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();

          var lang = $(this).attr('data-lang');

          if($('.name-'+lang).length > 0) { $('.name-'+lang).remove(); $('.desc-'+lang).remove(); return; }

          $(this).after('<input type="text" name="name['+lang+'][]" id="name_input" class="le-input placeholder name-'+lang+'" placeholder="Name/Nombre" required>');

          $(".field-group.description label:first-child").after('<label class="desc-'+lang+'">> '+lang+'</label><textarea name="desc['+lang+'][]" id="description_input" class="desc-'+lang+'" class="le-input" rows="5" cols="30" required></textarea>');
        })

        $("#formAddProduct").on("submit",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();

          var data = $(this).serialize(); 
          var link = $(this).attr('action');


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

              reloadStockInfo();
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              console.log(errorThrown);
              console.log(textStatus);
              console.log(jqXHR);
            }
          });
        });

        $("#formAddStock").on("submit",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();

          var data = $(this).serialize(); 
          var link = $(this).attr('action');


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

              notification(data.msg_type,data.msg_text);

              reloadStockInfo();
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              console.log(errorThrown);
              console.log(textStatus);
              console.log(jqXHR);
            }
          });
        });

        $("#formAddUser").on("submit",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();

          var data = $(this).serialize(); 
          var link = $(this).attr('action');


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
  
              notification(data.msg_type,data.msg_text);
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              console.log(errorThrown);
              console.log(textStatus);
              console.log(jqXHR);
            }
          });
        });

        $("#formAddCategory").on("submit",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();

          var data = $(this).serialize(); 
          var link = $(this).attr('action');


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

              notification(data.msg_type,data.msg_text);

              reloadCategoryInfo();
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              console.log(errorThrown);
              console.log(textStatus);
              console.log(jqXHR);
            }
          });
        });

          $("#formEditConfig").on("submit",function(e){

            e.preventDefault();
            e.stopImmediatePropagation();

            var data = $(this).serialize(); 
            var link = $(this).attr('action');


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
                  
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(jqXHR);
              }
            });
          });


        $("*").on("click",".delete-category",function(e){

          e.preventDefault();
          e.stopImmediatePropagation();
          
          if (confirm('<?= lang("admin_not_delcat"); ?>')) {
            
          } else {
            return;
          }

          

          var id = $(this).attr('cid');

          $.ajax({
              url : "admin/removecategory",
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
                    $('.cat-'+id).fadeOut(function() {

                      $(this).remove();

                    })
                    reloadCategoryInfo();
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

        function reloadStockInfo()
        {
          $.ajax({
            url : "admin/getinfostock",
            type: "POST",
            dataType: 'json',
            beforeSend: function ()
            {
              
            },
            success: function(data, textStatus, jqXHR)
            {
              $("#list_products").find('option').remove();
              $.each(data, function (i) {

                $("#list_products").append('<option value="'+data[i].product_id+'">'+data[i].product_name+' (Stock: '+data[i].product_stock+') </option>');

              })
                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              console.log(errorThrown);
              console.log(textStatus);
              console.log(jqXHR);
            }
          });
        }

        function reloadCategoryInfo()
        {
          $.ajax({
            url : "admin/getinfocategory",
            type: "POST",
            dataType: 'json',
            beforeSend: function ()
            {
              
            },
            success: function(data, textStatus, jqXHR)
            {
              $(".list_cat").find('option').remove();
              $("#link-cat-list").find('p').remove();
              $.each(data, function (i) {

                $(".list_cat").append('<option value="'+data[i].category_id+'">'+data[i].category_name+'</option>');
                $("#link-cat-list").append('<p class="cat-'+data[i].category_id+'">'+data[i].category_name+' <a href="javascript:void(0)" cid="'+data[i].category_id+'" class="delete-category"><font color="red"> > <?= lang("admin_delete"); ?></font></a></p>');

              })
                
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
