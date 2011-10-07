<?php
class C_datos_usuario extends MX_Controller {
	private $id_usuario;

	function __construct() {
		
		parent::__construct();
		$this->id_usuario = Modules::run('autenticacion/c_login/verificarExisteSesion');
		$this->load->helper('language');
		$this->load->helper('cookie');
		$this->load->library('table');
		$this->load->library('pagination');
		$this->load->module('busqueda/c_busqueda');
		
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.cookie.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
		//$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/jquery.blockUI.js'));
	}

	function index($offset = '') {				

		$data['output_header'] = $this->getDataPartial('header');
		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');

		//plantilla
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
		//$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');

		//pestana datos y direcciones
		$data['datos_usuario'] = $this->getDatosUsuario();
		$data['dir_usuario'] = $this->getDireccionesUsuario();
		$data['estados_pedido'] = $this->cargarEstadosPedido();
		$data['tipo_ped'] = $this->cargarTipoPedido();
		$data['ped_fecha'] = $this->cargarPedidosFecha();
		
		//paginador
		$limite = 2;												
		$pedidos = $this->cargarPedidos($limite,$offset);		
		$config['base_url'] = site_url().'/usuario/c_datos_usuario/index/';					
		$config['total_rows'] = $this->getCantPedidos();
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
		$this->table->set_heading('Tienda de Comida',
			'Cantidad Total del Pedido', 
			'Estado del Pedido',
			'Precio Total',
			'Mas Detalles',
			'Reordenar'
		);
		$data['lista_ped'] = $this->table->generate($pedidos);
		if ($this->input->is_ajax_request()) {
			$this->table->set_heading('Tienda de Comida',
			'Cantidad Total del Pedido', 
			'Estado del Pedido',
			'Precio Total',
			'Mas Detalles',
			'Reordenar'
			);
			$data_ajax['lista_ped'] = $this->table->generate($pedidos);
			$data_ajax['link_pag'] = $this->pagination->create_links();
			echo json_encode($data_ajax);
		}else {
			$this->template->build('v_datos_cliente',$data);
		}
	}

