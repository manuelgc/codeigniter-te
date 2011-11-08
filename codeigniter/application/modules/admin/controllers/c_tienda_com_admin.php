<?php
class C_tienda_com_admin extends MX_Controller {
	private $id_usuario;
	private $config = array(
		array(
			'field'=>'nombre_tienda',
			'label'=>'Nombre Tienda',
			'rules'=>'trim|required|max_length[255]|xss_clean'
		),
		array(
			'field'=>'descrip_tienda',
			'label'=>'Descripcion de la tienda',
			'rules'=>'trim|required|max_length[255]|xss_clean'
		),
		array(
			'field'=>'nombre_tienda',
			'label'=>'Nombre Tienda',
			'rules'=>'trim|required|max_length[255]|xss_clean'
		),
		array(
			'field'=>'tlf_1_1',
			'label'=>'Telefono 1',
			'rules'=>'trim|max_length[3]|required|callback_validar_tlf_1'
		),
		array(
			'field'=>'tlf_2_1',
			'label'=>'Telefono 2',
			'rules'=>'trim|required|max_length[3]|callback_validar_tlf_2'
		),
		array(
			'field'=>'razon_social',
			'label'=>'Razon Social',
			'rules'=>'trim|required|max_length[255]|xss_clean'
		),
		array(
			'field'=>'ci_rif',
			'label'=>'Cedula/Rif',
			'rules'=>'trim|required|max_length[10]|xss_clean'
		),
		array(
			'field'=>'min_ord_cant',
			'label'=>'Minimo orden (cantidad)',
			'rules'=>'trim|required|max_length[2]|xss_clean|integer'
		),
		array(
			'field'=>'min_ord_precio',
			'label'=>'Minimo orden (precio)',
			'rules'=>'trim|required|max_length[5]|xss_clean'
		),
		array(
			'field'=>'ciudad',
			'label'=>'Ciudad',
			'rules'=>'required'
		),
		array(
			'field'=>'zona',
			'label'=>'Zona',
			'rules'=>'required'
		)
	);
	function __construct() {
		parent::__construct();
		
		$this->load->library('qtip2');
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();
		$data['output_menu'] = Modules::run('admin/c_menu_admin/index');
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/page.css'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/table.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/view.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.blockUI.js'));		
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.dataTables.min.js'));
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/menu',$data);		
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
	}
	
	function validar_tlf_1($campo1) {
		$campo2 = $this->input->post('tlf_1_2');
		$campo3 = $this->input->post('tlf_1_3');
		if (empty($campo1) || empty($campo2) || empty($campo3)) {
			$this->form_validation->set_message('validar_fijo','Debe ingresar un numero de telefono valido');
			return FALSE;
		}else {
			if (!$this->form_validation->numeric($campo2) && !$this->form_validation->numeric($campo3)) {
				$this->form_validation->set_message('validar_fijo','Solo se permiten numeros para este campo');
				return FALSE;
			}else {
				return TRUE;
			}
		}
	}
	
	function validar_tlf_2($campo1) {
		$campo2 = $this->input->post('tlf_2_2');
		$campo3 = $this->input->post('tlf_2_3');
		if (empty($campo1) || empty($campo2) || empty($campo3)) {
			$this->form_validation->set_message('validar_fijo','Debe ingresar un numero de telefono valido');
			return FALSE;
		}else {
			if (!$this->form_validation->numeric($campo2) && !$this->form_validation->numeric($campo3)) {
				$this->form_validation->set_message('validar_fijo','Solo se permiten numeros para este campo');
				return FALSE;
			}else {
				return TRUE;
			}
		}
	}
	
	function index() {
		if ($this->input->post('oculto')) {
			$this->procesarGuardar();
		}else{
			$data['ciudades'] = $this->cargarCiudad();
			$data['catalogo_default'] = $this->catalogoTienda();
			$this->template->build('v_tienda_com_admin',$data);	
		}		
	}
	
	function procesarGuardar() {
		$this->form_validation->set_rules($this->config);
		
		if ($this->form_validation->run($this) == FALSE) {
			$data['ciudades'] = $this->cargarCiudad();
			$data['catalogo_default'] = $this->catalogoTienda();
			$this->template->build('v_tienda_com_admin',$data);
		}else {
			$tc = new Tiendascomida();
			$tc->id = $this->input->post('id_tienda');
			$tc->nombre = $this->input->post('nombre_tienda');
			$tc->descripcion = $this->input->post('telefono1');
			$tc->telefono1 = $this->input->post('tlf_1_1').$this->input->post('tlf_1_2').$this->input->post('tlf_1_3');
			$tc->telefono2 = $this->input->post('tlf_2_1').$this->input->post('tlf_2_2').$this->input->post('tlf_2_3');
			$tc->razonsocial = $this->input->post('razon_social');
			$tc->ci_rif = $this->input->post('ci_rif');
			$tc->minimoordencant = $this->input->post('min_ord_cant');
			$tc->minimoordenprecio = $this->input->post('min_ord_precio');
			$tc->estacionamiento = ($this->input->post('estacionamiento')) ? 1 : 0;
			$tc->minimotiempoentrega = $this->input->post('min_tiempo_ent');
			$tc->minimotiempoespera = $this->input->post('min_tiempo_esp');
			$tc->estatus = 1;
			$tc->guardarActualizar($tc, $this->input->post('ciudad'), $this->input->post('zona'));
			$data['mensaje'] = 'Se ha guardado la tienda exitosamente, recuerde ingresar los demas datos de la tienda.';
			$this->template->build('v_tienda_com_admin',$data);
		}
	}
	
	function cargarCiudad(){
		$ciudad = new Ciudad();
		$ciudad->where('estatus','1');
		$ciudad->where('estados_id','7');
		$ciudad->order_by('nombreCiudad','ASD')->get_iterated();
		$options= array();
		if (!$ciudad->exists()) {
			return '';
		}else{
			foreach ($ciudad as $ci) {
				$options[$ci->id] = $ci->nombreCiudad;
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
	
	function cargarZonaPorCiudad($ciudad){
		$zona = new Zona();
		$zona->where('estatus','1');
		$zona->where('ciudades_id',$ciudad);
		$zona->order_by('nombreZona','ASD')->get_iterated();
		if (!$zona->exists()) {
			return '';
		}else {
			foreach ($zona as $z) {
				$options[$z->id] = $z->nombreZona;
			}
			return $options;
		}

	}
	
	function getTiendaById() {
		$id_tienda = $this->input->post('id_tienda');
		$tienda_comida = new Tiendascomida();
		$tc = $tienda_comida->getTiendaById($id_tienda);
		if ($tc == FALSE) {
			return '';
		}else {
			$opciones_zona = $this->cargarZonaPorCiudad($tc->ciudad->get()->id);
			$data['id'] = $tc->id;
			$data['nombre'] = $tc->nombre;
			$data['descripcion'] = $tc->descripcion;
			$data['tlf_1'] = $tc->telefono1;
			$data['tlf_2'] = $tc->telefono2;
			$data['razonsocial'] = $tc->razonsocial;
			$data['ci_rif'] = $tc->ci_rif;
			$data['min_ord_cant'] = $tc->minimoordencant;
			$data['min_ord_precio'] = $tc->minimoordenprecio;
			$data['estacionamiento'] = $tc->estacionamiento;
			$data['ciudad'] = $tc->ciudad->get()->id;
			$data['zona'] = form_dropdown('zona',$opciones_zona,$tc->zona->get()->id,'class="element select medium" id="zona"');
			$data['min_tiempo_ent'] = $tc->minimotiempoentrega;
			$data['min_tiempo_esp'] = $tc->minimotiempoespera;
			echo json_encode($data);
		}				
	}
	
	function cargarTiendas($limit,$offset,$filtro = array()) {
		$tiendas_comida = new Tiendascomida();
		$resultado = $tiendas_comida->getTiendasComida($limit,$offset,$filtro);
		return $resultado;
	}
	
	function getCantTiendas($filtro = array()) {		
		$tienda_comida = new Tiendascomida();
		return $tienda_comida->getCantTiendasComida($filtro);
	}
	
	function getNombreTiendas() {
		$tiendas_comida = new Tiendascomida();		
		//si no se consigue nada devuelve falso por defecto				
		if ($nombres = $tiendas_comida->getNombreTiendas($this->input->post('term'))) {						
			//$campo['response'] = true;
			$campo = $nombres;
		}else {			
			$campo = '';
		}		
		echo json_encode($campo);
	}
	
	function catalogoTienda($offset = '') {
	//paginador
		$limite = 2;
		$filtro = array();			
		$bandera = FALSE;
		if ($this->input->is_ajax_request()) {
			if (!$this->input->post('id_tienda') && !$this->input->post('id_ciudad') && !$this->input->post('id_zona')) {
				$tiendas = $this->cargarTiendas($limite,$offset);			
				$config['total_rows'] = $this->getCantTiendas();					
			}else {				
				if ($this->input->post('id_tienda')) {
					$filtro['id'] = $this->input->post('id_tienda');
				}
				if ($this->input->post('id_ciudad')) {
					$filtro['ciudades_id'] = $this->input->post('id_ciudad');
				}
				if ($this->input->post('id_zona')) {
					$filtro['zonas_id'] = $this->input->post('id_zona');
				}
				$tiendas = $this->cargarTiendas($limite, $offset,$filtro);
				$config['total_rows'] = $this->getCantTiendas($filtro);
			}
		}else {
			$tiendas = $this->cargarTiendas($limite,$offset);
			$config['total_rows'] = $this->getCantTiendas();
		}											
		$config['base_url'] = site_url().'/admin/c_tienda_com_admin/catalogoTienda/';						
		
		$config['per_page'] = $limite;
		$config['uri_segment'] = 4;		
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li>';
		$config['cur_tag_close'] = '</li>';		

		$this->pagination->initialize($config);

		$data['link_pag'] = $this->pagination->create_links();		

		//tabla
		$this->table->set_heading('Nombre',
			'Razon Social',
			'CI/RIF', 
			'Descripcion',
			'Ciudad',
			'Zona'			
		);
		if (empty($tiendas)) {
			$data['lista_ped'] = 'No existen tiendas';
		}else{
			$data['lista_ped'] = $this->table->generate($tiendas);	
		}				
		$data['link_pag'] = $this->pagination->create_links();
		$data['ciudades'] = $this->cargarCiudad();
		$catalogo_html = $this->load->view('v_catalogo_tienda',$data,true);
		
		if ($this->input->is_ajax_request()) {					
			echo json_encode($data);
		}else {
			return $catalogo_html;
		}						
	}
}
?>