<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart_model extends CI_Model {

	public $cart_items = NULL;
	
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();

        $this->cart_items = $this->session->userdata('cart_items');
        
        if(!$this->cart_items) 
        {
            $this->session->set_userdata('cart_items',NULL);
        }
   
    }

    public function addToCart($id,$qty)
    {
        $this->db->select('*');   
        $this->db->where('products_name.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_desc.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_price.coin', $this->session->userdata('site_coin_id'));
        $this->db->where('products_list.id_product', $id);
        $this->db->from('products_list');
        $this->db->join('products_name', 'products_list.id_product = products_name.id_product', 'left');
        $this->db->join('products_desc', 'products_list.id_product = products_desc.id_product', 'left');
        $this->db->join('products_price', 'products_list.id_product = products_price.id_product', 'left');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $product)
            {
                if(getStockById($product->id_product) == 0)
                {
                    //return (object) array('error' => '1');
                }

                $this->cart_items[$product->id_product] = (object) array(
                'product_id' => $product->id_product,
                'product_name' => $product->name,
                'product_desc' => $product->description,
                'product_qty' => $qty,
                'product_image' => $product->image,
                'product_price' => $product->price,
                'product_coin' => $this->session->userdata('site_coin'),
                'product_fprice' => $product->price." ".$this->session->userdata('site_coin'),
                'product_lang' => $this->session->userdata('site_lang_id')
                );

            }

            end($this->cart_items);

            $last_product = key($this->cart_items);

            $this->updateCart();

            return $this->cart_items[$last_product];

        }
        else
        {
            return NULL;
        }    
    }

    public function addToWish($id)
    {
        $this->db->select('*');   
        $this->db->where('products_list.id_product', $id);
        $this->db->from('products_list');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            $data = array(
               'id_user' => $this->session->userdata('id_user'),
               'id_product' => $id
            );

            $query = $this->db->insert('wishlist',$data);

            if($query)
            {
                return TRUE;
            }

        }
        else
        {
            return NULL;
        }    

    }

    public function removeFromWish($id)
    {
        $query = $this->db->delete('wishlist', array('id_product' => $id, 'id_user' => $this->session->userdata('id_user')));

        if($query)
        {
            return TRUE;
        }

        return FALSE;
    }

    public function editItemQty($id,$qty)
    {
        if($this->existInCart($id))
        {
            $item = $this->cart_items[$id];
            
            $item->product_qty = $qty;

            $this->cart_items[$id] = $item;

            $this->updateCart();
            
            return $item;
        }

        return FALSE;
    }

    public function removeFromCart($id)
    {
        if($this->existInCart($id))
        {
            $item = $this->cart_items[$id];
            
            unset($this->cart_items[$id]);
            $this->updateCart();
            return $item;
        }

        return FALSE;
    }

    public function existInCart($id)
    {
        if($this->cart_items)
        {
            if(array_key_exists($id,$this->cart_items))
            {
                return TRUE;
            }
        }

        return FALSE;
        
    }

    public function existInWish($id)
    {

        $this->db->select('*');   
        $this->db->where('id_product', $id);
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $this->db->from('wishlist');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }    
        
    }

    public function getNumberItems()
    {
        $total = 0;
        $cart = $this->session->userdata('cart_items');

        if($cart)
        {
            foreach ($cart as $product) 
            {
                $total++;
            } 
        }

        return $total;
    }

    public function getCartTotal()
    {
        $total = 0;
        $cart = $this->session->userdata('cart_items');

        if($cart)
        {
            foreach ($cart as $product) 
            {
                $total = $product->product_price*$product->product_qty + $total;
            } 
        }

        return $total;
    }



    public function updateCart()
    {
        if($this->cart_items != NULL && !empty($this->cart_items))
        {
            $this->session->set_userdata('cart_items',$this->cart_items);
        }
        else
        {
            $this->session->set_userdata('cart_items',NULL);
        }
        
    }

    public function cartIsEmpty()
    {
        if(is_array($this->cart_items) || is_object($this->cart_items))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function cleanCart()
    {
        $this->session->set_userdata('cart_items',NULL);
        $this->cart_items = NULL;
        return TRUE;
    }

    public function getCart()
    {
        if($this->cart_items != NULL)
        {
            foreach ($this->cart_items as $old_product) 
            {
                if($this->session->userdata('site_lang_id') != $old_product->product_lang)
                {
                    $this->db->select('*');   
                    $this->db->where('products_name.lang', $this->session->userdata('site_lang_id'));
                    $this->db->where('products_desc.lang', $this->session->userdata('site_lang_id'));
                    $this->db->where('products_price.coin', $this->session->userdata('site_coin_id'));
                    $this->db->where('products_list.id_product', $old_product->product_id);
                    $this->db->from('products_list');
                    $this->db->join('products_name', 'products_list.id_product = products_name.id_product', 'left');
                    $this->db->join('products_desc', 'products_list.id_product = products_desc.id_product', 'left');
                    $this->db->join('products_price', 'products_list.id_product = products_price.id_product', 'left');

                    $query = $this->db->get();

                    foreach ($query->result() as $new_product)
                    {
                        $this->cart_items[$new_product->id_product] = (object) array(
                        'product_id' => $new_product->id_product,
                        'product_name' => $new_product->name,
                        'product_desc' => $new_product->description,
                        'product_qty' => $old_product->product_qty,
                        'product_image' => $new_product->image,
                        'product_price' => $new_product->price,
                        'product_coin' => $this->session->userdata('site_coin'),
                        'product_fprice' => $new_product->price." ".$this->session->userdata('site_coin'),
                        'product_lang' => $this->session->userdata('site_lang_id')
                        );
                    }
                }
                else
                {
                    continue;
                }
            }
        }
        $this->updateCart();
        return $this->cart_items;
    }


    
}
?>