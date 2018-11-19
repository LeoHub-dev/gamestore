<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta content="text/html; charset=US-ASCII" http-equiv="Content-Type">
  <!-- Facebook sharing information tags -->
  <meta property="og:title" content="%%subject%%">
  <title>Invoice Made</title>
</head>

<body style="margin-top: 0; margin-right: 0; margin-bottom: 0; margin-left: 0; padding-top: 0; padding-right: 0; padding-bottom: 0; padding-left: 0;">
  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Bitter:400,700);@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);body { font-family: Helvetica, Arial, sans-serif; } #outlook a{padding:0}blockquote .original-only,.WordSection1 .original-only{display:none !important}@media only screen and (max-width: 480px){body,table,td,p,a,li,blockquote{-webkit-text-size-adjust:none !important}body{width:100% !important;min-width:100% !important}#template-container{margin-top:0px !important;max-width:600px !important;width:100% !important}#header{padding:30px 20px 30px 20px !important}#content{padding:0 20px 20px !important}#content img.full-width{width:100% !important}#signature-row{width:100% !important}#signature-row .signature-box{display:block !important;width:100% !important;margin-top:20px !important}}@media only screen and (max-width: 480px){#template-container{margin-top:0px !important;max-width:600px !important;width:100% !important}#header{padding:30px 20px 30px 20px !important}#content{padding:20px 20px 20px !important}#content .full-width{width:100% !important}table.collapse{width:100% !important}table.collapse td{width:100% !important;display:block !important}#zenpayroll-banner{padding-left:20px;padding-right:20px}#zenpayroll-banner td:nth-child(1){text-align:center}#zenpayroll-banner td:nth-child(2) p{margin-left:20px}#signature-row{width:100% !important}#signature-row .signature-box{display:block !important;width:100% !important;margin-top:20px !important}}
  </style>
  <table id="body-table" style="border-collapse: collapse; margin-left: 0; margin-top: 0; margin-right: 0; margin-bottom: 0; padding-left: 0; padding-bottom: 0; padding-right: 0; padding-top: 0; background-color: #f2f2f2; height: 100% !important; width: 100% !important;"
    bgcolor="#f2f2f2">
    <tbody>
      <tr>
        <td align="center" style="border-collapse: collapse;">
          <p id="template-logo" style="text-align: center; margin-right: 0; margin-top: 30px; margin-bottom: 30px; margin-left: 0;" align="center">
            <a href="<?= site_url('home'); ?>" target="_blank" style="color:#59595b">
              <img src="<?= asset_url(); ?>images/logo.png" id="logo" alt="Get Your Games" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border-bottom-style: none; border-right-style: none; border-top-style: none; border-left-style: none; border-top-width: 0; border-right-width: 0; border-bottom-width: 0; border-left-width: 0;"
                width="220">
            </a>
          </p>
          <div class="preview-text" style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">Welcome to Get Your Games</div>
          <!-- BEGIN
            TEMPLATE // -->
          <table id="template-container" style="border-collapse: collapse; margin-top: 0px; width: 600px; background-color: #FFFFFF; border-top-color: #f00740; border-top-width: 10px; border-top-style: solid;" bgcolor="#FFFFFF" width="600">
            <tbody>
              <tr>
                <td id="content" style="border-collapse: collapse; padding-right: 40px; padding-top: 20px; padding-bottom: 20px; padding-left: 40px;text-align: center;">
                  <div>
                    <a style="color:#59595b">
                      <img src="https://www.hptu.org.co/images/colaboradores/correolectronico.png" alt="Welcome to Get Your Games" id="welcome" class="full-width" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border-bottom-style: none; border-right-style: none; border-top-style: none; border-left-style: none; border-top-width: 0; border-right-width: 0; border-bottom-width: 0; border-left-width: 0; "
                        width="220">
                    </a>
                  </div>
                  <p class="heading" style="font-family: Helvetica, Arial, sans-serif; font-weight: 700; font-size: 16px; color: #59595b; margin-bottom: 20px; text-align: center;" align="center">Gracias por comprar en GetYourGames</p>
                  <p class="heading" style="font-family: Helvetica, Arial, sans-serif; font-weight: 700; font-size: 16px; color: #59595b; margin-bottom: 20px; text-align: center;" align="center">Los productos que has reclamado son:</p>
                  <div class="cta margin-top-30px margin-bottom-50px" style="text-align: center; margin-top: 30px !important; margin-bottom: 50px !important;" align="center">
                    <!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
                        href="https://app.gusto.com/user/confirmation?confirmation_token=z7CQBvidRGooBqS5Vw8H"
                        style="height:40px;v-text-anchor:middle;width:300px;" arcsize="63%" stroke="f"
                        fillcolor="#EF073F">
                          <w:anchorlock/>
                          <center>
                          <![endif]-->
                          <center>
                          <?php
                          foreach ($products_claimed as $key => $product) {
                            if(is_numeric($key))
                            {
                              foreach ($products_claimed['data_'.$product->product_id] as $key) {
                                ?>
                                <p class="heading" style="font-family: Helvetica, Arial, sans-serif; font-weight: 700; font-size: 16px; color: #59595b; margin-bottom: 20px;">Producto : <?= $product->product_name ?></p>
                                <p class="heading" style="font-family: Helvetica, Arial, sans-serif; font-weight: 700; font-size: 16px; color: #59595b; margin-bottom: 20px;">Data : <font color="white" style="background-color: #f00740"><?= $key->product_content_data ?></font></p> 
                          <?php
                              }
                            }
                            else
                            {
                              continue;
                            }
                          }
                          
                          ?>

                          <a href="<?= site_url('invoice/report/'.$pdf);?>" style="color:#59595b;background-color:#EF073F;border-radius:25px;color:#ffffff;display:inline-block;font-family: 'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;letter-spacing:1px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:300px;-webkit-text-size-adjust:none;">PDF</a>
          
                          </center>
                    
                    <!--[if mso]>
                          </center>
                        </v:roundrect>
                      <![endif]-->
                  </div>
                  <table id="have-questions" class="full-width margin-top-20px" style="border-collapse: collapse; background-color: #1c4b77; margin-top: 20px !important;" bgcolor="#1c4b77" width="520">
                    <tr>
                      <td style="border-collapse: collapse; background-color: #1c4b77; text-align: center;" bgcolor="#1c4b77">
                        <p class="title margin-bottom-10px" style="color: #a3b8cb; font-family: 'Open Sans', Helvetica, Arial, sans-serif; font-weight: 700; font-size: 14px; text-align: center; margin-bottom: 10px !important;" align="center"><strong>HAVE QUESTIONS?</strong>
                        </p>
                        <p class="call-us margin-top-none" style="margin-bottom: 20px; color: #FFFFFF; font-family: 'Open Sans', Helvetica, Arial, sans-serif; font-size: 14px; text-align: center; margin-top: 0 !important;" align="center">Email us at
                          <a href="mailto:admin@leohub.com.ve" style="color:#59595b;color:#FFFFFF">admin@getyourgames.online</a>
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- // END TEMPLATE -->
          <div id="template-footer" style="padding-top: 30px; padding-right: 20px; padding-bottom: 50px; padding-left: 20px;">
            <div id="footer-copyright" style="font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #59595b; font-size: 14px;">&#169; 2016 Get Your Games</div>
            
            <div id="footer-links" class="margin-top-10px" style="font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #59595b; font-size: 14px; margin-top: 10px !important;">
              <a href="#" style="color:#59595b">Privacy Policy</a>
            </div>
            <div id="footer-social" class="padding-top-20px" style="font-family: 'Open Sans', Helvetica, Arial, sans-serif; color: #59595b; font-size: 14px; padding-top: 20px !important;">
              <a href="#" style="color:#59595b;text-decoration:none;">
                <img src="http://assets.zenpayroll.com.s3.amazonaws.com/static/emails/assets/6c18017504374518b50a308236d0f7eb/social-facebook.png" class="social-icon" alt="Facebook" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border-bottom-style: none; border-right-style: none; border-top-style: none; border-left-style: none; border-top-width: 0; border-right-width: 0; border-bottom-width: 0; border-left-width: 0;"
                  width="30" height="30" hspace="7">
              </a>
              <a href="#" style="color:#59595b; text-decoration:none;">
                <img src="http://assets.zenpayroll.com.s3.amazonaws.com/static/emails/assets/6c18017504374518b50a308236d0f7eb/social-twitter.png" class="social-icon" alt="Twitter" style="height: auto; line-height: 100%; outline: none; text-decoration: none; border-bottom-style: none; border-right-style: none; border-top-style: none; border-left-style: none; border-top-width: 0; border-right-width: 0; border-bottom-width: 0; border-left-width: 0;"
                  width="30" height="30" hspace="7">
              </a>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>