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
		$data=$this->getDatosTienda(1);
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
			$arrTienda['tipo_comida'] = $this->getTiposComidaTienda($tienda);
			$arrTienda['tipo_venta']=$this->getTiposVentaTienda($tienda);
			$arrTienda['horario']=$this->getHorarioTienda($tienda);
			$arrTienda['imagen_horario']=$this->getImagenHorario($tienda);
			return $arrTienda;
		}else{
			return false;
		}
	}
	
	function getTiposVentaTienda($tienda){
		$tipoVenta= $tienda->getTiposVenta();
		if($tipoVenta!=false){
			$i=1;
			foreach ($tipoVenta as $ven){
				if($i==1){
					$respuesta=$ven->nombre;
					$i++;
				}else{
					$respuesta .=','.$ven->nombre;
				}

			}
			return $respuesta;
		}else{
			return null;
		}

	}

	function getTiposComidaTienda($tienda) {
		$tipoComida=$tienda->getTiposComida();
		if($tipoComida!=false){
			$i=1;
			foreach ($tipoComida as $tip){
				if($i==1){
					$respuesta=$tip->nombre;
					$i++;
				}else{
					$respuesta.=', '.$tip->nombre;
				}
			}
			return $respuesta;
		}else {
			return null;
		}
	}
	
	function getImagenHorario($tienda){
		$hoy = mdate('%w',now());
		$hora= strtotime(mdate('%H:%i:%s',now()));
		$horario=$tienda->getHorarioDia($hoy);

		if($horario!=false){
			if($horario->tipohorario==0){
				if( ( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) )  ){
					$respuesta=base_url().'imagenes/abierto.png';
				}else{
					$respuesta=base_url().'imagenes/cerrado.png';
				}
			}elseif($horario->tipohorario==1){
				if( (( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) ))
				|| (( $hora >= strtotime($horario->horainicio2) )&&($hora <=strtotime($horario->horacierre2) ))){
					$respuesta=base_url().'imagenes/abierto.png';
				}else{
					$respuesta=base_url().'imagenes/cerrado.png';
				}
			}else{
				$respuesta=base_url().'imagenes/cerrado.png';
			}
		}else{
			$respuesta='';
		}
		return $respuesta;
	}
	
	function getHorarioTienda($tienda){
		$horario=$tienda->getHorarioCompleto();
		
		if($horario->exists()){
			foreach ($horario as $h) {

				switch ($h->dia) {
					case 0:
						if($h->tipohorario==0){
							$respuesta['DOMINGO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1){
							$respuesta['DOMINGO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else{
							$respuesta['DOMINGO']='CERRADO';
						}
						break;
					case 1:
						if($h->tipohorario==0){
							$respuesta['LUNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['LUNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['LUNES']='CERRADO';
						}
						break;
					case 2:
						if($h->tipohorario==0){
							$respuesta['MARTES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['MARTES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['MARTES']='CERRADO';
						}
						break;
					case 3:
						if($h->tipohorario==0){
							$respuesta['MIERCOLES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1){
							$respuesta['MIERCOLES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['MIERCOLES']='CERRADO';
						}
						break;
					case 4:
						if($h->tipohorario==0){
							$respuesta['JUEVES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['JUEVES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['JUEVES']='CERRADO';
						}
						break;
					case 5:
						if($h->tipohorario==0){
							$respuesta['VIERNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['VIERNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['VIERNES']='CERRADO';
						}
						break;
					case 6:
						if($h->tipohorario==0){
							$respuesta['SABADO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif ($h->tipohorario==1) {
							$respuesta['SABADO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['SABADO']='CERRADO';
						}
						break;
							
				}
					
			}
		}
		return $respuesta;
	}

}

?>