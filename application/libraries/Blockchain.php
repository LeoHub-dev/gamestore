<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blockchain{

    private $blockchain_root;
    private $blockchain_receive_root;
    private $blockchain_secret;
    private $blockchain_xpub;
    private $blockchain_apikey;
	
    public function __construct()
    {
        // Call the CI_Model constructor
        $this->config->load('blockchain_config');

        $query = $this->db->get_where('config', array('id_config' => 1));

        foreach ($query->result() as $row)
        {
            $this->blockchain_xpub = $row->value;
        }

        $this->blockchain_root = $this->config->item('blockchain_root');
        $this->blockchain_receive_root = $this->config->item('blockchain_receive_root');
        $this->blockchain_secret = $this->config->item('blockchain_secret');
        $this->blockchain_apikey = $this->config->item('blockchain_apikey');

        
    }

    public function blockChainAddress($id_invoice)
    {

        $this->db->where('id_invoice',$id_invoice);

        $blockchain_address = $this->db->get('blockchain_invoice');

        if($blockchain_address->num_rows()==0)
        {

            $blockchain_unused_address = $this->db->get('blockchain_unused_address',1);

            if($blockchain_unused_address->num_rows() > 0)
            {
                foreach($blockchain_unused_address->result() as $address)
                {
                    $blockchain_invoice = array(
                       'id_invoice' => $id_invoice,
                       'address' => $address->address,
                       'datetime' => date('Y-m-d H:i:s')
                    );

                    $this->db->where('id_address', $address->id_address);
                    $this->db->delete('blockchain_unused_address');
                }
            }
            else
            {
                $callback_url = site_url('invoice/blockchain_callback')."?invoice_id=" . $id_invoice . "&secret=" . $this->blockchain_secret;
                if(get_http_response_code('https://api.blockchain.info/v2/receive/checkgap?xpub='.$this->config->item('blockchain_xpub').'&key=eb60842a-f5d5-476a-94b9-eb541e037459') != "200")
                {
                    return FALSE;
                }
                
                $getadress = file_get_contents($this->blockchain_receive_root . "v2/receive?key=" . $this->blockchain_apikey . "&callback=" . urlencode($callback_url) . "&xpub=" . $this->blockchain_xpub);
                $data = json_decode($getadress);

                $blockchain_invoice = array(
                   'id_invoice' => $id_invoice,
                   'address' => $data->address,
                   'datetime' => date('Y-m-d H:i:s')
                );
            }
            
            $query = $this->db->insert('blockchain_invoice',$blockchain_invoice); 

            return (object) $blockchain_invoice;
        }
        else
        {
            foreach ($blockchain_address->result() as $row)
            {
                $data = array(
                'id_invoice' => $row->id_invoice,
                'address'=> $row->address
                );

                return (object) $data;
            }
        }
        return FALSE;
    }

    public function usdToBtc($amount)
    {
        $total_in_btc = file_get_contents($this->blockchain_root . "tobtc?currency=USD&value=" . $amount);
        return $total_in_btc;
    }

    public function callback($id_invoice,$value,$transaction_hash,$address,$secret,$confirmations)
    {
    
        $this->db->where('id_invoice',$id_invoice);
        $query = $this->db->get('blockchain_invoice');

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
            $response = "*bad*";
        }

        if($secret != $this->blockchain_secret)
        {
            //return FALSE;
            echo "*bad*";
        }

        if($confirmations >= 1)
        {
            $data = array(
               'id_invoice' => $id_invoice,
               'transaction_hash' => $transaction_hash,
               'value' => ($value/100000000)
            );

            $query = $this->db->insert('blockchain_invoice_payments',$data); 

            $this->db->where('id_invoice', $id_invoice);

            $this->db->delete('blockchain_invoice_pending_payments');

            if($query)
            {
                echo "*ok*";
            }
        }
        else
        {
            $data = array(
               'id_invoice' => $id_invoice,
               'transaction_hash' => $transaction_hash,
               'value' => $value
            );

            $this->db->insert('blockchain_invoice_pending_payments',$data); 

            echo "Waiting for confirmations";

        }
    }

    public function store_unused_address()
    {
        $this->db->select('*');
        $this->db->where('invoice.status',1);
        $this->db->or_where('invoice.status', 4);
        $this->db->from('blockchain_invoice');
        $this->db->join('invoice', 'blockchain_invoice.id_invoice = invoice.id_invoice', 'left');
        $query_blockchain = $this->db->get();

        if($query_blockchain->num_rows() > 0)
        {
            foreach ($query_blockchain->result() as $blockchain_invoice)
            {
                $actual_datetime = new DateTime();
                $blockinvoice_datetime = new DateTime($blockchain_invoice->datetime);
                $blockinvoice_datetime->modify('+15 minutes');

                if($actual_datetime >= $blockinvoice_datetime)
                {
                    $this->db->select('*');
                    $this->db->where('id_invoice',$blockchain_invoice->id_invoice);
                    $this->db->from('blockchain_invoice_payments');

                    $query_blockchainpayments = $this->db->get();

                    if($query_blockchainpayments->num_rows() <= 0)
                    {
                        $this->db->where('id_invoice', $blockchain_invoice->id_invoice);
                        $this->db->delete('blockchain_invoice');

                        $data = array(
                           'address' => $blockchain_invoice->address
                        );

                        $this->db->insert('`blockchain_unused_address',$data); 
                    }
                }
            }
        }
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }

}
?>