<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public $email;
	public $password;
    public $name;
    public $repassword;
	public $type;
	public $date;
	public $hash;
	public $active;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	/**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets the value of type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets the value of date.
     *
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Gets the value of hash.
     *
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Gets the value of active.
     *
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function setRePassword($repassword)
    {
        $this->repassword = $repassword;

        return $this;
    }

    /**
     * Sets the value of type.
     *
     * @param mixed $type the type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Sets the value of date.
     *
     * @param mixed $date the date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Sets the value of hash.
     *
     * @param mixed $hash the hash
     *
     * @return self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Sets the value of active.
     *
     * @param mixed $active the active
     *
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

	public function login()
	{
		$this->db->where('email',$this->email);
		$this->db->where('password',$this->password);
		$query = $this->db->get('auth_users');
		if($query->num_rows()==1)
        {
			foreach ($query->result() as $row)
            {
				$data = array(
				'email'=> $row->email,
                'name'=> $row->name,
                'id_user'=> $row->id_user,
				'logged_in'=>TRUE
				);
			}
			$this->session->set_userdata($data);
			return TRUE;
		}
		else
        {
			return FALSE;
		}    
	}

    public function register($admin = 0)
    {

        $data = array(
           'email' => $this->email,
           'name' => $this->name,
           'hash' => $this->makeHash($this->email),
           'password' => $this->password,
           'date' => date('Y-m-d')
        );

        if($admin == 1)
        {
            $active = array('active' => 1);
            $data = $data + $active;
        }

        $query = $this->db->insert('auth_users',$data); 

        if($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }   

    }

    public function confirmAccount($hash)
    {
        $data = array(
            'active' => '1'
        );

        $this->db->where('hash', $hash);
        $query = $this->db->update('auth_users', $data);

        if($query)
        {
            return TRUE;
        }

        return FALSE;
    }

    public function makeHash($email)
    {
        $n = 0;
        $hash = myHash($email.$n);

        $this->db->where('hash',$hash);
        $query = $this->db->get('auth_users');
        while($query->num_rows()>0)
        {
            $hash = myHash($email.$n++);
            $this->db->where('hash',$hash);
            $query = $this->db->get('auth_users');
        }
        $this->hash = $hash;
        return $hash;


    }

    public function isNotUniqueMail($email)
    {
        $this->db->where('email',$email);

        $query = $this->db->get('auth_users');

        if($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }      
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

    public function isConfirmedHash($hash)
    {
        $this->db->where('hash',$hash);

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

	public function isLoggedIn(){
		
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        $is_logged_in = $this->session->userdata('logged_in');

        if(!isset($is_logged_in) || $is_logged_in!==TRUE)
        {
            return FALSE;
        }

        return TRUE;
    }

    public function forgotPassword($email)
    {

        $email_id = array('email' => $email);
        $hash = $this->makeHash($email.'confirm');

        $data = array(
        'hash' => $hash,
        );

        $update = $this->db->update('auth_users', $data, $email_id);

        if($update)
        {
            $this->load->model('Mail_model');
            $this->Mail_model->setTo($email);

            $data_mail = array( 
            "title" => 'To reset your password',
            "link" => site_url('auth/resetpassword?hash='.$hash.'&email='.$email),
            "text_button" => 'Click here'
            );
            $this->Mail_model->setSubject('Forgot Password');
            $this->Mail_model->setMessage($data_mail);
            $this->Mail_model->sendMail('buttonlink');

            return TRUE;
        }

        return FALSE;
    }

    public function verifyForgot($hash,$email)
    {
        $this->db->where('hash',$hash);
        $this->db->where('email',$email);

        $query = $this->db->get('auth_users');

        if($query->num_rows()>0)
        {
            foreach ($query->result() as $row)
            {
                return TRUE;
            }
        }

        return FALSE;  
    }

    public function newPassword($password,$hash,$email)
    {
        $id = array('email' => $email, 'hash' => $hash);

        $new_password = myHash($password);

        $data = array(
        'password' => $new_password,
        'hash' => 'None'
        );

        $update = $this->db->update('auth_users', $data, $id);

        if($update)
        {
            return TRUE;
        }

        return FALSE;


    }



    
}
?>