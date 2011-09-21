<?php
class Tipospago extends DataMapper{
	var $table = 'tipospago';
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'tipospago'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>