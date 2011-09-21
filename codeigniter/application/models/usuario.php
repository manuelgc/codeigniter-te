<?php
class Usuario extends DataMapper {
	var $table = 'usuarios';
	var $has_one = array(
	'tipousuario'=> array(
            'class' => 'tipousuario',
            'other_field' => 'usuario')
	);
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'usuario'),
	'favoritosusuario'=> array(
            'class' => 'favoritosusuario',
            'other_field' => 'usuario'),
	'calificacionesproducto'=> array(
            'class' => 'calificacionesproducto',
            'other_field' => 'usuario'),
	'calificacionestienda'=> array(
            'class' => 'calificacionestienda',
            'other_field' => 'usuario'),
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