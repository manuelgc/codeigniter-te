<?php
class C_menu_admin extends MX_Controller {
	private $id_usuario;
	
	function __construct() {
		parent::__construct();
		$this->id_usuario = Modules::run('autenticacion/c_login/verificarExisteSesion','nosesion');
	}
	
	function index() {				
		if ($this->getTipoUsuario() == 'Administracion Tienda') {
			$data['admin_menu'] = 1;
		}elseif ($this->getTipoUsuario() == 'Superadmin') {
			$data['admin_menu'] = 2;
		}
		return $this->load->view('v_menu_admin',$data,true);
	}
	
	function getTipoUsuario() {
		$u = new Usuario();		
		return $u->getTipoUsuarioById($this->id_usuario);		
	}
}
?>