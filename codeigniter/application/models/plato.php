<?php 
class Plato extends DataMapper {
	var $table = 'platos';
	var $has_one= array(
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'plato',
			'join_other_as' => 'tiendacomida',
			'join_self_as' => 'plato'),
	'categoriaplato'=> array(
            'class' => 'categoriaplato',
            'other_field' => 'plato',
			'join_other_as' => 'categoriaplatos',
			'join_self_as' => 'plato')
	); 
	var $has_many = array(
	'promocion'=> array(
            'class' => 'promocion',
            'other_field' => 'plato'),
	'imagen'=> array(
            'class' => 'imagen',
            'other_field' => 'plato',
			'join_self_as' => 'plato'),
	'calificacionesproducto'=> array(
            'class' => 'calificacionesproducto',
            'other_field' => 'plato'),
	'favoritosusuario'=> array(
            'class' => 'favoritosusuario',
            'other_field' => 'plato'),
	'plato_extra' => array(
            'class' => 'plato_extra',
            'other_field' => 'plato',
			'join_other_as' => 'plato_extra',
			'join_self_as' => 'plato')
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

	function getImagen(){
		$img=$this->imagen->where('estatus',1)->get();
		if($img->exists()){
			return $img;
		}else {
			return false;
		}
	}
	
}

?>