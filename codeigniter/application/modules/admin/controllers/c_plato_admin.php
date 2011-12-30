<?php
class C_plato_admin extends MX_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('qtip2');
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->library('upload');

		$config['upload_path'] = './imagenes/platos/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = '1024';

		$this->upload->initialize($config);

		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();
		$data['output_menu'] = Modules::run('admin/c_menu_admin/index');
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/view.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.blockUI.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.form.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.validate.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.form.wizard-min.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.collapsible.js'));
		$this->template->append_metadata(script_tag(base_url().'application/modules/admin/js/js_plato.js'));
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/menu',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
	}

	function index() {
		if ($this->input->post('oculto')) {
			$this->procesarGuardar();
		}else{
			$data['cat_plato'] = $this->cargarCategoriaPlato();
			$data['imp'] = $this->cargarImpuesto();
			$data['catalogo_default'] = $this->catalogoTienda();
			$this->template->build('v_plato_admin',$data);
		}
	}

	function procesarGuardar() {
		foreach ($this->input->post() as $key => $value) {
			echo $key.' = '.$value.'<br>';
		}
		$this->mapOpcionesForm();
	}

	function guardarDatosPlato() {
		$id_tienda = $this->input->post('id_tienda');

		$cat_plato = new Categoriaplato();
		$cat_plato->where('estatus',1)->where('id',$this->input->post('categoria_plato'))->get();

		$imp = new Impuesto();
		$imp->where('estatus',1)->where('id',$this->input->post('impuesto'))->get();

		$plato = new Plato();
		$plato->nombre = $this->input->post('nombre_plato');
		$plato->precio = $this->input->post('precio');
		$plato->descripcion = $this->input->post('descripcion');
		$plato->descuento = $this->input->post('descuento');
		$plato->tipoPlato = $this->input->post('tipo_plato');

		$plato->trans_begin();
		$plato->save(array($cat_plato,$imp));

		if ($plato->trans_status() === FALSE) {
			$plato->trans_rollback();
		}
	}

	function mapOpcionesForm() {
		echo '<br>';
		$arreglo_opcion = array();
		$cont = 1;

		foreach ($this->input->post() as $key => $value) {
			if ($cont > 10) {
				$arr_clave = explode('_', $key);
				$opcion_actual = $arr_clave[1];
				if ($opcion_actual[0] == 'o') {
					if ($arr_clave[1] == $opcion_anterior) {
						;
					}
				}
			}
			$cont++;
		}
	}	

	function catalogoTienda($offset = '') {
		//paginador
		$limite = 10;
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
		$config['base_url'] = site_url().'/admin/c_plato_admin/catalogoTienda/';

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

	function cargarTiendas($limit,$offset,$filtro = array()) {
		$tiendas_comida = new Tiendascomida();
		$resultado = $tiendas_comida->getTiendasComida($limit,$offset,$filtro);
		return $resultado;
	}

	function getCantTiendas($filtro = array()) {
		$tienda_comida = new Tiendascomida();
		return $tienda_comida->getCantTiendasComida($filtro);
	}

	function cargarImpuesto() {
		$imp = new Impuesto();
		$imp->where('estatus','1');
		$imp->order_by('nombre','ASD')->get_iterated();
		$options = array();
		if (!$imp->exists()) {
			return '';
		}else {
			foreach ($imp as $fila) {
				$options[$fila->id] = $fila->nombre.' - '.$fila->porcentaje.'%';
			}
			return $options;
		}
	}

	function cargarCategoriaPlato() {
		$cat_plato = new Categoriaplato();
		$cat_plato->where('estatus','1');
		$cat_plato->order_by('nombre','ASD')->get_iterated();
		$options = array();
		if (!$cat_plato->exists()) {
			return '';
		}else {
			foreach ($cat_plato as $fila) {
				$options[$fila->id] = $fila->nombre;
			}
			return $options;
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
			$data['id'] = $tc->id;
			$data['nombre'] = $tc->nombre;
			$data['razonsocial'] = $tc->razonsocial;
			$data['ci_rif'] = $tc->ci_rif;
			echo json_encode($data);
		}
	}

	function mostrarFormOpcion() {
		$data['id_opcion'] = $this->input->post('id_opcion');
		if ($this->input->post('es_opcion') == '1') {
			$data['item_opcion'] = $this->load->view('v_opcion_form',$data,true);
		}else {
			$data['id_opcion_detalle'] = $this->input->post('id_opcion_detalle');
			$data['item_opcion_detalle'] = $this->load->view('v_opcion_detalle_form',$data,true);
		}
		echo json_encode($data);
	}

	function mostrarFormExtra() {
		$data['id_extra'] = $this->input->post('id_extra');
		if ($this->input->post('es_extra') == '1') {
			$data['item_extra'] = $this->load->view('v_extra_form',$data,true);
		}else {
			$data['id_extra_detalle'] = $this->input->post('id_extra_detalle');
			$data['item_extra_detalle'] = $this->load->view('v_extra_detalle_form',$data,true);
		}
		echo json_encode($data);
	}
}
?>