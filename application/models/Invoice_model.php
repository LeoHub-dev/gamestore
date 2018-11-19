<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model {


	
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('blockchain_config');
        $this->load->library('Blockchain');

        
    }

    public function getTotal($cart)
    {
        $total_price = 0;

        foreach ($cart as $product) 
        {
            $total_price = $total_price + $product->product_price*$product->product_qty;
        }

        return $total_price;
    }

    public function doInvoice($cart)
    {

        $total_in_usd = $this->getTotal($cart);

        $total_in_btc = $this->blockchain->usdToBtc($total_in_usd);

        $cart = array_add_data($cart,'id_user',$this->session->userdata('id_user'));
        $cart = array_add_data($cart,'total_in_usd',$total_in_usd);
        $cart = array_add_data($cart,'total_in_btc',$total_in_btc);

        $hash = myHash(rand());
        $file_path = 'invoice_data/'.$hash.'.json';

        
        while(file_exists($file_path))
        {
            $hash = myHash(rand());
        }

        if(file_put_contents($file_path, json_encode($cart, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT)))
        {
            $data = array(
               'cart_hash' => $hash,
               'total_in_usd' => $total_in_usd,
               'total_in_btc' => $total_in_btc,
               'id_user' => $this->session->userdata('id_user'),
               'date' => date('Y-m-d')
            );

            $query = $this->db->insert('invoice',$data); 

            if($query)
            {
                //return $id_invoice = $this->db->insert_id();
                return $hash;
            }
            else
            {
                return FALSE;
            } 
        }
        else
        {
            return FALSE;
        }

    }

    public function getInvoice($cart_hash)
    {
        $file_path = 'invoice_data/'.$cart_hash.'.json';
        if(file_exists($file_path))
        {
            $cart = json_decode(file_get_contents($file_path));
        }
        else
        {
            return FALSE;
        }

        $this->db->where('cart_hash',$cart_hash);
        $query = $this->db->get('invoice');

        if($query->num_rows()==1)
        {
            foreach ($query->result() as $row)
            {
                $data = $row;
            }
        }
        else
        {
            return FALSE;
        }

        $data = array_merge_returnobject($data,$cart);

        return $data;

    }

    public function getInvoiceById($id)
    {
        $this->db->where('id_invoice',$id);
        $query = $this->db->get('invoice');

        if($query->num_rows()==1)
        {
            foreach ($query->result() as $row)
            {
                $data = $row;
            }

            $file_path = 'invoice_data/'.$data->cart_hash.'.json';
            if(file_exists($file_path))
            {
                $cart = json_decode(file_get_contents($file_path));
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }


        $data = array_merge_returnobject($data,$cart);

        return $data;

    }

    public function verifyPaymentBlockchain($cart_hash)
    {
        $file_path = 'invoice_data/'.$cart_hash.'.json';
        if(file_exists($file_path))
        {
            $cart = json_decode(file_get_contents($file_path));
        }
        else
        {
            return FALSE;
        }

        if($cart->id_user != $this->session->userdata('id_user'))
        {
            return FALSE;
        }

        $this->db->where('cart_hash',$cart_hash);
        $query = $this->db->get('invoice');

        $paid = 0;

        if($query->num_rows()==1)
        {

            foreach ($query->result() as $row)
            {
                $data = $row;

                if($row->status == $this->config->item('status')['paid'] || $row->status == $this->config->item('status')['claimed'])
                {
                    return TRUE;
                }

                $this->db->where('id_invoice',$row->id_invoice);
                $query_block = $this->db->get('blockchain_invoice_payments');

                if($query_block->num_rows()>0)
                {
                    foreach ($query_block->result() as $block)
                    {
                        $paid = $paid + $block->value;
                    }

                    if($data->total_in_btc <= $paid)
                    {

                        $invoice_status = $this->db->update('invoice', array('status' => $this->config->item('status')['paid']), array('id_invoice' => $row->id_invoice));

                        //ENVIAR INVOICE

                        if($invoice_status)
                        {
                            return TRUE;
                        }
                        
                    }
                }
            }

        }
        else
        {
            return FALSE;
        }
    }

    public function claimProduct($cart_hash)
    {
        $invoice = $this->getInvoice($cart_hash);

        $products_claimed = NULL;

        foreach ($invoice as $key => $product) 
        {
            if(is_numeric($key))
            {
                for ($i=0; $i < $product->product_qty; $i++) {

                    $this->db->where('id_product',$product->product_id);
                    $this->db->where('status',0);
                    $query = $this->db->get('products_content',1);

                    if($query->num_rows()>0)
                    {
                        foreach ($query->result() as $row) 
                        {
                     
                            if($row->status == $this->config->item('status')['claimed'])
                            {
                                continue;
                            }

                            $product_status = $this->db->update('products_content', array('id_invoice' => $invoice->id_invoice, 'status' => 1), array('id' => $row->id));

                            if($product_status)
                            {
                                $products_claimed['data_'.$row->id_product][] = (object) array(
                                    'product_content_id' => $row->id_product,
                                    'product_content_type' => $row->type,
                                    'product_content_data' => $row->data
                                );
                            }
                        }
                    }
                }
            }
            else
            {
                continue;
            }
        }

        if($products_claimed == NULL)
        {
            return FALSE;
        }

        $data = array_merge_returnarray($invoice,$products_claimed);

        if($invoice->status != $this->config->item('status')['claimed'])
        {
            $this->load->model('Mail_model');
            $this->Mail_model->setTo($this->session->userdata('email'));
            $data_mail = array( 
            "products_claimed" => $data,
            "pdf" => $cart_hash
            );
            $this->Mail_model->setMessage($data_mail);
            $this->Mail_model->sendMail('emailproducts');
        }

        $invoice_status = $this->db->update('invoice', array('status' => $this->config->item('status')['claimed']), array('id_invoice' => $invoice->id_invoice));

        return $data;


    }


    public function showProducts($cart_hash)
    {
        $invoice = $this->getInvoice($cart_hash);

        $products_claimed = NULL;

        foreach ($invoice as $key => $product) 
        {
            if(is_numeric($key))
            {

                $this->db->where('id_product',$product->product_id);
                $this->db->where('id_invoice',$invoice->id_invoice);
                $query = $this->db->get('products_content');

                if($query->num_rows()>0)
                {
                    foreach ($query->result() as $row) 
                    {
                        $products_claimed['data_'.$row->id_product][] = (object) array(
                            'product_content_id' => $row->id_product,
                            'product_content_type' => $row->type,
                            'product_content_data' => $row->data
                        );
                    }
                }
                
            }
            else
            {
                continue;
            }
        }

        if($products_claimed == NULL)
        {
            return FALSE;
        }

        $data = array_merge_returnarray($invoice,$products_claimed);

        return $data;


    }



    public function callback($invoice_id,$value,$transaction_hash,$address,$secret,$confirmations)
    {
    
        $this->db->where('id_invoice',$invoice_id);
        $query = $this->db->get('invoice');

        if($query->num_rows()==1)
        {
            foreach ($query->result() as $row)
            {
                $invoice_address = $row->address;
            }
        }

        if($address != $invoice_address)
        {
            //return FALSE;
            echo "*bad*";
        }

        if($secret != $this->config->item('blockchain_secret'))
        {
            //return FALSE;
            echo "*bad*";
        }

        if($confirmations >= 1)
        {
            $data = array(
               'id_invoice' => $invoice_id,
               'transaction_hash' => $transaction_hash,
               'value' => ($value/100000000)
            );

            $query = $this->db->insert('invoice_payments',$data); 

            $this->db->where('id_invoice', $invoice_id);

            $this->db->delete('invoice_pending_payments');

            if($query)
            {
                echo "*ok*";
            }
        }
        else
        {
            $data = array(
               'id_invoice' => $invoice_id,
               'transaction_hash' => $transaction_hash,
               'value' => $value
            );

            $this->db->insert('invoice_pending_payments',$data); 

            echo "Waiting for confirmations";

        }
    }

}
?>