	function processFiltro($offset = '') {		
		if ($this->input->post('reordenar')) {
					
			$data['output_header'] = $this->getDataPartial('header');
			$data['opcion_combos'] = $this->getDataPartial('breadcrumb');
		
			//plantilla
			$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
			$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
			$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
			$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
			//$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
			$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
			$this->template->set_layout('two_columns/theme');
		
			//pestana datos y direcciones
			$data['datos_usuario'] = $this->getDatosUsuario();
			$data['dir_usuario'] = $this->getDireccionesUsuario();
			$data['estados_pedido'] = $this->cargarEstadosPedido();
			$data['tipo_ped'] = $this->cargarTipoPedido();
			$data['ped_fecha'] = $this->cargarPedidosFecha();
		}
		
		
		
		//paginador
		$limite = 2;
		
		$pedidos = $this->filtrarBusqueda($limite, $offset);
		if (!empty($pedidos)) {
			$config['base_url'] = site_url().'/usuario/c_datos_usuario/processFiltro/';
			$filtro_count = array();
			$filtro_count['estatus'] = 1;
			$ordenacion = '';
			
			if ($this->input->is_ajax_request()) {
				$estado_selec = $this->input->cookie('estado_ped');
				$tipo_ped_selec = $this->input->cookie('tipo_ped');
				$fecha_ped_selec = $this->input->cookie('fecha_ped');
				if ($estado_selec != FALSE) {
					$filtro_count['estadopedido_id'] = $estado_selec;
				}
				if ($tipo_ped_selec != FALSE) {
					$filtro_count['tipoventa_id'] = $tipo_ped_selec;
				}
				if ($fecha_ped_selec != FALSE) {
					if ($fecha_ped_selec == '1') {
						$ordenacion = 'fechaPedido desc, horaPedido desc';
					}else {
						$ordenacion = 'fechaPedido asc, horaPedido asc';
					}
				}
			}else {			
				if ($this->input->post('estados_ped')) {
					$filtro_count['estadopedido_id'] = $this->input->post('estados_ped');
					//escribir cookie
					$cookie_estado_ped = array(
						'name' => 'estado_ped',
						'value' => $this->input->post('estados_ped'),
						'expire' => 0
					); 
					$this->input->set_cookie($cookie_estado_ped);
				}else {
					delete_cookie('estado_ped');
				}
				if ($this->input->post('tipo_ped')) {
					$filtro_count['tipoventa_id'] = $this->input->post('tipo_ped');
					//escribir cookie
					$cookie_tipo_ped = array(
						'name' => 'tipo_ped',
						'value' => $this->input->post('tipo_ped'),
						'expire' => 0
					); 
					$this->input->set_cookie($cookie_tipo_ped);
				}else {
					delete_cookie('tipo_ped');
				}	
				if ($this->input->post('ped_fecha')) {
					if ($this->input->post('ped_fecha') == '1') {
						$ordenacion = 'fechaPedido desc, horaPedido desc';
					}else {
						$ordenacion = 'fechaPedido asc, horaPedido asc';
					}
					$cookie_fecha_ped = array(
						'name' => 'fecha_ped',
						'value' => $this->input->post('ped_fecha'),
						'expire' => 0
					);
					$this->input->set_cookie($cookie_fecha_ped);
				}
			}					
								
			$config['total_rows'] = $this->getCantPedidos($filtro_count,$ordenacion);								
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
			$this->table->set_heading('Tienda de Comida',
				'Cantidad Total del Pedido', 
				'Estado del Pedido',
				'Precio Total',
				'Mas Detalles',
				'Reordenar'
			);
			
			if ($this->input->is_ajax_request()) {
				$this->table->set_heading('Tienda de Comida',
				'Cantidad Total del Pedido', 
				'Estado del Pedido',
				'Precio Total',
				'Mas Detalles',
				'Reordenar'
				);
				$data_ajax['lista_ped'] = $this->table->generate($pedidos);
				$data_ajax['link_pag'] = $this->pagination->create_links();
				echo json_encode($data_ajax);
			}else {
				$data['lista_ped'] = $this->table->generate($pedidos);
				$this->template->build('v_datos_cliente',$data);
			}	
		}else {
			$data['lista_ped'] = '<h2>Lo sentimos, no existe ningun pedido que cumpla con tu busqueda.</h2>';
			$data['lista_ped'] .= '<p>Entra '.anchor('home/c_home','aqui').' y conoce todos nuestros restaurantes.</p>';
			$this->template->build('v_datos_cliente',$data);
		}
		
	}
	
	function getDataPartial($partial = '') {
		$output = '';
		switch ($partial) {
			case 'breadcrumb':
				$output = $this->c_busqueda->index();
				break;
			case 'header':
				$output = Modules::run('banner_principal/c_banner_principal/index');
				break;
			case 'block':
				$output = Modules::run('autenticacion/c_login/cargarView');
		}

		return $output;
	}

	function getDatosUsuario() {
		$u = new Usuario();
		$usuario_actual = $u->getUsuarioById(2); //$this->id_usuario
		if ($usuario_actual === FALSE) {
			return NULL;
		}else {
			return $usuario_actual;
		}
	}

	function getDireccionesUsuario() {
		$u = new Usuario();
		$usuario_actual = $u->getDireccionesEnvio(2); //$this->id_usuario
		if ($usuario_actual === FALSE) {
			return NULL;
		}else {
			return $usuario_actual;
		}
	}

	function cargarEstadosPedido() {
		$estadoPed = new Estadospedido();
		$resultado = $estadoPed->getEstadosPedido();
		return $resultado;
	}

	function cargarTipoPedido() {
		$tipo_ped = new Tiposventa();
		$resultado = $tipo_ped->getTipoVenta();
		return $resultado;
	}

	function cargarPedidosFecha() {
		$options = array(
			'1' => 'Pedidos Recientes',
			'2' => 'Pedidos Anteriores'			
			);

			return $options;
	}

