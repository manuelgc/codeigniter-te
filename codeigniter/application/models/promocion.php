<?php
class Promocion extends DataMapper {
	var $table = 'promociones';
	var $has_one = array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'promocion'));
	var $has_many = array(
	'imagen'=> array(
            'class' => 'imagen',
            'other_field' => 'promocion'));
	function __construct($id = NULL){
		parent::__construct($id);
		$this->load->helper('date');
	}
	
	/**
	 * 
	 * Funcion para obtener las imagenes que se publicaran en el banner publicitario
	 * @param none
	 * @return False si no hay promociones o un arreglo de objetos Imagenes
	 */
	function getImagenPromocion() {
		$promocion = new Promocion();
		$arrImagenes = array();
		$hoy = mdate('%Y-%m-%d',now());		
		//$promocion->where('fechaInicio <=',$hoy);
		//$promocion->where('fechaFinal >=',$hoy);
		$promocion->where('estatus','1')->get_iterated();
		if (!$promocion->exists()) {
			return FALSE;
		}else{
			foreach ($promocion as $valor) {
				$imagen = new Imagen();		
				$imagen->get_by_id($valor->id);
				$arrImagenes[] = $imagen;
			}
		}
		
		return $arrImagenes;
	}
}
?>