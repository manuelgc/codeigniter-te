<?php
class Tipospago extends DataMapper{
	var $table = 'tipospago';
	var $has_many = array('pedido');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}	
?>