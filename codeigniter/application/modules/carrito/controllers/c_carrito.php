<?php
	class c_carrito extends MX_Controller {
		private $limite =10;
		function __construct(){
			parent::__construct(); 
			$this->load->library('cart'); 
			$this->load->helper('language');
			$this->load->helper('form');
		}
		
		function index($id_tienda = '') {
			if($this->input->is_ajax_request()){
				
				$data['html']= $this->actualizarCarrito($this->input->post('id_tienda'));
				echo json_encode($data);
				
			}elseif($id_tienda!='') {
				
				return $this->actualizarCarrito($id_tienda);
				
			}
		}

		function actualizarCarrito($id_tienda){
			$tienda = new Tiendascomida();
			$tienda->where('estatus',1)->get_by_id($id_tienda);
			if($tienda->exists()){
				$data['cant_minima'] = ($tienda->minimoordencant!=null)?$tienda->minimoordencant:0;
				$data['costo_minimo'] = ($tienda->minimoordenprecio!=null)?$tienda->minimoordenprecio:0;

				if ($this->input->cookie('tipo_orden')!=false && $this->input->cookie('tipo_orden')==1){
					$data['costo_envio'] = $tienda->costoenvio;
				}else{
					$data['costo_envio'] = 0;
				}
					
				$data['radio_tipo']= $this->cargarRadioOrden($tienda);
					
				return $this->load->view('carrito/v_carrito',$data,true);;
			}
		}

		function agregarPlato(){
			$plato= new Plato();
			$plato->where('estatus',1)->get_by_id($this->input->post('id_plato'));
			if ($plato->exists()) {
				$encontrado=false;
				$tienda = $plato->tiendascomida->where('estatus',1)->get();											
				foreach ($this->cart->contents() as $items){
					if($items['id']==$plato->id){
						$encontrado=true;
						$rowid=$items['rowid'];
						break;
						
					}
				}
				
				if($encontrado){
					$valor= $items['qty'] + $this->input->post('cantidad');
						$data1 = array(
				               'rowid'   => $rowid,
				               'qty'     => (($valor>$this->limite)?$this->limite:$valor)
						);
					
					$this->cart->update($data1);
					
				}else{
					$total_extra=0;
					if($this->input->post('seleccion')){
						$opciones = array();
						$extras = array();
						foreach ($this->input->post('seleccion') as $seleccion) {

							foreach ($seleccion as $detalle){
								$cadena_id= explode("-", $detalle["name"]);
								if($cadena_id[1]=="opcion"){
									$opciones[]= array(
									'opcion_id'=> $cadena_id[0],
									'det_opc_id' => $detalle['value']);
									
								}else{
									$extra_detalle = new Extrasdetalle();
									$extra_detalle->where('estatus',1)->where('extras_id',$cadena_id[0])->get_by_id($detalle['value']);
									if($extra_detalle->exists()){
										$extras[]= array(
										'extra_id' => $cadena_id[0],
										'det_ext_id' => $detalle['value'],
										'extra_precio' => $extra_detalle->precio);
										$total_extra += $extra_detalle->precio;
										
									}
								}
																
							
							}
							
						}
					}
					
					$iva = $plato->getImpuesto();
						
					if($iva!=false){
						$total_iva = ($plato->precio + $total_extra)  * $iva->porcentaje / 100;
					}else{
						$total_iva = 0;
					}
					
					
					$data1 = array(
			               'id'      => $this->input->post('id_plato'),
			               'qty'     => $this->input->post('cantidad'),
			               'price'   => $plato->precio + $total_extra,
			               'name'    => $plato->nombre,
					  'observacion'  =>	$this->input->post('observacion'),
						 'opciones'	 => $opciones,
						  'extras'	 =>	$extras,
					'precio_base'	 => $plato->precio,
					'precio_extra'	 => $total_extra,
					'precio_iva'	 =>	$total_iva,
					);
					
					$this->cart->insert($data1);
					
				}
				$dataAjax['carrito'] = true;
				$dataAjax['html'] = $this->actualizarCarrito($tienda->id);
			}else{
				$dataAjax['carrito'] = false;
			}
			
			echo json_encode($dataAjax);
		}

		function actualizarPlato() {
			$data1 = array(
			        'rowid'   => $this->input->post('rowid'),
			        'qty'     =>    $this->input->post('cantidad'),
			);
			$this->cart->update($data1);
			$data['html']=$this->actualizarCarrito($this->input->post('id_tienda'));
			echo json_encode($data);
		}


		function editarPlato() {
			$data1 = array(
			        'rowid'   => $this->input->post('rowid'),
			        'qty'     =>    $this->input->post('cantidad'),
			 'observacion'  =>	$this->input->post('observacion')
			);
			$this->cart->update($data1);
			$data['html']=$this->actualizarCarrito($this->input->post('id_tienda'));
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
		
		function cargarRadioOrden($tienda) {
			$tipo_venta = $tienda->getTiposVenta();
			$respuesta ='';
			if($tipo_venta!=false){
				foreach ($tipo_venta as $tipo){
					
					if($this->input->cookie('tipo_orden')==$tipo->id){
						$check=true;
					}else{
						$check=false;
					}
					$respuesta .='<div>';				
					$respuesta .= form_radio('radio_tipo_orden', $tipo->id, $check,'id="'.$tipo->id.'-tipo_orden"');
					$respuesta .= form_label($tipo->nombre);
					$respuesta .= '</div>';
				}
				return $respuesta;
			}
			
		}
	}
	?>