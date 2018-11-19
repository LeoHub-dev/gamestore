<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends CI_Model {

	public $to;
    //public $from = "leonardo.jimenez@e-socialtech.com";
    public $from = "admin@leohub.com.ve";
    public $from_name = "Support GetYourGames";
	public $subject;
    public $message;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
        

        $config = Array(   
            'protocol' => 'smtp',
            'smtp_host' => 'mail.leohub.com.ve',
            'smtp_port' => 26,
            'smtp_user' => 'admin@leohub.com.ve',
            'smtp_pass' => '24865terry',
            'smtp_timeout' => '30', //in seconds 
            'smtp_keepalive' => true,  
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );

        /*$config = Array(      
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );*/
        
        $this->load->library('email',$config);


        
	}

	/**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setTo($email)
    {
        $this->to = $email;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setSubject($title)
    {
        $this->subject = $title;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }


	public function sendMail($type = "general")
	{

        $this->email->from($this->from, $this->from_name);
        $this->email->to($this->to);
        $this->email->cc($this->config->item('general_email'));

        if($type == "general")
        {
            $this->email->subject($this->subject);
            $message_html = $this->load->view('mails/general_mail_format',$this->message,TRUE);
            $this->email->message($message_html);
        }

        if($type == "buttonlink")
        {
            $this->email->subject($this->subject);
            $message_html = $this->load->view('mails/emailbutton_mail_format',$this->message,TRUE);
            $this->email->message($message_html);
        }

        if($type == "emailconfirm")
        {
            $subject = 'Email Confirmation';
            $this->email->subject($subject);
            $message_html = $this->load->view('mails/emailconfirm_mail_format',$this->message,TRUE);
            $this->email->message($message_html);
        }

        if($type == "emailproducts")
        {
            $subject = 'Products you claim';
            $this->email->subject($subject);
            $message_html = $this->load->view('mails/emailinvoice_mail_format',$this->message,TRUE);
            $this->email->message($message_html);
        }

        $this->email->send();

        
	}



    
}
?>