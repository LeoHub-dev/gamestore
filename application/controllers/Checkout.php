<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends MY_Controller {

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


	public function index()
	{
		if($this->Cart_model->cartIsEmpty())
        {
        	redirect('/home' ,'refresh');
        }
        else
        {
			$this->load->view('Checkout',$this->scope);
        }
	}

	public function confirm()
	{
		if($this->Auth_model->isLoggedIn())
		{
			if(!$this->Cart_model->cartIsEmpty())
			{
				if($this->input->server('REQUEST_METHOD') == 'POST')
				{
					if($this->input->post('confirm'))
					{
						$invoice_hash = $this->Invoice_model->doInvoice($this->Cart_model->getCart());
						$this->Cart_model->cleanCart();

						if($invoice_hash != NULL)
						{
							redirect('/invoice/id/'.$invoice_hash ,'refresh');
						}
					}
				}
			}
			else
			{
				redirect('/home' ,'refresh');
			}
		}
		else
		{
			$this->session->set_userdata('go_back',TRUE);
			$this->session->set_userdata('go_back_url',site_url('checkout'));
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
	}

}
