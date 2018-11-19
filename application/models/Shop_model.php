<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_model extends CI_Model {

	
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();

    }

    public function getProducts($showinactive = FALSE)
    {
        $this->db->select('*');
        $this->db->where('products_name.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_desc.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_price.coin', $this->session->userdata('site_coin_id'));
        if(!$showinactive) { $this->db->where('products_list.active', 1); }
        $this->db->from('products_list');
        $this->db->join('products_name', 'products_list.id_product = products_name.id_product', 'left');
        $this->db->join('products_desc', 'products_list.id_product = products_desc.id_product', 'left');
        $this->db->join('products_price', 'products_list.id_product = products_price.id_product', 'left');

        //$this->db->limit(0,10);

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {

            foreach ($query->result() as $row)
            {
                $products[] = (object) array(
                'product_id' => $row->id_product,
                'product_name' => $row->name,
                'product_desc' => $row->description,
                'product_image' => $row->image,
                'product_price' => $row->price,
                'product_active' => $row->active,
                'product_coin' => $this->session->userdata('site_coin'),
                'product_fprice' => $row->price." ".$this->session->userdata('site_coin')
                );
            }

            return $products;

        }
        else
        {
            return FALSE;
        }    
    }

    public function getProductById($id)
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
            foreach ($query->result() as $row)
            {
                $product = (object) array(
                'product_id' => $row->id_product,
                'product_name' => $row->name,
                'product_desc' => $row->description,
                'product_image' => $row->image,
                'product_price' => $row->price,
                'product_coin' => $this->session->userdata('site_coin'),
                'product_fprice' => $row->price." ".$this->session->userdata('site_coin')
                );
            }

            return $product;

        }
        else
        {
            return FALSE;
        }    
    }

    public function searchProducts($text)
    {
        $this->db->select('*');
        $this->db->like('name',$text);
        $this->db->where('products_name.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_desc.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_price.coin', $this->session->userdata('site_coin_id'));
        $this->db->from('products_list');
        $this->db->join('products_name', 'products_list.id_product = products_name.id_product', 'left');
        $this->db->join('products_desc', 'products_list.id_product = products_desc.id_product', 'left');
        $this->db->join('products_price', 'products_list.id_product = products_price.id_product', 'left');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $products[] = (object) array(
                'product_id' => $row->id_product,
                'product_name' => $row->name,
                'product_desc' => $row->description,
                'product_image' => $row->image,
                'product_price' => $row->price,
                'product_coin' => $this->session->userdata('site_coin'),
                'product_fprice' => $row->price." ".$this->session->userdata('site_coin')
                );
            }

            return $products;

        }
        else
        {
            return FALSE;
        }    
    }


    public function getLangs()
    {
        $this->db->select('*');
        $this->db->from('lang');
        $query = $this->db->get();

        $lang = FALSE;
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $lang[] =  array(
                'lang_id' => $row->id_lang,
                'lang_name' => $row->name
                );
            }
        }
        return $lang;
    }

    public function getCategoryList()
    {
        $this->db->select('*');
        $this->db->where('products_category_name.lang', $this->session->userdata('site_lang_id'));
        $this->db->join('products_category_name', 'products_category.id_category = products_category_name.id_category', 'left');
        $this->db->from('products_category');
        $query = $this->db->get();

        $category = FALSE;
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $category[] =  (object) array(
                'category_id' => $row->id_category,
                'category_name' => $row->name
                );
            }
        }
        return $category;
    }

    public function getCategory($id_category = 1)
    {
        $this->db->select('*');
        $this->db->where('products_list.category', $id_category);
        $this->db->where('products_name.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_desc.lang', $this->session->userdata('site_lang_id'));
        $this->db->where('products_price.coin', $this->session->userdata('site_coin_id'));
        $this->db->from('products_list');
        $this->db->join('products_name', 'products_list.id_product = products_name.id_product', 'left');
        $this->db->join('products_desc', 'products_list.id_product = products_desc.id_product', 'left');
        $this->db->join('products_price', 'products_list.id_product = products_price.id_product', 'left');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $products[] = (object) array(
                'product_id' => $row->id_product,
                'product_name' => $row->name,
                'product_desc' => $row->description,
                'product_image' => $row->image,
                'product_price' => $row->price,
                'product_active' => $row->active,
                'product_coin' => $this->session->userdata('site_coin'),
                'product_fprice' => $row->price." ".$this->session->userdata('site_coin')
                );
            }

            return $products;

        }
        else
        {
            return NULL;
        } 

        return FALSE;   
    }
    


    
}
?>