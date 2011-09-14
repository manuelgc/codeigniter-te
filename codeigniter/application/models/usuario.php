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
	
	function getUsuarioPorParam($arregloParam) {
		$usuario = new Usuario();
		
	}
}
?>