<?php
class c_busqueda extends MX_Controller{
	private $config= array(
	array(
		'field'=>'ciudad',
		'label'=>'lang:busqueda_ciudad',
		'rules'=>'callback_validar_campos_vacios')
	);
	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('language');
		$this->load->library('form_validation');
		//$this->load->module('home/c_home');
		$this->form_validation->CI =& $this;

	}
	function index() {
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/view.js'));		
		$arrCombo = array('ciudad'  => $this->cargarCiudad(),
                  		'categoria'    => $this->cargarTipoComida(),
                  		'orden'   => $this->cargarTipoOrden());
		
		$this->form_validation->set_rules($this->config);

		if ($this->input->post('campo_busqueda')) {
			if ($this->form_validation->run($this) == FALSE) {												
	//			$this->template->build();
				//$this->c_home->index();
				$data['error'] = validation_errors('<div class="error">', '</div>');
				$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);			
				redirect('home/c_home');	
			}else {
	//			$this->template->build('');
				/*if ($this->input->post('campo_busqueda')) {
					$this->buscarTiendaSql();
				}*/
				//$data['error'] = 'una vista';
			}
		}
		return $arrCombo;
	}
	
	function  buscarTiendaSql(){

		$sql="SELECT tienda.* FROM tiendascomida AS tienda";
		$where=" WHERE tienda.estatus=1 ";
		$sw=false;
		$tiendas = new Tiendascomida();
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
			$tiendas->check_last_query();
			if($tiendas->exists()){
				foreach ($tiendas as $ti) {
					echo '<h3>id:'.$ti->id.' nombre:'.$ti->nombre.'</h3>';
				}
			}else {
				echo '<h3>No hay resultados</h3>';
			}
		}else{
			echo '<h3>Debe seleccionar al menos 1 criterio de busqueda</h3>';
		}
	}

	function buscar(){

		$tiendas = new Tiendascomida();
		$dirEntrega = new Direccionesentrega();
		$tipoVenta = new Tiposventa();
		$tipoComida = new Tipotiendascomida();
		$tipoComidaTiendas = new Tiendascomida_tipotiendascomida();
		$tipoVentasTiendas =new Tiendascomida_tiposventa();
		
		//Busqueda por ciudad
		if($this->input->post('ciudad')!=''){
			$dirEntrega->where('ciudades_id',$this->input->post('ciudad'));
			$dirEntrega->where('estatus','1');
				
			//Busqueda por zona
			if($this->input->post('zona')!=''){
				$dirEntrega->where('zonas_id',$this->input->post('zona'));
			}
			
				$dirEntrega->group_by('tiendascomida_id')->get_iterated();
				echo $dirEntrega->check_last_query();
				if($dirEntrega->exists()){
				foreach ($dirEntrega as $dir) {
					$tiendas->clear();
					$tiendas->where('estatus','1');
					$tiendas->get_by_id($dir->tiendascomida_id);
					//falta ordenar Alfabeticamente las tiendas
					//echo $dirEntrega->check_last_query();
					echo '<h3>id:'.$tiendas->id.' nombre:'.$tiendas->nombre.'</h3>';
				}
			}else{
				echo '<h3>No hay resultados</h3>';
			}
		}elseif ($this->input->post('categoria')!='') {
//			$tipoComida->where('id',$this->input->post('categoria'))->get();
//			echo $tipoComida->check_last_query();
//			$tipoComidaTiendas->where('tipotiendacomida_id',$this->input->post('categoria'))->get();
//			echo $tipoComidaTiendas->check_last_query();
//			$tipoComidaTiendas->tiendascomida->get();
//			echo  $tipoComida->check_last_query();
//			$tiendas->where_related_tiendascomida_tipotiendascomida('tipotiendascomida_id', $this->input->post('categoria'))->get();
//			$tiendas->check_last_query();
			$tipoComidaTiendas->where('tipotiendacomida_id',$this->input->post('categoria'));
			$tipoComidaTiendas->where('estatus','1');
			$tipoComidaTiendas->group_by('tiendacomida_id')->get_iterated();
			echo $tipoComidaTiendas->check_last_query();
			if($tipoComidaTiendas->exists()){
				foreach ($tipoComidaTiendas as $tipo) {
					$tiendas->clear();
					$tiendas->where('estatus','1');
					$tiendas->get_by_id($tipo->tiendacomida_id);
					//falta ordenar Alfabeticamente las tiendas
					//echo $dirEntrega->check_last_query();
					echo '<h3>id:'.$tiendas->id.' nombre:'.$tiendas->nombre.'</h3>';
				}
			}else{
				echo '<h3>No hay resultados</h3>';
			} 
		}elseif ($this->input->post('tipo_orden')!=''){
//			$tipoVenta->where('id',$this->input->post('tipo_orden'))->get();
//			$tiendas->where_related($tipoVenta)->get();
//			$tiendas->where_related($tipoVenta,'id',$this->input->post('tipo_orden'))->get();
//			$tiendas->where_related('tiendascomida_tiposventa/tiposventa','id',$this->input->post('tipo_orden'))->get();			
			$tipoVentasTiendas->where('tiposventa_id',$this->input->post('tipo_orden'));
			$tipoVentasTiendas->where('estatus','1');
			$tipoVentasTiendas->group_by('tiendascomida_id')->get_iterated();
			echo $tipoVentasTiendas->check_last_query();
			if($tipoVentasTiendas->exists()){
				foreach ($tipoVentasTiendas as $tipoV) {
					$tiendas->clear();
					$tiendas->where('estatus','1');
					$tiendas->get_by_id($tipoV->tiendascomida_id);
					//falta ordenar Alfabeticamente las tiendas
					//echo $dirEntrega->check_last_query();
					echo '<h3>id:'.$tiendas->id.' nombre:'.$tiendas->nombre.'</h3>';
				}
			}else{
				echo '<h3>No hay resultados</h3>';
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
	function validar_campos_vacios($ciudad){	
		
		if(($ciudad=='') && ($this->input->post('zona')=='') && ($this->input->post('categoria')=='') && ($this->input->post('tipo_orden')=='')){
			$this->form_validation->set_message('validar_campos_vacios','Debe seleccionar al menos 1 criterio de busqueda');
			return false;
		}else {
			return true;
		}	
	}
		
}
?>