<?php
class c_pedido_login extends MX_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('language');	
		$this->load->library('form_validation');	
		$this->load->library('encrypt');	
		$this->load->module('autenticacion/c_registro_usuario');
		$this->load->module('busqueda/c_busqueda');
		$this->load->module('carrito/c_carrito');
		$this->form_validation->CI =& $this;	
	}

	function index($datos=array()) {
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
//		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.cookie.js'));
		
		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');
		
//		if($this->input->post('id_tienda')){
//			$data['output_block'] = $this->c_carrito->index($this->input->post('id_tienda'));
//		}
		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
//		$this->template->set_partial('block','web/layouts/two_columns/partials/block',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');

		if($this->verificarExisteSesion()===false){
			
			$data['login_usuario']= $this->load->view('autenticacion/v_login',$login_usuario,true);
			$this->template->build('pedido/v_pedido_login',$data);
		}else{
//			$this->load->view('pedido/v_pedido',$data);
			$this->template->build('pedido/v_pedido_login',$data);
		}
		
	}
	
	function cargarRegistro() {
		$data['ciudad'] = $this->c_registro_usuario->cargarCiudad();
		$data['captcha'] = $this->crearCaptcha();
		$dataAjax['html_registro']= $this->load->view('autenticacion/v_registro_cliente',$data,true);
		echo json_encode($dataAjax);
	}
	function verificarExisteSesion($mensaje = '') {
		if ($this->session->userdata('nombreusuario') === FALSE) {
//			redirect('home/c_home/index/'.$this->encrypt->sha1($mensaje));
			return false;
		}else {
			return $this->session->userdata('id');
		}		
	}
	
	function crearCaptcha() {
		$valores = array(
					'img_path' => realpath('application/captcha/').'/',
					'img_url' => base_url().'application/captcha/'						
					);

		$cap = create_captcha($valores);
		$modelo_captcha = new Captcha();
		$modelo_captcha->captcha_time = $cap['time'];
		$modelo_captcha->ip_address = $this->input->ip_address();
		$modelo_captcha->word = $cap['word'];
		$modelo_captcha->save();

		return $cap['image'];
		
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

}
?>