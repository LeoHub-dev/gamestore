<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller {

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
		$this->load->view('Cart',$this->scope);
	}

	public function addcart()
	{
		$id = $this->input->post('id');
		$qty = $this->input->post('qty');

		if(trim(empty($id)) || trim($id) == "" || $id == NULL || !is_numeric($id) || trim(empty($qty)) || trim($qty) == "" || $qty == NULL || !is_numeric($qty))
		{
			json_message_print("error",$this->lang->line('notif_cart_invalid'));
		}
		else
		{
			if($qty <= 0)
			{
				$qty = 1;
			}

			if($this->Cart_model->existInCart($id))
			{
				json_message_print("error",$this->lang->line('notif_cart_alrdyadded'));
				exit(0);
			}

			$response = $this->Cart_model->addToCart($id,$qty);

			if(isset($response->error) && $response->error == 1)
			{
				json_message_print("error",$this->lang->line('notif_cart_outstock'));
				exit(0);
			}

			if($response == NULL)
			{
				json_message_print("error",$this->lang->line('notif_cart_notfound'));
			}
			else
			{
				array_add_message($response,"success",$this->lang->line('notif_cart_added'),1);
			}

		}

	}

	public function addwish()
	{
		$id = $this->input->post('id');

		if(trim(empty($id)) || trim($id) == "" || $id == NULL || !is_numeric($id))
		{
			json_message_print("error",$this->lang->line('notif_cart_invalid'));
		}
		else
		{
			if($this->Cart_model->existInWish($id))
			{
				json_message_print("error",$this->lang->line('notif_cart_alrdyadded'));
				exit(0);
			}

			$response = $this->Cart_model->addToWish($id);

			if($response == NULL)
			{
				json_message_print("error",$this->lang->line('notif_cart_notfound'));
			}
			else
			{
				json_message_print("success",$this->lang->line('notif_wish_added'));
			}

		}

	}

	public function removewish()
	{
		$id = $this->input->post('id');

		if(trim(empty($id)) || trim($id) == "" || $id == NULL || !is_numeric($id))
		{
			json_message_print("error",$this->lang->line('notif_cart_invalid'));
		}
		else
		{

			$response = $this->Cart_model->removeFromWish($id);

			if(!$response)
			{
				json_message_print("error",$this->lang->line('notif_cart_notfound'));
			}
			else
			{
				json_message_print("warning",$this->lang->line('notif_wish_removed'));
				exit(0);
			}


		}

	}

	public function removecart()
	{
		$id = $this->input->post('id');

		if(trim(empty($id)) || trim($id) == "" || $id == NULL || !is_numeric($id))
		{
			json_message_print("error",$this->lang->line('notif_cart_invalid'));
		}
		else
		{
			if($this->Cart_model->existInCart($id))
			{
				$response = $this->Cart_model->removeFromCart($id);

				if(!$response)
				{
					json_message_print("error",$this->lang->line('notif_cart_notfound'));
				}
				else
				{
					array_add_message($response,"warning",$this->lang->line('notif_cart_removed'),1);
					exit(0);
				}

			}
			else
			{
				json_message_print("error",$this->lang->line('notif_cart_notexist'));
				exit(0);
			}

		}

	}

	public function editqty()
	{
		$id = $this->input->post('id');
		$qty = $this->input->post('qty');

		if(trim(empty($id)) || trim($id) == "" || $id == NULL || !is_numeric($id) || trim(empty($qty)) || trim($qty) == "" || $qty == NULL || !is_numeric($qty))
		{
			json_message_print("error",$this->lang->line('notif_cart_invalid'));
		}
		else
		{
			if($qty <= 0)
			{
				$qty = 1;
			}

			$response = $this->Cart_model->editItemQty($id,$qty);

			if(!$response)
			{
				json_message_print("error",$this->lang->line('notif_cart_notfound'));
			}
			else
			{
				array_add_message($response,"success",$this->lang->line('notif_cart_qtychange'),1);
				exit(0);
			}
		}




	}

	public function cleanCart()
	{
		$this->Cart_model->cleanCart();
		redirect('home/','refresh');
	}

}
