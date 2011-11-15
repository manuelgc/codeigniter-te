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
					
				return $this->load->view('carrito/v_carrito',$data,true);
			}
		}

		function agregarPlato(){
			$plato= new Plato();
			$plato->where('estatus',1)->get_by_id($this->input->post('id_plato'));
			$carrito = $this->cart->contents();
			if ($plato->exists()) {
				
				$encontrado=false;
				$total_extra=0;
				$opciones = array();
				$extras = array();
				$ops_text = array();
				
				
				if($this->input->post('seleccion')){

					foreach ($this->input->post('seleccion') as $seleccion) {

						foreach ($seleccion as $detalle){
							$cadena_id= explode("-", $detalle["name"]);
							if($cadena_id[1]=="opcion"){
								$opciones[]= array(
									'opcion_id'=> $cadena_id[0],
									'det_opc_id' => $detalle['value']);
								
									if(array_key_exists($cadena_id[0], $ops_text)){
										$ops_text[$cadena_id[0]].= ','.$detalle['value'];
									}else{
										$ops_text[$cadena_id[0]]= $detalle['value'];
									}

							}else{
								$extra_detalle = new Extrasdetalle();
								$extra_detalle->where('estatus',1)->where('extras_id',$cadena_id[0])->get_by_id($detalle['value']);
								if($extra_detalle->exists()){
									$extras[]= array(
										'extra_id' => $cadena_id[0],
										'det_ext_id' => $detalle['value'],
										'extra_precio' => $extra_detalle->precio);
									$total_extra += $extra_detalle->precio;
									
									if(array_key_exists($cadena_id[0], $ops_text)){
										$ops_text[$cadena_id[0]].= ','.$detalle['value'];
									}else{
										$ops_text[$cadena_id[0]]= $detalle['value'];
									}
								
								}
							}

								
						}

					}
				}

				
				foreach ($carrito as $items){
				
					if($items['id']==$plato->id && $items['opciones']===$opciones && $items['extras']===$extras){
						$encontrado=true;
						$rowid=$items['rowid'];
						$cantCart= $items['qty'];
						break;

					}
				}

				if($encontrado){
					
					$valor= $cantCart + $this->input->post('cantidad');
					$dataCart = array(
				               'rowid'   => $rowid,
				               'qty'     => (($valor>$this->limite)?$this->limite:$valor),
						  'observacion'  =>	$this->input->post('observacion')	
					);
						
					$this->cart->update($dataCart);
						
				}else{

					$iva = $plato->getImpuesto();
						
					if($iva!=false){
						$total_iva = ($plato->precio + $total_extra)  * $iva->porcentaje / 100;
					}else{
						$total_iva = 0;
					}
					
					
					$dataCart = array(
			               'id'      => $this->input->post('id_plato'),
			               'qty'     => $this->input->post('cantidad'),
			               'price'   => $plato->precio + $total_extra,
			               'name'    => $plato->nombre,
						'options'    => $ops_text,
					  'observacion'  =>	$this->input->post('observacion'),
						 'opciones'	 => $opciones,
						  'extras'	 =>	$extras,
					'precio_base'	 => $plato->precio,
					'precio_extra'	 => $total_extra,
					'precio_iva'	 =>	$total_iva,
					);
					
					$this->cart->insert($dataCart);
					
				}
				$dataAjax['carrito'] = true;
				$dataAjax['html'] = $this->actualizarCarrito($this->input->post('id_tienda'));
			}else{
				$dataAjax['carrito'] = false;
			}
			
			echo json_encode($dataAjax);
		}


		function editarPlato() {

			$data['carrito']=false;
			$total_extra=0;
			$opciones = array();
			$extras = array();
			$ops_text = array();


			if($this->input->post('seleccion')){

				foreach ($this->input->post('seleccion') as $seleccion) {

					foreach ($seleccion as $detalle){
						$cadena_id= explode("-", $detalle["name"]);
						if($cadena_id[1]=="opcion"){
							$opciones[]= array(
									'opcion_id'=> $cadena_id[0],
									'det_opc_id' => $detalle['value']);

							if(array_key_exists($cadena_id[0], $ops_text)){
								$ops_text[$cadena_id[0]].= ','.$detalle['value'];
							}else{
								$ops_text[$cadena_id[0]]= $detalle['value'];
							}

						}else{
							$extra_detalle = new Extrasdetalle();
							$extra_detalle->where('estatus',1)->where('extras_id',$cadena_id[0])->get_by_id($detalle['value']);
							if($extra_detalle->exists()){
								$extras[]= array(
										'extra_id' => $cadena_id[0],
										'det_ext_id' => $detalle['value'],
										'extra_precio' => $extra_detalle->precio);
								$total_extra += $extra_detalle->precio;
									
								if(array_key_exists($cadena_id[0], $ops_text)){
									$ops_text[$cadena_id[0]].= ','.$detalle['value'];
								}else{
									$ops_text[$cadena_id[0]]= $detalle['value'];
								}

							}
						}


					}

				}
			}
				
			$carrito = $this->cart->contents();
				
			if( $carrito[$this->input->post('rowid')]['opciones']===$opciones && $carrito[$this->input->post('rowid')]['extras']===$extras){
				$dataCart = array(
			 	       'rowid' => $this->input->post('rowid'),
			 	       'qty'   => $this->input->post('cantidad'),
			 	'observacion'  => $this->input->post('observacion')
				);
					
				$this->cart->update($dataCart);
				$data['carrito']=true;
			}else{

				$plato= new Plato();
				$plato->where('estatus',1)->get_by_id($this->input->post('id_plato'));
				
				if ($plato->exists()) {

					$encontrado=false;
					
					foreach ($carrito as $items){

						if($items['id']==$plato->id && $items['opciones']===$opciones && $items['extras']===$extras){
							$encontrado=true;
							$rowid=$items['rowid'];
							$cantCart= $items['qty'];
							break;

						}

					}
						
					if($encontrado){
							
						$valor= $cantCart + $this->input->post('cantidad');
						$dataCart = array(
				               'rowid'   => $rowid,
				               'qty'     => (($valor>$this->limite)?$this->limite:$valor),
						  'observacion'  =>	$this->input->post('observacion')	
						);

						$this->cart->update($dataCart);
						$data['carrito']=true;
					}else{

						$iva = $plato->getImpuesto();

						if($iva!=false){
							$total_iva = ($plato->precio + $total_extra)  * $iva->porcentaje / 100;
						}else{
							$total_iva = 0;
						}
							
							
						$dataCart = array(
				               'id'      => $this->input->post('id_plato'),
				               'qty'     => $this->input->post('cantidad'),
				               'price'   => $plato->precio + $total_extra,
				               'name'    => $plato->nombre,
							'options'    => $ops_text,
						  'observacion'  =>	$this->input->post('observacion'),
							 'opciones'	 => $opciones,
							  'extras'	 =>	$extras,
						'precio_base'	 => $plato->precio,
						'precio_extra'	 => $total_extra,
						'precio_iva'	 =>	$total_iva,
						);
							
						$this->cart->insert($dataCart);
						$data['carrito']=true;
					}
				}
			}
			$data['html']=$this->actualizarCarrito($this->input->post('id_tienda'));
			echo json_encode($data);
		}


		function actualizarPlato() {
			$dataCart = array(
			        'rowid'   => $this->input->post('rowid'),
			        'qty'     =>    $this->input->post('cantidad'),
			);
			$this->cart->update($dataCart);
				
			$data['html']=$this->actualizarCarrito($this->input->post('id_tienda'));
			echo json_encode($data);
		}

		function eliminarCarrito(){
			$this->cart->destroy();
			$data['html']= $this->load->view('carrito/v_carrito','',true);
			echo json_encode($data);
		}
		
		function cargarPopupEditarAjax(){
		
		$plato = new Plato();
		$plato->where('estatus',1)->get_by_id($this->input->post('id_plato'));
		if($plato->exists()){
			$dataAjax['plato']=true;
			$data['id_plato']=$plato->id;
			$data['tipo']= 'editar';
			$data['rowid']=$this->input->post('rowid');
			if($this->cart->contents()!=false){
				
					if($this->input->post('rowid')!=false){
						$temp= $this->cart->contents();
						$cartPlato = $temp[$this->input->post('rowid')];
						unset($temp);
					}
			}
			
			$img=$plato->getImagen();
			if($img!=false){
				$data['imagen']=base_url().$img->rutaImagen;
			}else {
				$data['imagen']="";
			}
			
			$data['precio']=$plato->precio;
			$data['descripcion']=$plato->descripcion;
				
			$opciones= $plato->getOpciones();
			$arrOpciones= array();
			if($opciones!=false){
				foreach ($opciones as $opcion) {
					$items=$opcion->getOpcionesDetalle();
					if($items!=false){
						$arrOpciones[$opcion->id]['nombre']=$opcion->nombre;
						$arrOpciones[$opcion->id]['requerido']=($opcion->requerido==1)?'(Requerido)':'';
						$arrOpciones[$opcion->id]['minimo']=$opcion->minimo;
						$arrOpciones[$opcion->id]['maximo']=$opcion->maximo;
						if($opcion->maximo==1){
							$arrItem= array();
							foreach ($items as $item) {
								
								$checked=false;

								if(isset($cartPlato)){
									if(in_array(array( 'opcion_id'=> $opcion->id,'det_opc_id' => $item->id), $cartPlato['opciones'])){
										$checked=true;
									}

								}
								
								$attrRadio = array(
							    'name'        => $opcion->id.'-opcion',
							    'id'          => $item->id,
							    'value'       => $item->id,
								'checked'     => $checked,
								);
								$arrItem[$item->id]['id']=$item->id;
								$arrItem[$item->id]['input']= form_radio($attrRadio);
								$arrItem[$item->id]['label']=form_label($item->nombre, $item->id);

							}
							$arrOpciones[$opcion->id]['opcion_item']=$arrItem;
						}else{
							$arrItem= array();
							
							foreach ($items as $item) {
								$checked=false;

								if(isset($cartPlato)&& in_array(array( 'opcion_id'=> $opcion->id,'det_opc_id' => $item->id), $cartPlato['opciones'])){
									$checked=true;
								}

								$attrCheck = array(
							    'name'        => $opcion->id.'-opcion',
							    'id'          => $item->id,
							    'value'       => $item->id,
								'checked'     => $checked,
								);
								$arrItem[$item->id]['id']=$item->id;
								$arrItem[$item->id]['input']= form_checkbox($attrCheck);
								$arrItem[$item->id]['label']= form_label($item->nombre, $item->id);

							}
							$arrOpciones[$opcion->id]['opccion_item']=$arrItem;
						}
					}
				}
				$data['opciones']=$arrOpciones;
			}

			$extras= $plato->getExtras();
			$arrExtras= array();
			if($extras!=false){
				foreach ($extras as $extra) {
					$itemsExt=$extra->getExtrasDetalle();
					if($itemsExt!=false){
						$arrExtras[$extra->id]['nombre']=$extra->nombre;
						$arrExtras[$extra->id]['requerido']=($extra->requerido==1)?'(Requerido)':'';
						$arrExtras[$extra->id]['minimo']=$extra->minimo;
						$arrExtras[$extra->id]['maximo']=$extra->maximo;
						if($extra->maximo==1){
							$arrItem= array();
							foreach ($itemsExt as $itemExt) {
								
								$checked=false;

								if(isset($cartPlato) && in_array(array( 'extra_id'=> $extra->id,'det_ext_id' => $itemExt->id,'extra_precio' => $itemExt->precio), $cartPlato['extras'])){
									$checked=true;
								}
									
								$attrRadio = array(
							    'name'        => $extra->id.'-extra',
							    'id'          => $itemExt->id,
							    'value'       => $itemExt->id,
								'checked'	  => $checked,
								);
								$arrItem[$itemExt->id]['id']=$itemExt->id;
								$arrItem[$itemExt->id]['input']= form_radio($attrRadio);
								$arrItem[$itemExt->id]['label']=form_label('<p class="nombre_extra">'.$itemExt->nombre.' </p>
                    			<p class="precio">Bs.'.$itemExt->precio.' </p>', $itemExt->id);
								$arrExtras[$extra->id]['extra_item']=$arrItem;
							}
							$arrExtras[$extra->id]['extra_item']=$arrItem;
						}else{
							$arrItem= array();
							foreach ($itemsExt as $itemExt) {

								$checked=false;

								if(isset($cartPlato)&& in_array(array( 'extra_id'=> $extra->id,'det_ext_id' => $itemExt->id,'extra_precio' => $itemExt->precio), $cartPlato['extras'])){
									$checked=true;
								}

								$attrCheck = array(
							    'name'        => $extra->id.'-extra',
							    'id'          => $itemExt->id,
							    'value'       => $itemExt->id,
								'checked'	  => $checked,
								);
								$arrItem[$itemExt->id]['id']=$itemExt->id;
								$arrItem[$itemExt->id]['input']= form_checkbox($attrCheck);
								$arrItem[$itemExt->id]['label']=form_label('<p class="nombre_extra">'.$itemExt->nombre.' </p>
                    			<p class="precio">Bs.'.$itemExt->precio.' </p>', $itemExt->id);															
							}
							$arrExtras[$extra->id]['extra_item']=$arrItem;
						}
					}
				}
				$data['extras']=$arrExtras;
			}
			
			if(isset($cartPlato)){
				$data['observacion']=$cartPlato['observacion'];
				$data['cantidad']=$cartPlato['qty'];
			}
			
			$dataAjax['html']=$this->load->view('tienda/v_popup_plato',$data,true);
			$dataAjax['nombrePlato']=$plato->nombre;
			$dataAjax['precio']=$plato->precio;
			
				
		}else{
			$dataAjax['plato']=false;
		}
		echo json_encode($dataAjax);
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