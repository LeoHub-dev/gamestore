<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	//public $scope;

	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->model('Profile_model');

    }

	public function index()
	{
		if(!$this->Auth_model->isLoggedIn())
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
		$this->scope["user"] = $this->Profile_model->getProfile($this->session->userdata('id_user'));
		$this->load->view('Profile',$this->scope);
	}

	public function history()
	{
		if(!$this->Auth_model->isLoggedIn())
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
		$this->scope["history"] = $this->Profile_model->getBuyHistory($this->session->userdata('id_user'));
		$this->load->view('History',$this->scope);
	}

	public function wishlist()
	{
		if(!$this->Auth_model->isLoggedIn())
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
		$this->scope["wishlist"] = $this->Profile_model->getWishlist($this->session->userdata('id_user'));
		$this->load->view('Wishlist',$this->scope);
	}

}
