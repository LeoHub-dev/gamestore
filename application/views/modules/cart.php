<div id="cart-bottom-fixed" class="<?php echo (is_array($cart) || is_object($cart)) ? '' : 'hidden'; ?>">

	<div class="col-md-12 cart-title text-center">
	<span class="glyphicon glyphicon-shopping-cart"></span><a href="<?= site_url('cart'); ?>" role="button" aria-expanded="false"> Cart - <div class="cart-items-counter" nitems="<?= $cart_nitems; ?>"><?= $cart_nitems; ?></div> Items</a>
	</div>

	
		<?php
		if(is_array($cart) || is_object($cart))
		{	
			foreach ($cart as $product) 
		    { ?>
		        <div class="col-md-12 product pid-<?= $product->product_id; ?>">
				  	<h4 class="col-md-12"><?= $product->product_name; ?></h4>
				  	<div class="col-md-12">Price : <div class="price"><?= $product->product_fprice; ?></div></div>
				  	<div class="col-md-12">Qty : <div class="qty">1</div></div>
				  	<button class="btn btn-xs btn-danger col-md-12 pull-right removefromcart" pid="<?= $product->product_id ?>">x</button>
				</div>

		    <?php 
			}
		}
	    ?>

</div>