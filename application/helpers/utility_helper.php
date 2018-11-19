<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function asset_url()
{
   return base_url().'assets/';
}

function array_merge_returnobject($array1,$array2)
{
	$result = (object) array_merge( (array)$array1, (array)$array2 );
	return $result;
}

function array_merge_returnarray($array1,$array2)
{
	$result = (array) array_merge( (array)$array1, (array)$array2 );
	return $result;
}

function json_message_print($type,$message)
{
	$message = json_encode(array ("msg_type" => $type, "msg_text" => $message));
	echo $message;
}

function array_add_message($array,$type,$message,$print = 0)
{
	$result = (object) array_merge( (array)$array, array ("msg_type" => $type, "msg_text" => $message) );

	if($print == 1)
	{
		echo json_encode($result);
	}
	else
	{
		return $result;
	}
	
}

function getStockById($id)
{
	$ci =& get_instance();
    $ci->db->select('*');
    $ci->db->where('id_product',$id);
    $ci->db->where('status',0);
    $query = $ci->db->get('products_content');

    $total = 0;

    if($query->num_rows() > 0)
    {
        foreach ($query->result() as $row)
        {
            $total++;
        }

        

    }

    return $total;    
}

function getUserById($id)
{
	$ci =& get_instance();
    $ci->db->select('*');
    $ci->db->where('id_user',$id);
    $query = $ci->db->get('auth_users');

    if($query->num_rows() > 0)
    {
        foreach ($query->result() as $row)
        {
            return $row; 
        }
    }

    return FALSE;    
}

function array_add_data($array,$var,$value,$print = 0)
{
	$result = (object) array_merge( (array)$array, array ($var => $value) );

	if($print == 1)
	{
		echo json_encode($result);
	}
	else
	{
		return $result;
	}
	
}

function get_http_response_code($url) 
{
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function invoiceStatus($n)
{
	if($n == 1)
	{
		echo '<font color="red">'.lang("status_notpaid").'</font>';
	}
	if($n == 2)
	{
		echo '<font color="#1da796">'.lang("status_paid").'</font>';
	}
	if($n == 3)
	{
		echo lang("status_claimed");
	}
	if($n == 4)
	{
		echo lang("status_steam");
	}
}

function invoiceStatusList()
{
	$ci =& get_instance();
    $ci->db->select('*');
    $ci->db->where('lang',$ci->session->userdata('site_lang_id'));
    $query = $ci->db->get('invoice_status');

    if($query->num_rows() > 0)
    {
        foreach ($query->result() as $row)
        {
            $invoice_status[] = $row;
        }

        return $invoice_status;
    }



    return FALSE;   
}

function myHash($value)
{
    $hashed_value = sha1(md5(md5(sha1($value."leohub923"))));
    return $hashed_value;
}

function lowercase($info) 
{
  	return strtolower($info);
}
?>