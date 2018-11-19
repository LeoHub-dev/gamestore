<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

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
        parent::__construct();

        $this->load->model('Admin_model');

        if(!$this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') != 1)
		{
			redirect('/home' ,'refresh');
		}

		$this->scope['category_list'] = $this->Shop_model->getCategoryList();
		$this->scope['products_list'] = $this->Shop_model->getProducts(true);
		$this->scope['users_list'] = $this->Admin_model->getUsers();
		$this->scope['unusedaddress_list'] = $this->Admin_model->getUnusedAddress();

    }

	public function index()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if(get_http_response_code('https://api.blockchain.info/v2/receive/checkgap?xpub='.$this->config->item('blockchain_xpub').'&key=eb60842a-f5d5-476a-94b9-eb541e037459') != "200")
		    {
		      $this->scope['xpub_gap'] = NULL;
		    }
		    else
		    {  
				$this->scope['xpub_gap'] = json_decode(file_get_contents('https://api.blockchain.info/v2/receive/checkgap?xpub='.$this->config->item('blockchain_xpub').'&key=eb60842a-f5d5-476a-94b9-eb541e037459'));
			}
			
			$this->load->model('Shop_model');
	        
			$this->load->view('Admin',$this->scope);
		}
	}

	public function invoice($id = NULL)
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($id == NULL)
			{
				redirect('/home' ,'refresh');
			}
			else
			{
				$this->scope['invoice'] = $this->Invoice_model->getInvoice($id);
				$this->scope['userinfo'] = $this->Admin_model->getUserInfo($this->scope['invoice']->id_user);
				$this->scope['blockchain'] = $this->Admin_model->getBlockchainInfo($this->scope['invoice']->id_invoice);
				$this->scope['steam'] = $this->Admin_model->getSteamInfo($this->scope['invoice']->cart_hash);

				if(!$this->scope['invoice'])
				{
					redirect('/home' ,'refresh');
				}
				$this->load->view('AdminInvoice',$this->scope);
			}
		}

	}

	public function listproducts()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$this->scope['format'] = 1;
			$this->scope['total_list'] = $this->Shop_model->getProducts(TRUE);
			$this->load->view('AdminList',$this->scope);
		}
	}

	public function liststock()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$this->scope['format'] = 2;
			$this->scope['total_list'] = $this->Admin_model->getStock();
			$this->load->view('AdminList',$this->scope);
		}
	}

	public function listblockpayments()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$this->scope['format'] = 5;
			$this->scope['total_list'] = $this->Admin_model->getBlockPayments();
			$this->load->view('AdminList',$this->scope);
		}
	}

	public function liststeampayments()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$this->scope['format'] = 6;
			$this->scope['total_list'] = $this->Admin_model->getSteamPayments();
			$this->load->view('AdminList',$this->scope);
		}
	}

	public function listusers()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$this->scope['format'] = 3;
			$this->scope['total_list'] = $this->Admin_model->getUsers();
			$this->load->view('AdminList',$this->scope);
		}
	}


	public function listhistory()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$this->scope['format'] = 4;
			$this->scope['total_list'] = $this->Admin_model->getHistory();
			$this->load->view('AdminList',$this->scope);
		}
	}

	public function addproduct()
	{
		//echo var_dump($this->input->post());
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{

	        
			if($this->Admin_model->addProduct($this->input->post()))
			{
				json_message_print("success","Item Added");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function uploadimg()
	{
		$output_dir = './assets/pimg/';

		if(isset($_FILES["imgPelicula"]))
		{
			$ret = array();
			
			//	This is for custom errors;	
			/*	$custom_error= array();
				$custom_error['jquery-upload-file-error']="File already exists";
				echo json_encode($custom_error);
				die();
			*/

			$error = $_FILES["imgPelicula"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData() 

			if(!is_array($_FILES["imgPelicula"]["name"])) //single file
			{
		 	 	$fileName = $_FILES["imgPelicula"]["name"];
		 	 	$nh = 1;
		 	 	while(file_exists(asset_url().'pimg/'.$fileName))
		        {
		            $fileName = $nh.'-'.$fileName;
		            $nh++;
		        }
		 		move_uploaded_file($_FILES["imgPelicula"]["tmp_name"],$output_dir.$fileName);
		    	$ret[] = $fileName;
			}
			else  //Multiple files, file[]
			{
			  $fileCount = count($_FILES["imgPelicula"]["name"]);

			  for($i=0; $i < $fileCount; $i++)
			  {

			  	$fileName = $_FILES["imgPelicula"]["name"][$i];
			  	$nh = 1;
		 	 	while(file_exists(asset_url().'pimg/'.$fileName))
		        {
		            $fileName = $nh.'-'.$fileName;
		            $nh++;
		        }
				move_uploaded_file($_FILES["imgPelicula"]["tmp_name"][$i],$output_dir.$fileName);
			  	$ret[]= $fileName;
			  }
			
			}

		    echo json_encode($ret);
	 	}
	}


	public function addstock()
	{
		//echo var_dump($this->input->post());
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->addStock($this->input->post()))
			{
				json_message_print("success","Item Added");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function adduser()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if ($this->form_validation->run('signup') == FALSE)
        	{
        		json_message_print("info",validation_errors());
        	}
        	else
        	{
				$this->Auth_model->setName($this->input->post('name'));
				$this->Auth_model->setEmail($this->input->post('email'));
		    	$this->Auth_model->setPassword(myHash($this->input->post('password')));

		    	if($this->Auth_model->register(1))
		    	{
					json_message_print("success","Item Added");
				}
				else
				{
					json_message_print("error","Error");
				}
			}
		}
	}

	public function addcategory()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->addCategory($this->input->post()))
			{
				json_message_print("success","Item Added");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function getinfocategory()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$data = $this->Shop_model->getCategoryList();

			echo json_encode($data);
		}

	}

	public function getinfostock()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$data = $this->Shop_model->getProducts();
			foreach ($data as $product) {
				$newdata[] = array_merge_returnobject($product, array('product_stock' => getStockById($product->product_id))); 
			}

			echo json_encode($newdata);
		}

	}

	public function removeproduct()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->removeProduct($this->input->post()))
			{
				json_message_print("warning","Item removed");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function removestock()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->removeStock($this->input->post()))
			{
				json_message_print("warning","Item removed");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function removeuser()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->removeUser($this->input->post()))
			{
				json_message_print("warning","User removed");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function removecategory()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->removeCategory($this->input->post()))
			{
				json_message_print("warning","Category removed");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function removeinvoice()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->removeInvoice($this->input->post()))
			{
				json_message_print("warning","Invoice removed");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function removeblockchain()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->removeBlockchain($this->input->post()))
			{
				json_message_print("warning","Blockchain payment removed");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function removesteam()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->removeSteam($this->input->post()))
			{
				json_message_print("warning","Steam removed");
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	

	public function getinfo()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$id = $this->input->post('id');
			$type = $this->input->post('type');

			if($type == 'product')
			{
				echo json_encode($this->Admin_model->getProductInfo($id));
			}
			else if($type == 'stock')
			{
				echo json_encode($this->Admin_model->getStockInfo($id));
			}
			else if($type == 'user')
			{
				echo json_encode($this->Admin_model->getUserInfo($id));
			}
			else if($type == 'invoice')
			{
				echo json_encode($this->Invoice_model->getInvoiceById($id));
			}
			else
			{
				json_message_print("error","Error");
			}
		}
	}

	public function edit()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			$type = $this->input->post('edit-type');

			if($type == 'product')
			{
				if($this->Admin_model->editProduct($this->input->post()))
				{
					json_message_print("success","Product edited");
				}
				else
				{
					json_message_print("error","Error");
				}
			}
			else if($type == 'stock')
			{
				if($this->Admin_model->editStock($this->input->post()))
				{
					json_message_print("success","Stock edited");
				}
				else
				{
					json_message_print("error","Error");
				}
			}
			else if($type == 'user')
			{
				if($this->Admin_model->editUser($this->input->post()))
				{
					json_message_print("success","User edited");
				}
				else
				{
					json_message_print("error","Error");
				}
			}
			else if($type == 'invoice')
			{
				if($this->Admin_model->editInvoice($this->input->post()))
				{
					json_message_print("success","Invoice edited");
				}
				else
				{
					json_message_print("error","Error");
				}
			}
		}	
	}

	public function editconfig()
	{
		if($this->Auth_model->isLoggedIn() && $this->session->userdata('id_user') == 1)
		{
			if($this->Admin_model->editConfig($this->input->post()))
			{
				json_message_print("success","Config edited");
			}
			else
			{
				json_message_print("error","Error");
			}
		}

	}

	





}
