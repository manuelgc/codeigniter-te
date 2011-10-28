<?php
class Tipousuario extends DataMapper {
	var $table = 'tipousuarios';
	var $has_many = array(
	'usuario'=> array(
            'class' => 'usuario',
            'other_field' => 'tipousuario',
			'join_other_as' => 'usuario',
			'join_self_as' => 'tipousuarios')
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
}
?>