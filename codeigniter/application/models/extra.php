<?php
class Extra extends DataMapper{ 
	var $table = 'extras';
	
	var $has_one= array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'extra',
			'join_other_as' => 'platos',
			'join_self_as' => 'extra')); 
	
	var $has_many = array(
	'extrasdetalle'=> array(
            'class' => 'extrasdetalle',
            'other_field' => 'extra',
			'join_self_as' => 'extras'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}
?>