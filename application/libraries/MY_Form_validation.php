<?php
class MY_Form_validation extends CI_Form_validation 
{    
 	function __construct($config = array()){
        $config['error_prefix'] = '<p><font color="#ec1a3a">';
        $config['error_suffix'] = '</font></p>';
      	parent::__construct($config);
 	}
     
 	public function isUniqueMail($email)
    {
        $this->db->where('email',$email);

        $query = $this->db->get('auth_users');

        if($query->num_rows() == 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }    
    }

    public function isNotUniqueMail($email)
    {
        $this->db->where('email',$email);

        $query = $this->db->get('auth_users');

        if($query->num_rows() == 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }   
    }

    public function isConfirmed($email)
    {
        $this->db->where('email',$email);

        $query = $this->db->get('auth_users');

        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row)
            {
                if($row->active == 0)
                {
                    return FALSE;
                }
            }
        }

        return TRUE;    
    }

    public function __get($var)
    {
        return get_instance()->$var;
    }
}