	function cargarPedidos($limit,$offset) {
		$pedidos_usuario = new Pedido();
		$resultado = $pedidos_usuario->getPedidosUsuario(2,$limit,$offset);
		return $resultado;
	}

	function getCantPedidos($param_pedidos = array(),$order = '') {
		$p = new Pedido();		
		return $p->getCantPedUsuario(2,$param_pedidos,$order); //$this->id_usuario
	}

	function getPedidoPorId($id_pedido) {
		$p = new Pedido();
		$pedido = $p->getPedidoPorId($id_pedido);
		echo json_encode($pedido);
	}

	function filtrarBusqueda($limit,$offset) {
		if (
			($this->input->post('estados_ped') != FALSE) || 
			($this->input->post('tipo_ped') != FALSE) || 
			($this->input->post('ped_fecha') != FALSE)) {			
			$estado_ped = $this->input->post('estados_ped');
			$tipo_ped = $this->input->post('tipo_ped');
			$ped_fecha = $this->input->post('ped_fecha');		
		}elseif ($this->input->is_ajax_request()) {
			$estado_ped = $this->input->cookie('estado_ped');
			$tipo_ped = $this->input->cookie('tipo_ped');
			$ped_fecha = $this->input->cookie('fecha_ped');			
		}		
				
		$p = new Pedido();

		$param_usuario = array(
				'id' => 2,	//$this->id_usuario
				'estatus' => 1
		);

		//si estan seleccionados estado y tipo
		if (($estado_ped != FALSE) && ($tipo_ped != FALSE)) {
			$param_pedido = array(
				'estadopedido_id' => $estado_ped,
				'tipoventa_id' => $tipo_ped,
				'estatus' => 1
			);			
			return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset);
		//si esta seleccionado los 3
		}elseif (($estado_ped != FALSE) && ($tipo_ped != FALSE) && ($ped_fecha != FALSE)){
			$param_pedido = array(
				'estadopedido_id' => $estado_ped,
				'tipoventa_id' => $tipo_ped,
				'estatus' => 1
			);			
			
			if ($ped_fecha == '1') {
				return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset);	
			}else {
				return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset,'fechaPedido asc, horaPedido asc');
			}
		//si esta seleccionado solo tipo pedido
		}elseif (($estado_ped == FALSE) && ($tipo_ped != FALSE)){
			$param_pedido = array(
				'tipoventa_id' => $tipo_ped,
				'estatus' => 1
			);
			return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset);
		//si esta seleccionado solo tipo pedido y fecha		
		}elseif (($estado_ped == FALSE) && ($tipo_ped != FALSE) && ($ped_fecha != FALSE)){
			$param_pedido = array(
				'tipoventa_id' => $tipo_ped,
				'estatus' => 1
			);
			if ($ped_fecha == '1') {
				return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset);	
			}else {
				return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset,'fechaPedido asc, horaPedido asc');
			}
		//si esta seleccionado solo estado pedido
		}elseif (($estado_ped != FALSE) && ($tipo_ped == FALSE)) {
			$param_pedido = array(
				'estadopedido_id' => $estado_ped,
				'estatus' => 1
			);			
			return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset);
		//si esta seleccionado solo estado pedido y fecha
		}elseif (($estado_ped != FALSE) && ($tipo_ped == FALSE) && ($ped_fecha != FALSE)){
			$param_pedido = array(
				'estadopedido_id' => $estado_ped,
				'estatus' => 1
			);		
			if ($ped_fecha == '1') {
				return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset);	
			}else {
				return $p->getPedidoPorParam($param_pedido, $param_usuario,$limit,$offset,'fechaPedido asc, horaPedido asc');
			}	
		//si esta seleccionado solo fecha
		}elseif (($ped_fecha != FALSE) && ($estado_ped == FALSE) && ($tipo_ped == FALSE)){						
			if ($ped_fecha == '1') {				
				return $p->getPedidosUsuario(2,$limit,$offset); //$this->id_usuario
			}else {				
				return $p->getPedidosUsuario(2,$limit,$offset,'fechaPedido asc, horaPedido asc'); //$this->id_usuario
			}
		}
	}	
}
?>