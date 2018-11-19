<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller {

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
		redirect('/home' ,'refresh');
	}

	public function id($id = NULL)
	{
		if($this->Auth_model->isLoggedIn())
		{
			if($id == NULL)
			{
				redirect('/home' ,'refresh');
			}
			else
			{
				$this->scope['invoice'] = $this->Invoice_model->getInvoice($id);
				if(!$this->scope['invoice'])
				{
					redirect('/home' ,'refresh');
				}
				if($this->scope['invoice']->id_user == $this->session->userdata('id_user') || $this->session->userdata('id_user') == 1)
				{
					$this->load->view('Invoice',$this->scope);
				}
				else
				{
					redirect('/home' ,'refresh');
				}
				
			}
		}
		else
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
	}

	public function report($id = NULL)
	{
		if($this->Auth_model->isLoggedIn())
		{
			if($id == NULL)
			{
				redirect('/home' ,'refresh');
			}
			else
			{

				$invoice = $this->Invoice_model->getInvoice($id);

				if(!$invoice)
				{
					redirect('/home' ,'refresh');
				}
				if($invoice->id_user != $this->session->userdata('id_user') && $this->session->userdata('id_user') != 1)
				{
					redirect('/home' ,'refresh');
				}

				// Se carga la libreria fpdf
			    $this->load->library('pdf');
			 
			   
			    // Creacion del PDF
			 
			    /*
			     * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
			     * heredó todos las variables y métodos de fpdf
			     */
			    $this->pdf = new Pdf('L','mm','Letter');

			    $this->pdf->setReportTitle($this->lang->line('pdf_title'));

			    $this->pdf->AliasNbPages();
				$this->pdf->AddPage();
				$this->pdf->AddFont('Futura-Medium');
				$this->pdf->SetFont('Futura-Medium','',11);
				$this->pdf->SetTextColor(50,50,50);

				$i = 0;
				$total = 0;

				foreach ($invoice as $key => $product) 
				{
              		if(is_numeric($key))
                  	{
                  		$this->pdf->Cell(15,10,$i,1,0,'C');
						$this->pdf->Cell(100,10,utf8_decode($product->product_name),1,0,'L');
						$this->pdf->Cell(30,10,$product->product_qty,1,0,'L');
						$this->pdf->Cell(40,10,$product->product_price*$product->product_qty.' '.$product->product_coin,1,1,'L');
						//$this->pdf->Cell(20,10,"Comprado",0,1,'L'); 
						$i++;
						$total = $total + ($product->product_price*$product->product_qty);

                        $coin = $product->product_coin;
                  	}
                  	else
                  	{
                    	continue;
                  	}
                }

                $this->pdf->Cell(15,10,"",0,0,'C');
				$this->pdf->Cell(100,10,"",0,0,'L');
				$this->pdf->Cell(30,10,"Total :",1,0,'L');
				$this->pdf->Cell(40,10,$total.' '.$coin,1,1,'L');

				$this->pdf->Ln(10);

				$this->pdf->Cell(25,10,"Invoice Page :",0,0,'C');
				$this->pdf->Cell(100,10,site_url('invoice/id/'.$id),0,0,'L');




				$this->pdf->Output(str_replace(' ', '_', "report-".$id).".pdf","I");

			}
		}
	}


	public function paybtc($id = NULL)
	{
		$this->load->library('Blockchain');

		if($this->Auth_model->isLoggedIn())
		{
			if($id != NULL)
			{
				$invoice = $this->Invoice_model->getInvoice($id);
				if(!$invoice)
				{
					redirect('/home' ,'refresh');
				}
				if($invoice->id_user != $this->session->userdata('id_user') && $this->session->userdata('id_user') != 1)
				{
					redirect('/home' ,'refresh');
				}
				
				$payment_info_address = $this->blockchain->blockChainAddress($invoice->id_invoice);

				if(!$payment_info_address)
				{
					$this->session->set_flashdata('notification', array(
        				'type' => 'danger',
	        			'title' => $this->lang->line('notif_error'),
	        			'content' => "Error on Payment System"
        			));
					redirect('/invoice/id/'.$id ,'refresh');
				}

				$this->scope['invoice'] = $invoice;
				$this->scope['blockchain_address'] = $payment_info_address->address;
				$this->scope['total_in_btc'] = $invoice->total_in_btc;
				$this->scope['total_in_usd'] = $invoice->total_in_usd;
				$this->load->view('PayBtc',$this->scope);
			}
		}
		else
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
	}

	public function paykeys()
	{
		$invoice_hash = $this->input->post('invoice_hash');
		$steamuser = $this->input->post('steamuser');

		if($this->Auth_model->isLoggedIn())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				if($invoice_hash != NULL)
				{
					$data = array(
		               'invoice_hash' => $invoice_hash,
		               'steam_name' => $steamuser,
		               'id_user' => $this->session->userdata('id_user'),
		               'date' => date('Y-m-d')
		            );

		            $query = $this->db->insert('invoice_csgo_payments',$data); 

		            if($query)
		            {
		            	$invoice = $this->Invoice_model->getInvoice($invoice_hash);

		            	$invoice_status = $this->db->update('invoice', array('status' => $this->config->item('status')['steam']), array('id_invoice' => $invoice->id_invoice));

		            	$this->session->set_flashdata('notification', array(
        				'type' => 'success',
	        			'title' => $this->lang->line('notif_success'),
	        			'content' => $this->lang->line('notif_success_send')
	        			));

	        			redirect('/invoice/id/'.$invoice_hash ,'refresh');
		            }
		            else
		            {
		                $this->session->set_flashdata('notification', array(
        				'type' => 'success',
	        			'title' => $this->lang->line('notif_error'),
	        			'content' => $this->lang->line('notif_error_send')
	        			));

	        			redirect('/invoice/id/'.$invoice_hash ,'refresh');
		            } 
		        }
		    }
		}
	}

	public function verifypaymentblockchain()
	{
		$id = $this->input->post('id');
		if($this->Auth_model->isLoggedIn())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				if($id != NULL)
				{
					$invoice = $this->Invoice_model->verifyPaymentBlockchain($id);
					if($invoice)
					{
						json_message_print("success","Good");
					}
					else
					{
						json_message_print("error","Bad");
					}
					
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
	}

	public function claim()
	{
		$id = $this->input->post('id');
		if($this->Auth_model->isLoggedIn())
		{
			if($this->input->server('REQUEST_METHOD') == 'POST')
			{
				if($id != NULL)
				{
					$invoice = $this->Invoice_model->verifyPaymentBlockchain($id);
					if($invoice)
					{
						$this->scope['products_claimed'] = $this->Invoice_model->claimProduct($id);
						if(!$this->scope['products_claimed'])
						{
							redirect('/home' ,'refresh');
						}
						$this->load->view('Claim',$this->scope);
					}
					else
					{
						$this->session->set_flashdata('notification', array(
        				'type' => 'danger',
	        			'title' => $this->lang->line('notif_error'),
	        			'content' => $this->lang->line('notif_error').' <strong>'. $this->input->post('email').'</strong>'
	        			));

	        			redirect('/invoice/id/'.$id ,'refresh');
					}
					
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
	}

	public function showproducts($id = NULL)
	{
		if($this->Auth_model->isLoggedIn())
		{
			if($id != NULL)
			{
				$invoice = $this->Invoice_model->getInvoice($id);

				if(!$invoice)
				{
					redirect('/home' ,'refresh');
				}

				if($invoice->id_user != $this->session->userdata('id_user') && $this->session->userdata('id_user') != 1)
				{
					redirect('/home' ,'refresh');
				}

				$invoice_payment = $this->Invoice_model->verifyPaymentBlockchain($id);

				if($invoice_payment)
				{
					$this->scope['products_claimed'] = $this->Invoice_model->showProducts($id);
					if(!$this->scope['products_claimed'])
					{
						redirect('/home' ,'refresh');
					}
					$this->load->view('Claim',$this->scope);
				}
				else
				{
					$this->session->set_flashdata('notification', array(
    				'type' => 'danger',
        			'title' => $this->lang->line('notif_error'),
        			'content' => $this->lang->line('notif_error').' <strong>'. $this->input->post('email').'</strong>'
        			));

        			redirect('/invoice/id/'.$id ,'refresh');
				}
				
			}
		}
		else
		{
			$this->session->set_flashdata('error', array(
    			'form' => 'login',
    			'error' => '<h2 class="label-danger">'.$this->lang->line('auth_error_mustlogin').'</h2>'));

			redirect('/auth' ,'refresh');
		}
	}

	public function blockchain_callback()
	{
		$this->load->library('Blockchain');

		$invoice_id = $this->input->get('invoice_id');
		$transaction_hash = $this->input->get('transaction_hash');
		$address = $this->input->get('address');
		$secret = $this->input->get('secret');
		$confirmations = $this->input->get('confirmations');
		$value = $this->input->get('value');

		$this->blockchain->callback($invoice_id,$value,$transaction_hash,$address,$secret,$confirmations);

	}

	public function blockchain_unused_address()
	{
		$back = $this->input->get('gob');

        if(!isset($back) || empty($back))
        {
            $back = site_url('home');
        }

		$this->load->library('Blockchain');
		$this->blockchain->store_unused_address();

		redirect($back ,'refresh');
	}




}
