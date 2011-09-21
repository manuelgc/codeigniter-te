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
			$data['restaurantes']=$this->buscarTiendaSql();
//			$this->template->build('v_resultado_busqueda',$data);
			$this->load->view('v_resultado_busqueda',$data);
		}
	
	return $arrCombo;
	}

	function  buscarTiendaSql(){

		$sql="SELECT tienda.* FROM tiendascomida AS tienda";
		$where=" WHERE tienda.estatus=1 ";
		$sw=false;
		$tiendas = new Tiendascomida();
		
		$respuesta='';
		//Busqueda por ciudad
		if($this->input->post('ciudad')!=''){
			$sql .=", direccionesentrega AS dir";
			$where .="AND tienda.id = dir.tiendascomida_id AND dir.ciudades_id =".$this->input->post('ciudad')." ";
			$where .="AND dir.estatus=1 ";

			//Busqueda por zona
			if($this->input->post('zona')!=''){
				$where .="AND dir.zonas_id =".$this->input->post('zona')." ";
			}
			$sw=true;

		}

		//Busqueda por Tipo de Comida
		if($this->input->post('categoria')!=''){
			$sql .=", tiendascomida_tipotiendascomida AS tipoC";
			$where .="AND tienda.id = tipoC.tiendacomida_id	AND tipoC.tipotiendacomida_id =".$this->input->post('categoria')." ";
			$where .="AND tipoC.estatus=1 ";

			$sw=true;
		}

		//Busqueda por Tipo de Venta
		if($this->input->post('tipo_orden')!=''){
			$sql .=", tiendascomida_tiposventa AS tipoV";
			$where .="AND tienda.id = tipoV.tiendascomida_id AND tipoV.tiposventa_id =".$this->input->post('tipo_orden')." ";
			$where .="AND tipoV.estatus=1 ";
			$sw=true;
			
		}

		if ($sw){
			$sql.=$where."GROUP BY tienda.id ORDER BY tienda.nombre";
			$tiendas->query($sql);
//			$tiendas->check_last_query();
			if($tiendas->exists()){
				$img= new Imagen() ;
				$tipoComida = new Tipotiendascomida();
				$horario= new Horariosdespacho();
				foreach ($tiendas as $ti) {
//				echo '<h3>id:'.$ti->id.' nombre:'.$ti->nombre.'</h3>';
				
				$respuesta.=
				'<div class="" name"restaurant">
					<p><a name="'.$ti->id.'"></a>
				    <a onclick="" rel="" href=""> 
				        <span class="">'.$ti->nombre.'</span>
				    </a>
					</p>';
				
//				$img->where('tiendascomida_id',$ti->id);
				$img->clear();
				$img=$ti->imagen;
				$img->where('estatus','1')->get();
//				$img->check_last_query();              
				$respuesta.='<div class="" name="Informacion_restaurant">
				                    <div class="" name="imagen_restaurant">
				                        <a data-tracking-label="" rel="" href="">
				                           <img src="';
				if($img->exists()){
				$respuesta.=base_url().$img->rutaImagen.'" alt="" class="" style=""></a></div>';
				}else{
				$respuesta.='" alt="" class="" style=""></a></div>';	
				}
				$respuesta.='<div class="datos_restaurant"><p class="">';
				$tipoComida->clear();
				$tipoComida=$ti->tipotiendascomida;
				$tipoComida->where('estatus','1')->get();
				if($tipoComida->exists()){
					$i=1;
					foreach ($tipoComida as $tip){
						if($i==1){
							$respuesta.=$tip->nombre;	
						}else{
							$respuesta.=', '.$tip->nombre;
						}						
						$i++;
					}
				}
			    $respuesta.='</p>';                     
				if($ti->minimoordencant!=null){
			    	$respuesta.='<p>Cant. Minima: '.$ti->minimoordencant.'</p>';
				}
				if($ti->minimoordenprecio!=null){
			    	$respuesta.='<p>Gasto Minimo: '.$ti->minimoordenprecio.'Bs.</p>';
				}
				$horario->clear();
				$horario=$ti->horariosdespacho;
				$hoy = mdate('%W',now());
				echo 'dia sistema '.$hoy;
				
				
				$horario->func('DATE_FORMAT',array('@dia','%W'));
				$horario->where('dia !=','null');
				$horario->where('estatus','1')->get();
				echo 'dia bd '.$horario->dia;
				$horario->check_last_query();
				$respuesta.='<p>Horario dia</p>
							<p>tipos venta</p>
							<p>abierto o cerrado</p>
				            </div>
				            </div>
				</div>';
					
				}
				return $respuesta;
			}else {
				return '<h3>No hay resultados</h3>';
			}
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