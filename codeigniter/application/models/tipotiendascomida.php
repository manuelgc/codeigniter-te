<?php
class Tipotiendascomida extends DataMapper{ 	
var $table = 'tipotiendascomida';
	var $has_many = array('Tiendascomida_tipotiendascomida');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}