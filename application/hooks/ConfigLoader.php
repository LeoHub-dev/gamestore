<?php
class ConfigLoader
{
    function initialize() 
    {
  
        $ci =& get_instance();

        $query= $ci->db->get('config');

        foreach ($query->result() as $row)
        {
        	if($row->id_config == 1)
        	{
        		$ci->config->set_item('blockchain_xpub', $row->value);
        	}

        	if($row->id_config == 2)
        	{
        		$ci->config->set_item('general_email', $row->value);
        	}
        	
        }

        

    }
}