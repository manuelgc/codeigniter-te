<?php
class Usuario extends DataMapper {
	var $table = 'usuarios';
	var $has_one = array('estadosusuario',
	'tipousuario');
	var $has_many = array(
	'usuarios_direccionesenvio',
	'pedido',
	'favoritosusuario',
	'calificacionesproducto',
	'calificacionestienda');
	
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