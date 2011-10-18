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
				$data['carrito']=$this->agregarPlato();
				if($data['carrito']){
					$data['html']=$this->load->view('carrito/v_carrito_actualizar','',true);
				}
				 echo json_encode($data); 
			}
		}
		
		function agregarPlato(){
				
			$plato= new Plato();
			$plato->where('estatus',1)->get_by_id($this->input->post('id_plato'));

			if ($plato->exists()) {
				$encontrado=false;
				foreach ($this->cart->contents() as $items){
					if($items['id']==$plato->id){
						$encontrado=true;
						$rowid=$items['rowid'];
						break;
						
					}
				}
				if($encontrado){
					$data = array(
			               'rowid'      => $rowid,
			               'qty'     => $items['qty']+$this->input->post('cantidad')
					);
					$this->cart->update($data);
					
				}else{
					$data = array(
			               'id'      => $this->input->post('id_plato'),
			               'qty'     => $this->input->post('cantidad'),
			               'price'   => $plato->precio,
			               'name'    => $plato->nombre,
					'instrucciones'  =>	$this->input->post('instrucciones'),
					);
					$this->cart->insert($data);
					
				}
				return true;
			}else{
				return false;
			}
		}
		
		function actualizarPlato() {
			$data = array(
			        'rowid'   => $this->input->post('rowid'),
			        'qty'     =>    $this->input->post('cantidad')
			);
			$this->cart->update($data);
			$data['html']=$this->load->view('carrito/v_carrito_actualizar','',true);
			echo json_encode($data);		
		}

	}
?>