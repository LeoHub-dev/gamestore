<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

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
		if ($this->session->flashdata('error')) 
		{
	    	$this->scope['error'] = $this->session->flashdata('error');
		}
		else
		{
			$this->scope['error']['form'] = NULL; 
		}

		$this->scope['signup'] = $this->input->get('p');

		if(!$this->Auth_model->isLoggedIn())
		{
			$this->load->view('Auth',$this->scope);
		}
		else
		{
			redirect('/profile' ,'refresh');
		}
	}


	public function login()
	{

		if(!$this->Auth_model->isLoggedIn())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				if ($this->form_validation->run('login') == FALSE)
	        	{
	        		$this->session->set_flashdata('error', array(
	        			'form' => 'login',
	        			'error' => validation_errors()));
    				redirect('/auth' ,'refresh');
	        	}
	        	else
	        	{

	        		$this->Auth_model->setEmail($this->input->post('email'));
		        	$this->Auth_model->setPassword(myHash($this->input->post('password')));

		        	if($this->Auth_model->login())
		        	{
		        		if($this->session->userdata('go_back'))
		        		{
		        			$this->session->set_userdata('go_back_app',TRUE);
		        		}
		        		redirect('/profile' ,'refresh');
		            }
		            else
		            {
		            	$this->session->set_flashdata('error', array(
	        			'form' => 'login',
	        			'error' => 'Email or password invalid'));
		            	redirect('/auth' ,'refresh');
		            }
	        	}
	        }
	        else
	        {
	        	redirect('/auth' ,'refresh');
	        }
		}
		else
		{
			redirect('/profile' ,'refresh');
		}

	}

	public function signup()
	{
		if(!$this->Auth_model->isLoggedIn())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				if ($this->form_validation->run('signup') == FALSE)
	        	{
	        		$this->session->set_flashdata('error', array(
	        			'form' => 'signup',
	        			'error' => validation_errors()));
    				redirect('/auth' ,'refresh');
	        	}
	        	else
	        	{
	        		$this->Auth_model->setName($this->input->post('name'));
	        		$this->Auth_model->setEmail($this->input->post('email'));
		        	$this->Auth_model->setPassword(myHash($this->input->post('password')));

		        	if($this->Auth_model->register())
		        	{
	        			$this->session->set_flashdata('notification', array(
        				'type' => 'success',
	        			'title' => $this->lang->line('mail_mailconfirm_title'),
	        			'content' => $this->lang->line('mail_mailconfirm').' <strong>'. $this->input->post('email').'</strong>'
	        			));

	        			$this->load->model('Mail_model');
	        			$this->Mail_model->setTo($this->input->post('email'));
	        			$data = array( 
	        				"email" => $this->input->post('email'),
	        				"hash" => $this->Auth_model->getHash()
	        				);

	        			$this->Mail_model->setMessage($data);
	        			$this->Mail_model->sendMail('emailconfirm');


						redirect('/auth' ,'refresh');

		            }
		            else
		            {
		            	redirect('/auth' ,'refresh');
		            }
	        	}
	        }
	        else
	        {
	        	redirect('/auth' ,'refresh');
	        }
		}
		else
		{
			redirect('/profile' ,'refresh');
		}
	}

	public function confirm($id = NULL)
	{
		if($id == NULL)
		{
			redirect('/auth' ,'refresh');
		}

		if($this->Auth_model->isConfirmedHash($id))
		{
			$this->session->set_flashdata('notification', array(
			'type' => 'info',
			'title' => $this->lang->line('auth_error_alrdyconfirm'),
			'content' => $this->lang->line('auth_error_accountconfirmed')
			));
			redirect('/auth' ,'refresh');
		}
		else
		{
			if($this->Auth_model->confirmAccount($id))
			{
				$this->session->set_flashdata('notification', array(
				'type' => 'success',
				'title' => $this->lang->line('auth_confirmed'),
				'content' => $this->lang->line('auth_confirmed_msg')
				));
				redirect('/auth' ,'refresh');
			}
		}
	}

	public function logout()
	{
		header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        //$this->session->sess_destroy();

        $sess_array = $this->session->all_userdata();
		foreach($sess_array as $key =>$val)
		{
		   	if($key!='site_lang')
		   	{
		   		$this->session->unset_userdata($key);
		   	}
		}

        redirect('/' ,'refresh');
        exit;
    }

    public function resetpassword()
	{
		if(!$this->Auth_model->isLoggedIn())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				$password = $this->input->post('password');
				$password_confirm = $this->input->post('confirm_password');
				$hash = $this->input->post('hash');
				$email = $this->input->post('email');

				if($password == $password_confirm)
				{
					if($this->Auth_model->newPassword($password,$hash,$email))
					{
						$this->session->set_flashdata('notification', array(
						'type' => 'success',
						'title' => $this->lang->line('notif_newpasswordset'),
						'content' => $this->lang->line('notif_newpasswordset_content')
						));
						redirect('/auth' ,'refresh');
					}
					else
					{
						$this->session->set_flashdata('notification', array(
						'type' => 'error',
						'title' => 'Error',
						'content' => $this->lang->line('notif_error')
						));
						redirect('/resetpassword?hash='.$hash.'$email='.$email ,'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('notification', array(
					'type' => 'error',
					'title' => 'Error',
					'content' => $this->lang->line('notif_passwordnotsame')
					));
					redirect('/resetpassword?hash='.$hash.'$email='.$email ,'refresh');
				}
			}
			else
			{
				$this->scope['hash'] = $this->input->get('hash');
				$this->scope['email'] = $this->input->get('email');

				if($this->Auth_model->verifyForgot($this->scope['hash'],$this->scope['email']))
				{
					$this->load->view('Forgot',$this->scope);
				}
			}
		}

    }

    public function forgotpw()
    {
    	if(!$this->Auth_model->isLoggedIn())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				if($this->Auth_model->isNotUniqueMail($this->input->post('email')))
				{
					if($this->Auth_model->isConfirmed($this->input->post('email')))
					{
						if($this->Auth_model->forgotPassword($this->input->post('email')))
						{
							json_message_print("success",'A email has been send');
						}
					}
					else
					{
						json_message_print("error",'You must confirm');
					}
				}
				else
				{
					json_message_print("error",'Email doesnt exist');
				}
			}
		}
		else
		{
			json_message_print("error",'You are log in');
		}
    }





}
