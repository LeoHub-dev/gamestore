var base_url = "http://localhost/KeyStore2/";

(function ($) {

  
  	"use strict";

  	$(window).bind("load", function () {
	    $('#status').fadeOut(); // will first fade out the loading animation
	    $('#preloader').delay(1000).fadeOut('slow'); // will fade out the white DIV that covers the website.
	    //$('body').delay(1000).css({'overflow-x': 'hidden'}).css({'overflow-y': 'auto'});
	    //checkContactForm();
  	});

  	//    top cart
    $('.basket .close-btn').click(function () {
      $(this).parent().parent().fadeOut(function () {
        $(this).remove();
        checkBasketDropdown(true);
      });
    });
    
	//Quantity element
 	$('.le-quantity a').click(function(e){

   		e.preventDefault();
      	var currentQty= $(this).parent().parent().find('input').val();
     
      	if( $(this).hasClass('minus') && currentQty>1){
       		$(this).parent().parent().find('input').val(parseInt(currentQty)-1);
          $(this).parent().parent().find('input').trigger('change')
  		}else{
           
            if( $(this).hasClass('plus')){
               
             	$(this).parent().parent().find('input').val(parseInt(currentQty)+1);
              $(this).parent().parent().find('input').trigger('change')
            }
      	}
    });

 	/*
     * Replace all SVG images with inline SVG
     */
    $('img.svg').each(function () {

      	var $img = jQuery(this);
      	var imgID = $img.attr('id');
      	var imgClass = $img.attr('class');
      	var imgURL = $img.attr('src');

      	jQuery.get(imgURL, function (data) {
	        // Get the SVG tag, ignore the rest
	        var $svg = jQuery(data).find('svg');

	        // Add replaced image's ID to the new SVG
	        if (typeof imgID !== 'undefined') {
	          $svg = $svg.attr('id', imgID);
	        }
	        // Add replaced image's classes to the new SVG
	        if (typeof imgClass !== 'undefined') {
	          $svg = $svg.attr('class', imgClass + ' replaced-svg');
	        }

	        // Remove any invalid XML tags as per http://validator.w3.org
	        $svg = $svg.removeAttr('xmlns:a');

	        // Replace image with new SVG
	        $img.replaceWith($svg);

      	}, 'xml');
    });

	if($('.search-button').length>0){
	    $('.search-button').click(function (e) {
	      	e.preventDefault();
	      	var fld = $(this).find('+ .field');
	      	fld.addClass('open');

	    });

	    $('html').click(function () {
	      	$('.search-holder .field').removeClass('open');
	    });

	    $('.search-holder').click(function (event) {
	      	event.stopPropagation();
	    });
    }
    
    $('[data-placeholder]').focus(function () 
    {
      	var input = $(this);
      	if (input.val() == input.attr('data-placeholder')) {
        	input.val('');
      	}
    }).blur(function () {
      	var input = $(this);
      	if (input.val() == '' || input.val() == input.attr('data-placeholder')) {
    		input.addClass('placeholder');
        	input.val(input.attr('data-placeholder'));
      	}
    }).blur();

    $('[data-placeholder]').parents('form').submit(function () {
      	$(this).find('[data-placeholder]').each(function () {
        	var input = $(this);
        	if (input.val() == input.attr('data-placeholder')) {
          		input.val('');
        	}
      	});
    });

    $(".signup-button").on("click",function(e){

      $('.login-form').fadeOut(function () {

        $(".login-form").children().children().addClass('content-loader');

        $('.signup-form').fadeIn(function () {

          $(".login-form").children().children().removeClass('content-loader');

          $('.signup-form').removeClass('hidden');

        });
      });
    })

    $(".forgot-button").on("click",function(e){

      $('.login-form').fadeOut(function () {
        $(".login-form").children().children().addClass('content-loader');

        $('.forgot-form').fadeIn(function () {

          $(".login-form").children().children().removeClass('content-loader');

          $('.forgot-form').removeClass('hidden');

        });
      });
    })


    $(".login-button").on("click",function(e){

      if($('.signup-form').css('display') != 'none')
      {
        $('.signup-form').fadeOut(function () {

          $(".signup-form").children().children().addClass('content-loader');

          $('.login-form').fadeIn(function () {

            $(".signup-form").children().children().removeClass('content-loader');
            $('.login-form').removeClass('hidden');

          });
        });
      }
      
      if($('.forgot-form').css('display') != 'none')
      {
        $('.forgot-form').fadeOut(function () {

          $(".forgot-form").children().children().addClass('content-loader');

          $('.login-form').fadeIn(function () {

            $(".forgot-form").children().children().removeClass('content-loader');
            $('.login-form').removeClass('hidden');

          });
        });
      }

    })

	//    top cart

    $(".addtocart").on("click",function(e){

        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).attr('pid');

        if($('#page-product-qty').length)
        {
          var qty = $('#page-product-qty').val();
        }
        else
        {
          var qty = $(this).attr('qty');
        }

        $.ajax({
            url : base_url+"cart/addcart/",
            type: "POST",
            data : {
              "id": id,
              "qty": qty
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
                  addToCart(data);
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

    $(".addtowish").on("click",function(e){

        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).attr('pid');
        var qty = $(this).attr('qty');

        $.ajax({
            url : base_url+"cart/addwish/",
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

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(jqXHR);
            }
        });
    });


    $('*').on('click', '.removefromcart', function(e){

        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).attr('pid');

        $.ajax({
            url : base_url+"cart/removecart/",
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
                  removeFromCart(id);
                  lessTotalAmount(data.product_price*data.product_qty);
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

    $('*').on('click', '.removefromwish', function(e){

        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).attr('pid');

        $.ajax({
            url : base_url+"cart/removewish/",
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
                  $('.pid-'+id).fadeOut(function()
                  {
                    $('.pid-'+id).remove();
                  });

    
                  if($('.shopping-cart-page .box tr').length <= 0)
                  {
                    $('.shopping-cart-page.box').html('<h2><a href="../profile/">Perfil / Profile</a></h2>');
                  }

                  
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

    //$('.item-qty').on('input', function() {
      $('*').on('change', '.item-qty', function(e){


        e.preventDefault();
        e.stopImmediatePropagation();

        var id = $(this).attr('pid');
        var qty = $(this).val();

        $.ajax({
            url : base_url+"cart/editqty/",
            type: "POST",
            data : {
              "id": id,
              "qty": qty
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

                if($('.price-qty-'+data.product_id))
                {
                  var ndecimal = decimalPlaces(data.product_price);
                  $('.price-qty-'+data.product_id).html((data.product_price*data.product_qty).toFixed(ndecimal)+" "+data.product_coin);
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

    

    

  	$('.goto-top').click(function (e) {
    	e.preventDefault();
	    $('html,body').animate({
	      scrollTop: 0
	    }, 2000);
  	});

  	if ($('a[data-rel="prettyphoto"]').length > 0) {
    	$('a[data-rel="prettyphoto"]').prettyPhoto();
  	}
  	if ($('a[data-rel="prettyPhoto"]').length > 0) {
    	$('a[data-rel="prettyPhoto"]').prettyPhoto();
  	}


	$('select.nav').change(function () {
    	var loc = ($(this).find('option:selected').val());
    	scrollToSection(loc);
  	});

  function scrollToSection(destSection) {
	location.href=destSection;
	//    $('html, body').stop().animate({
	//      scrollTop: $(destSection).offset().top + scrollOffset
	//    }, 2000, 'easeInOutExpo');
	  }

	//  $('.nav-menu a').bind('click', function (event) {
	//    event.preventDefault();
	//    var clickedMenu = $(this);
	//    $('.nav-menu .active').toggleClass('active');
	//    clickedMenu.parent().toggleClass('active');
	//    scrollToSection(clickedMenu.attr('href'));
	//  });

})(jQuery);


// Sticky Nav
$(window).scroll(function (e) {
  	var nav_anchor = $(".top-menu-holder");
  	var gotop = $(document);
  	if ($(this).scrollTop() >= 500) {
    	$('.goto-top').css({'opacity': 1});
  	} else if ($(this).scrollTop() < 500)
  	{
    	$('.goto-top').css({'opacity': 0});
  	}
  	if ($(this).scrollTop() >= $('header').height())
  	{
    	nav_anchor.addClass('split');
  	}
  	else if ($(this).scrollTop() < $('header').height())
  	{
    	nav_anchor.removeClass('split');
  	}
});

window.lastNoty = new Array();

function notification(type,message,id = false)
{
    if(window.lastNoty.length >= 3)
    {
        window.lastNoty[0].remove();
        window.lastNoty.shift();
    }

    type = typeof type !== 'undefined' ? type : "none";
    message = typeof message !== 'undefined' ? message : 'No message';

    if(id == false)
    {
        window.lastNoty.push(Lobibox.notify(type, {
            pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
            size: 'mini',
            msg: message
        }));
    }
    else
    {

    }  
}

Lobibox.notify.OPTIONS = $.extend({}, Lobibox.notify.OPTIONS, {
large: {
    width: 400,
    messageHeight: 40
}
});

window.extraNoty = new Array();

function espnotification(type,message,id,title,url = false)
{
    if(window.extraNoty.length >= 10)
    {
        window.extraNoty[0].remove();
        window.extraNoty.shift();
    }

    type = typeof type !== 'undefined' ? type : "none";
    message = typeof message !== 'undefined' ? message : 'No message';

    if(url == false)
    {
        window.extraNoty.push(Lobibox.notify(type, {
            pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
            size: 'large',
            delay: false,
            sound: false,
            title: title,
            position: 'bottom left',
            msg: message,
            onClick: function(){
              $.ajax({
                  url : base_url+"home/notify/",
                  type: "POST",
                  data : {
                    "id": id
                  },
                  success: function(data, textStatus, jqXHR)
                  {
                      
                  }
              });
            }
        }));
    }
    else
    {
      window.extraNoty.push(Lobibox.notify(type, {
            pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
            size: 'large',
            delay: false,
            sound: false,
            title: title,
            position: 'bottom left',
            msg: message,
            onClick: function(){
              $.ajax({
                  url : base_url+"home/notify/",
                  type: "POST",
                  data : {
                    "id": id
                  },
                  success: function(data, textStatus, jqXHR)
                  {
                    // similar behavior as clicking on a link
                    window.location.href = url;
                  }
              });
            }
        }));
    }  
}

function addToCart(item)
{
  if($('.basket .dropdown-menu').hasClass('hidden'))
  {
    $('.basket .dropdown-menu').removeClass('hidden');
  }

  $('.basket .dropdown-menu').prepend('<li class=pid-'+item.product_id+'>\
    <div class="basket-item">\
      <div class="row">\
        <div class="col-xs-12 col-sm-2 col-md-4">\
          <div class="thumb">\
            <img alt="" src="'+item.product_image+'">\
          </div>\
        </div>\
        <div class="col-xs-12 col-sm-10 col-md-8">\
          <div class="title">'+item.product_name+'</div>\
          <div class="price">'+item.product_price*item.product_qty+' '+item.product_coin+'</div>\
        </div>\
      </div>\
      <a class="close-btn removefromcart" pid="'+item.product_id+'" href="javascript:void(0)"></a>\
    </div>\
  </li>');

  plusTotalAmount(item.product_price*item.product_qty);

  plusItemCounter();
}

function removeFromCart(item)
{

  $('.pid-'+item).fadeOut(function()
  {
    $('.pid-'+item).remove();
    
    checkBasketDropdown();

  });

  lessItemCounter();

  

  /*$(item).parent().parent().fadeOut(function () {
  //$(this).remove();
    checkBasketDropdown();
  });

  lessItemCounter();*/

}


/*$('.basket .close-btn').click(function () {
    $(this).parent().parent().fadeOut(function () {
    //$(this).remove();
      checkBasketDropdown();
    });
});*/

$('[data-hover="dropdown"]').dropdownHover();

function plusTotalAmount(amount) {
    var cn = parseFloat($('.cart-total').html());
    var nn = (cn) + (parseFloat(amount));
    $('.cart-total').html(nn);
}

function lessTotalAmount(amount) {
    var ndecimal = decimalPlaces($('.cart-total').html());
    if(ndecimal <= 0)
    {
      ndecimal = 1;
    }
    var cn = parseFloat($('.cart-total').html());
    var nn = (cn) - (parseFloat(amount));
    $('.cart-total').html(nn.toFixed(ndecimal));   
}

function plusItemCounter() {
    var cn = parseInt($('.item-count').html());
    var nn = cn + 1;
    $('.item-count').html(nn);
}

function lessItemCounter() {
    var cn = parseInt($('.item-count').html());
    var nn = cn - 1;
    $('.item-count').html(nn);
}



function checkBasketDropdown() {
    if ($('.basket .basket-item').length <= 0) {
      $('.basket .dropdown-menu').addClass('hidden');
      if($('.shopping-cart-page .box'))
      {
        //$('.cart-table').remove();
        $('.shopping-cart-page.box').html('<h2>Cart is empty - <a href="../home/">Go Shopping / Ir a comprar</a></h2>');
      }
      $('.basket .dropdown-menu').addClass('hidden');
      //$('.basket .dropdown-menu').prepend("<li class='empty'>Empty</li>");
    }
}
    
function notificationCenterBox(type,title,msg,url = '#',button_text = 'OK',post = {active : false, id_name : 'confirm', val : true},button_active = true)
{
  $('#messageBox').modal('show');

  if($('#messageBox').hasClass('modal-success')) { $('#messageBox').removeClass('modal-success'); $('#messageBox .modal-footer a').removeClass('modal-success'); }
  if($('#messageBox').hasClass('modal-danger')) { $('#messageBox').removeClass('modal-danger'); $('#messageBox .modal-footer a').removeClass('modal-danger');}
  if($('#messageBox').hasClass('modal-info')) { $('#messageBox').removeClass('modal-info'); $('#messageBox .modal-footer a').removeClass('modal-info');}
  if($('#messageBox').hasClass('modal-warning')) { $('#messageBox').removeClass('modal-warning'); $('#messageBox .modal-footer a').removeClass('modal-warning');}


  $('#messageBox').addClass('modal-'+type);
  $('#messageBox .modal-footer a').addClass('btn-'+type)
  $('#messageBox .modal-title').html(title);
  

  if(!post.active)
  {
    $('#messageBox .modal-body').html(msg);
    $('#messageBox .modal-footer a').html(button_text);
    $('#messageBox .modal-footer a').attr('href',url);
  }
  else
  {
    $('#messageBox .modal-body').html(msg);
    $('#messageBox .modal-footer').html('<form action="'+url+'" class="inline-block" method="post" accept-charset="utf-8"><button type="submit" name="'+post.id_name+'" value="'+post.val+'" class="btn btn-success">'+button_text+'</button> </form>');
  }

  if(!button_active)
  {
    $('#messageBox .modal-footer').html('');
  }

}

function decimalPlaces(num) {
  var match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
  if (!match) { return 0; }
  return Math.max(
       0,
       // Number of digits right of decimal point.
       (match[1] ? match[1].length : 0)
       // Adjust for scientific notation.
       - (match[2] ? +match[2] : 0));
}
function disableForm(form)
{
    $("button[type=submit], input").addClass("disabled");
    $("button[type=submit], input").attr("disabled","disabled");
}