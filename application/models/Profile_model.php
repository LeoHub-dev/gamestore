<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {

	public $profile = NULL;
    public $history = NULL;
	
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function getProfile($user_id)
    {
        $this->db->where('id_user', $user_id);
        $this->db->from('auth_users');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $user)
            {
                $this->profile['data'] = array(
                    'id_user' => $user->id_user,
                    'email' => $user->email,
                    'name' => $user->name
                    );
            }
        }
        else
        {
            return FALSE;
        }

        return $this->profile;

    }

    public function getBuyHistory($user_id)
    {
        $this->db->where('id_user', $user_id);
        $this->db->from('invoice');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $invoice)
            {
                $this->history[] = $this->Invoice_model->getInvoice($invoice->cart_hash);
            }
        }
        else
        {
            return FALSE;
        }

        return $this->history;

    }

    public function getWishlist($id)
    {
        $this->db->select('*');
        $this->db->where('products_name.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_desc.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_price.coin', $this->session->userdata('site_coin_id'));
        $this->db->where('wishlist.id_user', $id);
        $this->db->from('wishlist');
        $this->db->join('products_list', 'wishlist.id_product = products_list.id_product', 'left');
        $this->db->join('products_name', 'wishlist.id_product = products_name.id_product', 'left');
        $this->db->join('products_desc', 'wishlist.id_product = products_desc.id_product', 'left');
        $this->db->join('products_price', 'wishlist.id_product = products_price.id_product', 'left');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $product)
            {
                $wishlist[] = (object) array(
                'product_id' => $product->id_product,
                'product_name' => $product->name,
                'product_desc' => $product->description,
                'product_image' => $product->image,
                );

            }

            return $wishlist;

        }
        else
        {
            return NULL;
        }    

    }

    


    
}
?>