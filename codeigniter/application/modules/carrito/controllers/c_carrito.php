<?php
	class c_carrito extends MX_Controller {
		private $limite =10;
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
					$valor= $items['qty'] + $this->input->post('cantidad');
					
					if($this->input->post('observacion')==''){
						$data1 = array(
				               'rowid'   => $rowid,
				               'qty'     => (($valor>$this->limite)?$this->limite:$valor)
						);
					}else{
						$data1 = array(
				               'rowid'   => $rowid,
				               'qty'     => (($valor>$this->limite)?$this->limite:$valor),
						  'observacion'  =>	$this->input->post('observacion')
						);
						
					}
					$this->cart->update($data1);
					
				}else{
					$data1 = array(
			               'id'      => $this->input->post('id_plato'),
			               'qty'     => $this->input->post('cantidad'),
			               'price'   => $plato->precio,
			               'name'    => $plato->nombre,
					  'observacion'  =>	$this->input->post('observacion'),
					);
					$this->cart->insert($data1);
					
				}
				return true;
			}else{
				return false;
			}
		}

		function actualizarPlato() {
			$data1 = array(
			        'rowid'   => $this->input->post('rowid'),
			        'qty'     =>    $this->input->post('cantidad'),
			);
			$this->cart->update($data1);
			$data['html']=$this->load->view('carrito/v_carrito_actualizar','',true);
			echo json_encode($data);
		}


		function editarPlato() {
			$data1 = array(
			        'rowid'   => $this->input->post('rowid'),
			        'qty'     =>    $this->input->post('cantidad'),
			 'observacion'  =>	$this->input->post('observacion')
			);
			$this->cart->update($data1);
			$data['html']=$this->load->view('carrito/v_carrito_actualizar','',true);
			echo json_encode($data);
		}
			
		function cargarPopupEditarAjax(){
			$plato = new Plato();
			$plato->where('estatus',1)->get_by_id($this->input->post('id_plato'));

			if($plato->exists()){
				$data['plato']=true;
				$data['html']='<form>';
				$img=$plato->getImagen();
				if($img!=false){
					$data['html'].='<div align="center" class="imagene_plato">	<img height="auto" width="350px" src="'.base_url().$img->rutaImagen.'"></div>';
				}else {
					$data['html'].='<div class="imagene_plato">	<img src=""></div>';
				}
				$data['html'].='<div><p class="error" id="mensaje_plato"></p></div>';
				$data['html'].='<div><p>Precio: '.$plato->precio.' Bs.</p></div>';
				$data['html'].='<div><p>'.$plato->descripcion.'</p></div>';
				$data['html'].='<div>'.form_label('Cantidad', 'cantidad');
				$attr = array(
              'name'        => 'cantidad',
              'id'          => 'cantidad',
              'size'        => '3',

				);
				$data['html'].=form_input($attr,$this->input->post('cantidad')).'</div>';
				$data['html'].='<div>'.form_label('Observacion', 'observacion');
				$attr2 = array(
              'name'        => 'observacion',
              'id'          => 'observacion',
              'rows'   		=> '2',
              'cols'        => '40',

				);
				$data['html'].=form_textarea($attr2,$this->input->post('observacion')).'</div>';
				$data['html'].='</form>';
				$data['nombrePlato']=$plato->nombre;
				$data['precio']=$plato->precio;
			}else{
				$data['plato']=false;
			}
			echo json_encode($data);
		}
	}
	?>