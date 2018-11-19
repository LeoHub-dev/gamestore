<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

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


	public function index($page = 1)
	{
		$start = ($page * 12) - 12;
		$end = ($page * 12);

		$products = $this->Shop_model->getProducts();

		if($products)
		{
			$this->scope['products_list'] = array_slice($products, $start, $end);
			$this->scope['products_n'] = count($products);
			$this->scope['actual_page'] = $page;
		}
		else
		{
			$this->scope['products_list'] = FALSE;
			$this->scope['products_n'] = FALSE;
			$this->scope['actual_page'] = FALSE;
		}

		
		
		$this->load->view('Home',$this->scope);
	}

	public function product($id = NULL)
	{
		if($id == NULL)
		{
			redirect('/home' ,'refresh');
		}

		$this->scope['product'] = $this->Shop_model->getProductById($id);

		if(!$this->scope['product'])
		{
			redirect('/home' ,'refresh');
		}
		
		$this->load->view('Product',$this->scope);
	}

	public function category($id = NULL)
	{
		if($id == NULL)
		{
			redirect('/home' ,'refresh');
		}

		$page = $this->input->get('p');

		if(!$page)
		{
			$page = 1;
		}

		$start = ($page * 12) - 12;
		$end = ($page * 12);

		$products = $this->Shop_model->getCategory($id);

		if($products)
		{
			$this->scope['products_list'] =  array_slice($products, $start, $end);
			$this->scope['products_n'] = count($products);
			$this->scope['actual_page'] = $page;
			$this->scope['catid'] = $id;
		}
		else
		{
			$this->scope['products_list'] = FALSE;
			$this->scope['products_n'] = FALSE;
			$this->scope['actual_page'] = FALSE;
		}

		$this->load->view('Category',$this->scope);
	}

	public function search()
	{
		$text = $this->input->post('inf');

		if($text == NULL)
		{
			redirect('/home' ,'refresh');
		}

		$page = $this->input->get('p');

		if(!$page)
		{
			$page = 1;
		}

		$start = ($page * 12) - 12;
		$end = ($page * 12);

		$products = $this->Shop_model->searchProducts($text);

		if($products)
		{
			$this->scope['products_list'] =  array_slice($products, $start, $end);
			$this->scope['products_n'] = count($products);
			$this->scope['actual_page'] = $page;
		}
		else
		{
			$this->scope['products_list'] = FALSE;
			$this->scope['products_n'] = FALSE;
			$this->scope['actual_page'] = FALSE;
		}

		$this->load->view('Home',$this->scope);

	}


}
