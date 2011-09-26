<?php
class Usuario extends DataMapper {
	var $table = 'usuarios';
	var $has_one = array(
	'tipousuario'=> array(
            'class' => 'tipousuario',
            'other_field' => 'usuario',
			'join_other_as' => 'tipousuarios')
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
			            'join_other_as' => 'direccionesenvio')
	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	function buscarPorNombreUsuario($nombre_usuario) {
		$usuario = new Usuario();
		$usuario->where('nombreusuario',$nombre_usuario)->get();			
		return $usuario->exists();
	}
}
?>