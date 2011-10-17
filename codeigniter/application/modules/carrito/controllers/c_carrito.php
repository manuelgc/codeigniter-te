<?php
	class c_carrito extends MX_Controller {
		
		function __construct(){
			parent::__construct(); 
			$this->load->library('cart'); 
			$this->load->helper('language');
			$this->load->helper('form');
		}
		
		function index() {
			if($this->input->is_ajax_request()){
				$this->agregarPlato();
				$data['html']=$this->load->view('carrito/v_carrito_actualizar','',true);
				 echo json_encode($data); 
			}
		}
		
		function agregarPlato(){
			
			$data = array(
               'id'      => $this->input->post('id_plato'),
               'qty'     => $this->input->post('cantidad'),
               'price'   => 1000,
               'name'    => $this->input->post('nombre'),
			'instrucciones'  =>$this->input->post('instrucciones')
			//               'options' => array('Size' => 'L', 'Color' => 'Red')
			
            );
			$this->cart->insert($data);
//			print_r($data);
//			print_r($this->cart->contents());
			
		}
	}
?>