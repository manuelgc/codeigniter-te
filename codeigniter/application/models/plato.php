<?php 
class Plato extends DataMapper {
	var $table = 'platos';
	var $has_one= array(
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'plato'),
	'categoriaplato'=> array(
            'class' => 'categoriaplato',
            'other_field' => 'plato')
	); 
	var $has_many = array(
	'promocion'=> array(
            'class' => 'promocion',
            'other_field' => 'plato'),
	'imagen'=> array(
            'class' => 'imagen',
            'other_field' => 'plato'),
	'calificacionesproducto'=> array(
            'class' => 'calificacionesproducto',
            'other_field' => 'plato'),
	'favoritosusuario'=> array(
            'class' => 'favoritosusuario',
            'other_field' => 'plato'),
	'pedido'=> array(
						'class'=>'pedido',
						'other_field' => 'plato',		
			            'join_self_as' => 'plato',		
			            'join_other_as' => 'pedido',	
			            'join_table' => 'pedidos_platos')
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}

?>