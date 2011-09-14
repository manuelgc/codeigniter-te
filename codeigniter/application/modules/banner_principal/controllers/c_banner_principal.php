<?php 
class C_banner_principal extends MX_Controller {
	
	function __construct() {
		parent::__construct();		
		
		//carga de librerias/helpers
		$this->load->helper('html');		
		$this->load->library('nivoslider');
		//elementos de plantilla
		$this->template->set_layout('two_columns/theme');													
	}
	
	function index() {
		return $this->loadBanner();
		//$data['imagenes'] = $this->loadBanner();
		//cargarTemplateDefault($data);								
	}
	
	function getImg() {
		$promocion = new Promocion();
		$imgPromociones = $promocion->getImagenPromocion();
		if (!$imgPromociones) {
			return NULL;		
		}else {
			return $imgPromociones;
		}		
	}
	
	function cargarOutputImg() {
		$rutaImg = $this->getImg();		
		if ($rutaImg != NULL) {
			$rutasImg = array();
			foreach ($rutaImg as $valor) {
				$rutasImg[] = img(base_url().$valor->rutaImagen);
			}			
			return $rutasImg;
		}else {
			echo 'rutaImg es null';
		}
	}
		
	function loadBanner($imagen = array(),$paramNivo = array(),$nombreSelector = '#slider-home') {
		$img = $this->nivoslider->outputTodo($this->cargarOutputImg($imagen,$paramNivo,$nombreSelector));		
		return $img;
	}
}
?>
