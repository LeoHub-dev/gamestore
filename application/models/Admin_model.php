<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

	
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();

    }

    public function addProduct($data)
    {
        $this->load->model('Shop_model');

        $lang_list = $this->Shop_model->getLangs();

        $flag = 0;

        foreach ($lang_list as $lang) 
        {
            $lang_name = substr($lang['lang_name'], 0, 3);
            if(isset($data["name"][$lang_name]) && isset($data["desc"][$lang_name]))
            {
                $flag++;
            }
        }

        if($flag == 0)
        {
            return FALSE;
        }


        $data_list = array(
           'image' => asset_url().'pimg/'.$data["image"],
           'category' => $data["category"]
        );

        $q_productlist = $this->db->insert('products_list',$data_list); 
        $product_id = $this->db->insert_id();

        if($q_productlist)
        {
            foreach ($lang_list as $lang) 
            {
                $lang_name = substr($lang['lang_name'], 0, 3);
                if(isset($data["name"][$lang_name]) && isset($data["desc"][$lang_name]))
                {
                    $data_name = array(
                       'lang' => $this->config->item('lang')[$lang_name],
                       'name' => $data["name"][$lang_name][0],
                       'id_product' => $product_id
                    );

                    $this->db->insert('products_name',$data_name);

                    $data_desc = array(
                       'lang' => $this->config->item('lang')[$lang_name],
                       'description' => $data["desc"][$lang_name][0],
                       'id_product' => $product_id
                    );

                    $this->db->insert('products_desc',$data_desc);
                }

                /*foreach ($data['name'] as $langname) 
                {
                    
                }*/
            }
            
            $data_price = array(
               'price' => $data["price"],
               'id_product' => $product_id
            );

            $this->db->insert('products_price',$data_price); 

            return TRUE;
        }

        return FALSE;
    }

    public function addStock($data)
    {
        $data_stock = array(
           'id_product' => $data['producto'],
           'data' => $data["data"]
        );

        $query = $this->db->insert('products_content',$data_stock);

        if($query)
        {
            return TRUE;
        }

        return FALSE;

    }

    public function addCategory($data)
    {
        $lang_list = $this->Shop_model->getLangs();

        $band = 0;

        $this->db->insert('products_category',array('id_category' => NULL));

        $category_id = $this->db->insert_id();

        foreach ($lang_list as $lang) 
        {

            $lang_name = substr($lang['lang_name'], 0, 3);
            if(isset($data["category_name"][$lang_name]))
            {

                $data_cat = array(
                   'id_category' => $category_id,
                   'name' => $data["category_name"][$lang_name],
                   'lang' => $this->config->item('lang')[$lang_name],
                );

                $query = $this->db->insert('products_category_name',$data_cat);

                if($query)
                {
                    $band = 1;
                }

            }
        }

        if($band == 1)
        {
            return TRUE;
        }


        return FALSE;

    }

    public function getStock()
    {
        $this->db->select('*');
        $this->db->select('products_content.id AS stock_id');
        $this->db->where('products_name.lang', $this->session->userdata('site_lang_id'));
        $this->db->from('products_content');
        $this->db->join('products_name', 'products_content.id_product = products_name.id_product', 'left');
        $this->db->join('products_list', 'products_content.id_product = products_list.id_product', 'left');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $products[] = (object) array(
                'stock_id' => $row->stock_id,
                'product_id' => $row->id_product,
                'product_name' => $row->name,
                'product_data' => $row->data,
                'product_status' => $row->status
                );
            }

            return $products;

        }
        else
        {
            return FALSE;
        }    
    }

    public function getUnusedAddress()
    {
        $this->db->select('*');
        $this->db->from('blockchain_unused_address');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $address[] = array(
                'address' => $row->address,
                );
            }

            return $address;

        }
        else
        {
            return FALSE;
        }    
    }

    public function getBlockPayments()
    {
        $this->db->from('blockchain_invoice_payments');

        $query = $this->db->get();

        $payment = NULL;

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $blockchain)
            {
                $data = array_merge_returnobject($this->Invoice_model->getInvoiceById($blockchain->id_invoice),$blockchain);

                $this->db->select('address, date');
                $this->db->where('id_invoice', $blockchain->id_invoice);
                $this->db->from('blockchain_invoice');

                $query_address = $this->db->get();

                if($query_address->num_rows() > 0)
                {
                    foreach ($query_address->result() as $blockchain_address)
                    {
                        $data = array_merge_returnobject($data,$blockchain_address);
                    }
                }



                
                $payment[] = $data;
            }
        }
        
        return $payment;
    }

    public function getSteamPayments()
    {

        $this->db->from('invoice_csgo_payments');

        $query = $this->db->get();

        $payment = NULL;

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $csgo)
            {
                $data = array_merge_returnobject($this->Invoice_model->getInvoice($csgo->invoice_hash),$csgo);
                $payment[] = $data;
                //$payment[] = $this->Invoice_model->getInvoice($csgo->invoice_hash);
            }
        }
        
        return $payment;
    }

    public function getUsers()
    {
        $this->db->select('*');
        $this->db->from('auth_users');

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $users[] = (object) array(
                'id_user' => $row->id_user,
                'name' => $row->name,
                'email' => $row->email,
                'active' => $row->active
                );
            }

            return $users;

        }
        else
        {
            return FALSE;
        }  
    }

    public function getHistory()
    {
        $this->db->from('invoice');

        $query = $this->db->get();

        $history = NULL;

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $invoice)
            {
                $history[] = $this->Invoice_model->getInvoice($invoice->cart_hash);
            }
        }
        else
        {
            return FALSE;
        }

        return $history;

    }

    public function getNotification($all = 0)
    {
        $this->db->from('admin_notification');

        if($all == 0)
        {
            $this->db->where('status', 0);
        }

        $query = $this->db->get();

        $notification = NULL;

        if($query->num_rows() > 0)
        {
            $this->load->model('Profile_model');

            foreach ($query->result() as $not)
            {

                if($not->type == 1) //New user
                {
                    
                    $profile = $this->Profile_model->getProfile($not->data);

                    $notification[] = (object) array(
                    'id' => $not->id,
                    'type' => $not->type,
                    'data' => $profile
                    );
                }

                if($not->type == 2) //New invoice
                {
                    $invoice = $this->Invoice_model->getInvoice($not->data);

                    $notification[] = (object) array(
                    'id' => $not->id,
                    'type' => $not->type,
                    'data' => $invoice
                    );
                }

                if($not->type == 3) //New Blockchain Payment
                {
                    $info = explode(" ", $not->data);

                    $invoice = $this->Invoice_model->getInvoiceById($info[1]);

                    $notification[] = (object) array(
                    'id' => $not->id,
                    'type' => $not->type,
                    'data' => $invoice,
                    'value' => $info[0]
                    );
                }

                if($not->type == 4) //New steam payment
                {
                    $info = explode(" ", $not->data);

                    $invoice = $this->Invoice_model->getInvoice($info[1]);

                    $notification[] = (object) array(
                    'id' => $not->id,
                    'type' => $not->type,
                    'data' => $invoice,
                    'steam' => $info[0]
                    );
                }
            }
        }
        else
        {
            return FALSE;
        }

        return $notification;

    }

    public function getProductInfo($id_product)
    {

        $this->db->select('*');
        $this->db->where('id_product', $id_product);
        $this->db->from('products_list');

        $query_product = $this->db->get();

        foreach ($query_product->result() as $product_list)
        {
            $product_image = $product_list->image;
            $product_category = $product_list->category;
            $product_status = $product_list->active;

            $this->db->select('*');
            $this->db->where('id_product', $id_product);
            $this->db->from('products_name');

            $query_productname = $this->db->get();

            foreach ($query_productname->result() as $product_name_result)
            {
                $product_name[$product_name_result->lang] = $product_name_result->name;
            }

            $this->db->select('*');
            $this->db->where('id_product', $id_product);
            $this->db->from('products_desc');

            $query_productdesc = $this->db->get();

            foreach ($query_productdesc->result() as $product_desc_result)
            {
                $product_desc[$product_desc_result->lang] = $product_desc_result->description;
            }

            $this->db->select('*');
            $this->db->where('id_product', $id_product);
            $this->db->from('products_price');

            $query_productprice = $this->db->get();

            foreach ($query_productprice->result() as $product_price_result)
            {
                $product_price = $product_price_result->price;
            }
        }

        $product_general = array(
            'product_id' => $id_product,
            'product_image' => $product_image,
            'product_category' => $product_category,
            'product_name' => $product_name,
            'product_desc' => $product_desc,
            'product_price' => $product_price,
            'product_status' => $product_status
            );

        return $product_general;

          
    }

    public function getStockInfo($id_stock)
    {

        $this->db->select('*');
        $this->db->where('id', $id_stock);
        $this->db->from('products_content');

        $query_stock = $this->db->get();

        foreach ($query_stock->result() as $stock)
        {
            $stock_general = array(
            'stock_id' => $stock->id,
            'stock_idproduct' => $stock->id_product,
            'stock_invoice' => $stock->id_invoice,
            'stock_type' => $stock->type,
            'stock_data' => $stock->data,
            'stock_status' => $stock->status
            );
        }

        return $stock_general;

    }

    public function getUserInfo($id_user)
    {

        $this->db->select('*');
        $this->db->where('id_user', $id_user);
        $this->db->from('auth_users');

        $query_user = $this->db->get();

        foreach ($query_user->result() as $user)
        {
            $user_general = array(
            'id_user' => $user->id_user,
            'email' => $user->email,
            'name' => $user->name,
            'password' => $user->password,
            'active' => $user->active
            );
        }

        return $user_general;

    }

    public function getBlockchainInfo($invoice_id = NULL, $hash_blockchain = NULL)
    {
        $blockchain = null;

        $this->db->select('*');
        $this->db->where('id_invoice', $invoice_id);
        $this->db->from('blockchain_invoice_payments');

        $query_block = $this->db->get();

        foreach ($query_block->result() as $payment)
        {
            $this->db->select('address, date');
            $this->db->where('id_invoice', $invoice_id);
            $this->db->from('blockchain_invoice');

            $query_address = $this->db->get();

            if($query_address->num_rows() > 0)
            {
                foreach ($query_address->result() as $blockchain_address)
                {
                    $payment = array_merge_returnobject($payment,$blockchain_address);
                }
            }

            $blockchain[] = $payment;
        }

        return $blockchain;

    }

    public function getSteamInfo($invoice_hash = NULL)
    {
        $steam = null;

        $this->db->select('*');
        $this->db->where('invoice_hash', $invoice_hash);
        $this->db->from('invoice_csgo_payments');

        $query_steam = $this->db->get();

        foreach ($query_steam->result() as $payment)
        {
            $steam[] = $payment;
        }

        return $steam;

    }


    public function removeProduct($id)
    {
        $flag = 0;
        $query = $this->db->delete('products_list', array('id_product' => $id["id"]));

        if($query)
        {
            $flag++;
        }

        $query = $this->db->delete('products_name', array('id_product' => $id["id"]));

        if($query)
        {
            $flag++;
        }

        $query = $this->db->delete('products_desc', array('id_product' => $id["id"]));

        if($query)
        {
            $flag++;
        }

        $query = $this->db->delete('products_price', array('id_product' => $id["id"]));

        if($query)
        {
            $flag++;
        }

        $query = $this->db->delete('products_content', array('id_product' => $id["id"]));

        if($query)
        {
            $flag++;
        }

        if($flag == 5)
        {
            return TRUE;
        }


        return FALSE;
    }


    public function removeStock($id)
    {
        $flag = 0;
        $query = $this->db->delete('products_content', array('id' => $id["id"]));

        if($query)
        {
            $flag++;
        }
        
        if($flag == 1)
        {
            return TRUE;
        }


        return FALSE;
    }

    public function removeCategory($id)
    {
        $flag = 0;
        $query = $this->db->delete('products_category', array('id_category' => $id["id"]));

        if($query)
        {
            $flag++;
        }

        $query = $this->db->delete('products_category_name', array('id_category' => $id["id"]));

        if($query)
        {
            $flag++;
        }
        
        if($flag == 2)
        {
            return TRUE;
        }


        return FALSE;
    }

    public function removeUser($id)
    {
        $flag = 0;
        $query = $this->db->delete('auth_users', array('id_user' => $id["id"]));

        if($query)
        {
            $flag++;
        }
        
        if($flag == 1)
        {
            return TRUE;
        }


        return FALSE;
    }

    public function removeInvoice($id)
    {
        $flag = 0;
        $ex = $this->Invoice_model->getInvoiceById($id["id"]);

        $query = $this->db->delete('invoice', array('id_invoice' => $id["id"]));

        if($query)
        {
            $flag++;
        }


        $query = $this->db->delete('blockchain_invoice', array('id_invoice' => $id["id"]));

        if($query)
        {
            $flag++;
        }

        $query = $this->db->delete('blockchain_invoice_payments', array('id_invoice' => $id["id"]));


        if($query)
        {
            $flag++;
        }

        $query = $this->db->delete('invoice_csgo_payments', array('invoice_hash' => $ex->cart_hash));

        $file_path = 'invoice_data/'.$ex->cart_hash.'.json';

        if(file_exists($file_path))
        {
            unlink($file_path);
        }

        if($flag == 3)
        {
            return TRUE;
        }


        return FALSE;
    }

    public function removeBlockchain($id)
    {
        $flag = 0;
        $query = $this->db->delete('blockchain_invoice_payments', array('transaction_hash' => $id["id"]));

        if($query)
        {
            $flag++;
        }
        
        if($flag == 1)
        {
            return TRUE;
        }


        return FALSE;
    }

    public function removeSteam($id)
    {
        $flag = 0;
        $query = $this->db->delete('invoice_csgo_payments', array('id_csgo' => $id["id"]));

        if($query)
        {
            $flag++;
        }
        
        if($flag == 1)
        {
            return TRUE;
        }


        return FALSE;
    }



    public function editProduct($post)
    {

        $id = array('id_product' => $post['edit-id']);

        if (strpos($post['image'], 'http') !== false) {
            $image_new = $post['image'];
        }
        else
        {
            $image_new = asset_url().'pimg/'.$post['image'];
        }


        $data_plist = array(
            'image' => $image_new,
            'category' => $post['category'],
            'active' => $post['status']

        );

        $plist_status = $this->db->update('products_list', $data_plist, $id);

        foreach ($post['name'] as $id_lang => $val)
        {
            $id_pname = array('id_product' => $post['edit-id'], 'lang' => $id_lang);
            $data_pname = array(
                'name' => $val
            );

            $pname_status = $this->db->update('products_name', $data_pname, $id_pname);
        }

        foreach ($post['desc'] as $id_lang => $val)
        {
            $id_pdesc = array('id_product' => $post['edit-id'], 'lang' => $id_lang);
            $data_pdesc = array(
                'description' => $val
            );

            $pdesc_status = $this->db->update('products_desc', $data_pdesc, $id_pdesc);
        }

        $data_pprice = array(
            'price' => $post['price']
        );

        $pprice_status = $this->db->update('products_price', $data_pprice, $id);

        return TRUE;

    }

    public function editStock($post)
    {

        $id = array('id' => $post['edit-id']);

        $data_stock = array(
            'id_product' => $post['product'],
            'data' => $post['data'],
            'status' => $post['status']
        );

        $stock_status = $this->db->update('products_content', $data_stock, $id);

        if($stock_status)
        {
            return TRUE;
        }

        return FALSE;

    }

    public function editUser($post)
    {

        $id = array('id_user' => $post['edit-id']);

        $query = $this->db->get_where('auth_users', array('id_user' => $post['edit-id'], 'password' => $post['password']));

        if($query->num_rows() > 0)
        {

            $data_user = array(
                'name' => $post['name'],
                'email' => $post['email'],
                'active' => $post['status']
            );

            $user_status = $this->db->update('auth_users', $data_user, $id);

            if($user_status)
            {
                return TRUE;
            }

        }

        $data_user = array(
            'name' => $post['name'],
            'email' => $post['email'],
            'password' => myHash($post['password']),
            'active' => $post['status']
        );

        $user_status = $this->db->update('auth_users', $data_user, $id);

        if($user_status)
        {
            return TRUE;
        }

        return FALSE;

    }


    public function editInvoice($post)
    {

        $id = array('id_invoice' => $post['edit-id']);

        $invoice = $this->Invoice_model->getInvoiceById($post['edit-id']);

        $file_path = 'invoice_data/'.$invoice->cart_hash.'.json';

        if(file_exists($file_path))
        {
            $cart = (array) json_decode(file_get_contents($file_path));
            $cart['id_user'] = $post['user'];
            $cart['total_in_usd'] = (float) $post['totalusd'];
            $cart = (object) $cart;

            file_put_contents($file_path, json_encode($cart, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT));
        }
        else
        {
            return FALSE;
        }

        $data_invoice = array(
            'total_in_usd' => $post['totalusd'],
            'id_user' => $post['user'],
            'status' => $post['status']
        );

        $invoice_status = $this->db->update('invoice', $data_invoice, $id);

        if($invoice_status)
        {
            return TRUE;
        }

        return FALSE;

    }

    public function editConfig($post)
    {
        $nh = 1;

        foreach ($post as $key => $value) {
            $query = $this->db->update('config', array('value' => $value), array('id_config' => $key));
            if($query)
            {
                $nh++;
            }
            
        }
       
        if($nh != 1)
        {
            return TRUE;
        }

        return FALSE;

    }


    

    
}
?>