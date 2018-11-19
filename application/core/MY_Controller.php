<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $scope;

    public function __construct()
    {
        parent::__construct();

        if ($this->session->flashdata('notification')) 
        {
            $this->scope['notification'] = $this->session->flashdata('notification');
        }

        //Lang Scopes
        $this->scope['lang_coin'] = ($this->session->has_userdata('site_coin')) ? $this->session->userdata('site_coin') : '$';
        $this->scope['lang_coin_id'] = ($this->session->has_userdata('site_coin_id')) ? $this->session->userdata('site_coin_id') : '1';
        $this->scope['lang'] = ($this->session->has_userdata('site_lang')) ? $this->session->userdata('site_lang') : 'eng';
        $this->scope['lang_id'] = ($this->session->has_userdata('site_lang')) ? $this->session->userdata('site_lang_id') : '1';
        $this->scope['lang_list'] = $this->Shop_model->getLangs();

        //Cart Scopes
        $this->scope['cart_empty'] = $this->Cart_model->cartIsEmpty();

        if($this->scope['cart_empty'])
        {
            $this->scope['cart'] = NULL;
        }
        else
        {
            $this->scope['cart'] = $this->Cart_model->getCart();
        }

        $this->scope['cart_total'] = $this->Cart_model->getCartTotal();

        $this->scope['cart_nitems'] = $this->Cart_model->getNumberItems();

        $this->scope['admin_not'] = FALSE;

        if($this->Auth_model->isLoggedIn())
        {
            if($this->session->userdata('id_user') == 1)
            {
                $this->load->model('Admin_model');
                $this->scope['admin_on'] = TRUE;
                $this->scope['admin_not'] = $this->Admin_model->getNotification();
            }
        }

        $this->scope['category_nav_list'] = $this->Shop_model->getCategoryList();

        //User Scopes
        $this->scope['is_logged'] = $this->Auth_model->isLoggedIn();

        if($this->scope['is_logged'])
        {
            //Do stuff
        }
        
    }

    public function setlang($lang = 'eng')
	{
        $back = $this->input->get('gob');

        if(!isset($back) || empty($back))
        {
            $back = site_url('home');
        }

        if($lang == 'eng')
        {
            $this->session->set_userdata('site_lang','eng');
            $this->session->set_userdata('site_lang_id','1');
        }

        if($lang == 'esp')
        {
            $this->session->set_userdata('site_lang','esp');
            $this->session->set_userdata('site_lang_id','2');
        }

        redirect($back ,'refresh');
	}

    public function setcoin($coin = 'usd')
    {
        if($coin == 'usd')
        {
            $this->session->set_userdata('site_coin','$');
            $this->session->set_userdata('site_coin_id','1');
        }
        
        redirect('/home' ,'refresh');
    }

    public function notify()
    {

        if($this->Auth_model->isLoggedIn())
        {
            if($this->session->userdata('id_user') == 1)
            {
                $this->load->model('Admin_model');
                $notify_status = $this->db->update('admin_notification', array('status' => 1), array('id' => $this->input->post('id')));

                if($notify_status)
                {
                    return TRUE;
                }
            }
        }

        
    }
}

