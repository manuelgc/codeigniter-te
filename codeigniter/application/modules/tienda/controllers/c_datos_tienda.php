<?php
	class C_datos_tienda extends MX_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->helper('date');
		}
		
		function index(){
			$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
			$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
			$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
			$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
			$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');				
			//$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);				
			//$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
			$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
			$this->template->set_layout('two_columns/theme');
			$data['tienda']=$this->getDatosTienda(1);
			$this->template->build('v_datos_tienda',$data);	
		}
		
		function getDatosTienda($id) {
			$tienda = new Tiendascomida();
			
			$tienda->where('estatus',1);
			$tienda->get_by_id($id);
			$arrTienda= array();
			if($tienda->exists()){
				$arrTienda['id'] = $tienda->id;
				$arrTienda['nombre'] = $tienda->nombre;
				$arrTienda['telefono'] = $tienda->telefono1.(($tienda->telefono2!=null)?'/'.$tienda->telefono2:'');
				$arrTienda['min_cant'] = ($tienda->minimoordencant!=null)?$tienda->minimoordencant:'Sin limite';
				$arrTienda['min_cost'] = ($tienda->minimoordenprecio!=null)?$tienda->minimoordenprecio:'Sin limite';
				$arrTienda['descripcion'] = $tienda->descripcion;
				$arrTienda['direccion'] = $tienda->direccion;
				$arrTienda['imagen'] = base_url().$tienda->imagen->where('estatus',1)->get()->rutaImagen;
				
				$tipoComida =$tienda->tipotiendascomida->where('estatus',1)->get();
				
				if($tipoComida->exists()){
					$i=1;
					$arrTienda['tipo_comida']=null;
					foreach ($tipoComida as $tipoC) {
						if($i==1){
							$arrTienda['tipo_comida'] .= $tipoC->nombre;
							$i++; 
						}else{
							$arrTienda['tipo_comida'] .= ','.$tipoC->nombre;
						}
						
					}
						
				}
				$tipoVenta =$tienda->tiposventa->where('estatus',1)->get();
				if($tipoVenta->exists()){
					$j=1;
					$arrTienda['tipo_venta']=null;
					foreach ($tipoVenta as $tipoV) {
						if($j==1){
							$arrTienda['tipo_venta'] .= $tipoV->nombre;
							$j++; 
						}else{
							$arrTienda['tipo_venta'] .= ','.$tipoV->nombre;
						}
						
					}
						
				}
				$arrTienda['horario']=$this->getHorarioTienda($tienda);			
				return $arrTienda;
			}else{
				return false;
			}
		}
		
		function getHorarioTienda($tienda){
			$horario=$tienda->horariosdespacho->where('estatus',1)->get();
			if($horario->exists()){

				foreach ($horario as $h) {

					if($h->tipohorario==0){
						switch ($h->dia) {
							case 0:
								$respuesta[$h->dia]='DOMINGO '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
								break;
							case 1:
								$respuesta[$h->dia]='LUNES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
								break;
							case 2:
								$respuesta[$h->dia]='MARTES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
								break;
							case 3:
								$respuesta[$h->dia]='MIERCOLES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
								break;
							case 4:
								$respuesta[$h->dia]='JUEVES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
								break;
							case 5:
								$respuesta[$h->dia]='VIERNES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
								break;
							case 6:
								$respuesta[$h->dia]='SABADO '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
								break;
									
						}
					}elseif($h->tipohorario==1){
						switch ($h->dia) {
							case 0:
								$respuesta[$h->dia]='DOMINGO '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
								.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
								break;
							case 1:
								$respuesta[$h->dia]='LUNES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
								.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
								break;
							case 2:
								$respuesta[$h->dia]='MARTES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
								.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
								break;
							case 3:
								$respuesta[$h->dia]='MIERCOLES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
								.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
								break;
							case 4:
								$respuesta[$h->dia]='JUEVES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
								.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
								break;
							case 5:
								$respuesta[$h->dia]='VIERNES '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
								.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
								break;
							case 6:
								$respuesta[$h->dia]='SABADO '.mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
								.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
								break;
						}
							
					}
				}
			}
			return $respuesta;
		}

	}
	   
?>