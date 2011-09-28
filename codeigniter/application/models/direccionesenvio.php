<?php
class Direccionesenvio extends DataMapper {
	var $table = 'direccionesenvio';
	var $has_one= array(
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'direccionesenvio',
			'join_other_as' => 'zona'),
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'direccionesenvio',
			'join_other_as' => 'ciudades'),
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'direccionesenvio',
			'join_other_as' => 'estado'),
	'usuario'=> array(
						'class'=>'usuario',
						'other_field' => 'direccionesenvio',		
			            'join_other_as' => 'usuarios')); 
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'direccionesenvio')	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	

	function getDireccionesEnvioUsuario($id_usuario) {
		$de = new Direccionesenvio();
		$de->where('estatus',1);
		$de->get();
		$de->check_last_query();
		$de->usuario->where('id',$id_usuario)->get();
		$de->usuario->where('estatus',1)->get();		
		$de->check_last_query();
		if (!$de->exists()) {
			return FALSE;
		}else {
			return $de;
		}
	}
}
?>