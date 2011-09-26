<?php
class c_busqueda extends MX_Controller{
	
	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('language');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->library('qtip2');			
		$this->form_validation->CI =& $this;

	}
	function index() {
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/view.js'));
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip('li','select');
		$arrCombo = array('ciudad'  => $this->cargarCiudad(),
                  		'categoria'    => $this->cargarTipoComida(),
                  		'orden'   => $this->cargarTipoOrden());

		if ($this->input->post('campo_busqueda')) {
			
			if($this->buscarTiendaSql()!=null){
				$data['restaurantes']=$this->buscarTiendaSql();
				$this->template->build('v_resultado_busqueda',$data);
			}else{
				$data['mensaje_error']='Lo sentimos la busqueda no obtuvo ningun resultado.';
				$this->template->build('v_resultado_busqueda',$data);
			}
		}

		return $arrCombo;
	}

	function  buscarTiendaSql(){

		$sql="SELECT tienda.* FROM tiendascomida AS tienda";
		$where=" WHERE tienda.estatus=1 ";
		$tiendas = new Tiendascomida();
		$tipoComida = new Tipotiendascomida();
		$tipoVenta = new Tiposventa();
		$arrtienda = array();
		$respuesta = array();
		$sw=false;
		$bool_ciudad=false;
		$bool_zona=false;
		$bool_categoria=false;
		$bool_venta=false;
		
		//Busqueda por ciudad
		if($this->input->post('ciudad')!=''){
			$tiendas->clear();		
			$tiendas->where('ciudades_id',$this->input->post('ciudad'));
			$tiendas->where('estatus','1')->get();
			if($tiendas->exists()){
				$sql .=", direccionesentrega AS dir";
				$where .="AND tienda.id = dir.tiendascomida_id AND dir.ciudades_id =".$this->input->post('ciudad')." ";
				$where .="AND dir.estatus=1 ";
				$bool_ciudad=true;
			}else{
				$arrtienda['mesaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
			}
			

			//Busqueda por zona
			if($this->input->post('zona')!=''){
				$tiendas->clear();		
				$tiendas->where('zonas_id',$this->input->post('zona'));
				$tiendas->where('estatus','1')->get();
				if($tiendas->exists()){
					$where .="AND dir.zonas_id =".$this->input->post('zona')." ";
					$bool_zona=true;
				}else{
				$arrtienda['mensaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
				}	
			}
			$sw=true;
			
		}

		//Busqueda por Tipo de Comida
		if($this->input->post('categoria')!=''){
			$tiendas->clear();		
			$tipoComida->get_by_id($this->input->post('categoria'));
			$tipoComida->where('estatus','1');
			$tiendas=$tipoComida->tiendascomida;
			$tiendas->where('estatus','1')->get();
			if($tiendas->exists()){
				$sql .=", tiendascomida_tipotiendascomida AS tipoC";
				$where .="AND tienda.id = tipoC.tiendascomida_id	AND tipoC.tipotiendascomida_id =".$this->input->post('categoria')." ";
				$where .="AND tipoC.estatus=1 ";
				$bool_categoria=true;
			}else{
				$arrtienda['mensaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
			}
			$sw=true;
		}

		//Busqueda por Tipo de Venta
		if($this->input->post('tipo_orden')!=''){
			$tiendas->clear();		
			$tipoVenta->get_by_id($this->input->post('tipo_orden'));
			$tipoVenta->where('estatus','1');
			$tiendas=$tipoVenta->tiendascomida;
			$tiendas->where('estatus','1')->get();
			if($tiendas->exists()){
				$sql .=", tiendascomida_tiposventa AS tipoV";
				$where .="AND tienda.id = tipoV.tiendascomida_id AND tipoV.tiposventa_id =".$this->input->post('tipo_orden')." ";
				$where .="AND tipoV.estatus=1 ";
				$bool_venta=true;
			}else{
				$arrtienda['mensaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
			}
			$sw=true;
				
		}

		if (($bool_ciudad || $bool_zona || $bool_venta || $bool_categoria) && $sw){
			$tiendas->clear();
			$sql.=$where."GROUP BY tienda.id ORDER BY tienda.nombre";
			$tiendas->query($sql);

			if($tiendas->exists()){
				$img= new Imagen() ;
				
				$horario= new Horariosdespacho();
				
				foreach ($tiendas as $ti) {
					$respuesta['tienda_id']=$ti->id;
					$respuesta['nombre_tienda']=$ti->nombre;
					$img->clear();
					$img=$ti->imagen;
					$img->where('estatus','1')->get();
					if($img->exists()){
						$respuesta['ruta_imagen']=base_url().$img->rutaImagen;
					}else{
						$respuesta['ruta_imagen']='';
					}
					$tipoComida->clear();
					$tipoComida=$ti->tipotiendascomida;
					$tipoComida->where('estatus','1')->get();
					if($tipoComida->exists()){
						$i=1;
						foreach ($tipoComida as $tip){
							if($i==1){
								$respuesta['tipo_comida']=$tip->nombre;
							}else{
								$respuesta['tipo_comida'].=', '.$tip->nombre;
							}
							$i++;
						}
					}
					if($ti->minimoordencant!=null){
						$respuesta['min_cant']=$ti->minimoordencant;
					}
					if($ti->minimoordenprecio!=null){
						$respuesta['min_pre']=$ti->minimoordenprecio.'Bs';
					}

					$horario->clear();
					$horario=$ti->horariosdespacho;
					$hoy = mdate('%w',now());
					$hora= strtotime(mdate('%H:%i:%s',now()));
					$horario->where('estatus',1);
					$horario->where('dia',$hoy)->get();
					if($horario->exists()){
						if($horario->tipohorario==0){
							if( ( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) )  ){
								$respuesta['imagen_horario']=base_url().'imagenes/abierto.png';
							}else{
								$respuesta['imagen_horario']=base_url().'imagenes/cerrado.png';
							}
						}elseif($horario->tipohorario==1){
							if( (( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) ))
							|| (( $hora >= strtotime($horario->horainicio2) )&&($hora <=strtotime($horario->horacierre2) ))){
								$respuesta['imagen_horario']=base_url().'imagenes/abierto.png';
							}else{
								$respuesta['imagen_horario']=base_url().'imagenes/cerrado.png';
							}
						}else{
							$respuesta['imagen_horario']=base_url().'imagenes/cerrado.png';
						}
					}else{
						$respuesta['imagen_horario']='';
					}
					$tipoVenta->clear;
					$tipoVenta= $ti->tiposventa;
					$tipoVenta->where('estatus','1')->get();
					if($tipoVenta->exists()){
						$j=1;
						foreach ($tipoVenta as $ven){
							if($j==1){
								$respuesta['tipo_venta']=$ven->nombre;
							}else{
								$respuesta['tipo_venta'].=', '.$ven->nombre;
							}
							$j++;
						}
					}
					$arrtienda[]=$respuesta;
				}
				

				return $arrtienda;
			}else {
				return null;
			}

		}else{
			return null;
		}
	}

	
	function cargarCiudad(){
		$ciudad = new Ciudad();
		$ciudad->where('estatus','1');
		$ciudad->where('estados_id','7');
		$ciudad->order_by('nombreCiudad','ASD')->get_iterated();
		$options= array();
		if (!$ciudad->exists()) {
			return FALSE;
		}else{

			foreach ($ciudad as $ci) {
				$options[$ci->id] = $ci->nombreCiudad;
			}
			return $options;
		}

	}

	function cargarTipoComida(){
		$tipoComida = new Tipotiendascomida();
		$tipoComida->where('estatus','1');
		$tipoComida->order_by('nombre','ASD')->get_iterated();
		$options= array();
		if (!$tipoComida->exists()) {
			return FALSE;
		}else{

			foreach ($tipoComida as $tipo) {
				$options[$tipo->id] = $tipo->nombre;
			}
			return $options;
		}

	}

	function cargarTipoOrden(){
		$tipoOrden= new Tiposventa();
		$tipoOrden->where('estatus','1');
		$tipoOrden->order_by('nombre','ASD')->get_iterated();
		$options= array();
		if (!$tipoOrden->exists()) {
			return FALSE;
		}else{

			foreach ($tipoOrden as $tipo) {
				$options[$tipo->id] = $tipo->nombre;
			}
			return $options;
		}

	}

	function cargarZona(){
		$zona = new Zona();
		$zona->where('estatus','1');
		$zona->where('ciudades_id',$this->input->post('id_ciudad'));
		$zona->order_by('nombreZona','ASD')->get_iterated();
		$salida='<option value="" >Seleccione</option>;';
		if (!$zona->exists()) {
			$salida='0';
		}else{
			foreach ($zona as $zon) {
				$salida .= '<option value="'.$zon->id.'">'.$zon->nombreZona.'</option>';
			}
			$data['zona']= $salida;
			echo json_encode($data);
				
		}

	}
	
		
}
?>