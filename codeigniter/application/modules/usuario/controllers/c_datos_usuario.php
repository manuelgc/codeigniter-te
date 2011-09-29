<?php
class C_datos_usuario extends MX_Controller {
	private $id_usuario;
	
	function __construct() {
		parent::__construct();
		$this->id_usuario = Modules::run('autenticacion/c_login/verificarExisteSesion');
		$this->load->helper('language');
		$this->load->library('table');
		$this->load->module('busqueda/c_busqueda');	
	}
	
	function index() {
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));		

		$data['output_header'] = $this->getDataPartial('header');		
		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');		
		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');				
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);				
		//$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
		
		$data['datos_usuario'] = $this->getDatosUsuario();
		$data['dir_usuario'] = $this->getDireccionesUsuario();
		$data['estados_pedido'] = $this->cargarEstadosPedido();
		$data['tipo_ped'] = $this->cargarTipoPedido();
		$data['ped_fecha'] = $this->cargarPedidosFecha();
		$pedidos = $this->cargarPedidos();
		$this->table->set_heading('Tienda de Comida', 'Cantidad Total del Pedido', 'Estado del Pedido','Precio Total');
		$data['lista_ped'] = $this->table->generate($pedidos);
		$this->template->build('v_datos_cliente',$data);
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
	
	function cargarPedidos() {
		$pedidos_usuario = new Pedido();
		$resultado = $pedidos_usuario->getPedidosUsuario(2);
		return $resultado;
	}
}
?>