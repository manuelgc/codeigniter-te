<?php
class Usuario extends DataMapper {
	var $table = 'usuarios';
	var $has_one = array('estadosusuario',
	'tipousuario');
	var $has_many = array(
	'pedido',
	'favoritosusuario',
	'calificacionesproducto',
	'calificacionestienda',
	'direccionesenvio'=> array(
						'class'=>'direccionesenvio',
						'other_field' => 'usuario',		
			            'join_self_as' => 'usuario',		
			            'join_other_as' => 'direccionesenvio',	
			            'join_table' => 'usuarios_direccionesenvio')
	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	function buscarPorNombreUsuario($nombre_usuario) {
		$usuario = new Usuario();
		$usuario->get_by_nombreusuario($nombre_usuario);
		return $usuario->exists();
	}
}
?>