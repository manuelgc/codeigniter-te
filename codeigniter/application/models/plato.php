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
	'extra' => array(
            'class' => 'extra',
            'other_field' => 'plato',
			'join_self_as' => 'platos'),
	'opcionesplato' => array(
            'class' => 'opcionesplato',
            'other_field' => 'plato',
			'join_self_as' => 'platos'),
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
	
	function getExtras(){
		$extra= $this->extra->where('estatus',1)->get();
		if ($extra->exists()) {
			return $extra;
		}else{
			return false;
		}
	}

	function getExtrasbyId($id_plato){
		$plato= new Plato();
		$plato->where('estatus',1)->get_by_id($id_plato);
		
		if ($plato->exists()) {
			$extra= $plato->extra->where('estatus',1)->get();
			if ($extra->exists()) {
				return $extra;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}
	
	function getOpciones(){
		$opciones= $this->opcionesplato->where('estatus',1)->get();
		if ($opciones->exists()) {
			return $opciones;
		}else{
			return false;
		}
	}

	function getOpcionesbyId($id_plato){
		$plato= new Plato();
		$plato->where('estatus',1)->get_by_id($id_plato);
		
		if ($plato->exists()) {
			$opciones= $plato->opcionesplato->where('estatus',1)->get();
			if ($opciones->exists()) {
				return $opciones;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}
	
}

?>