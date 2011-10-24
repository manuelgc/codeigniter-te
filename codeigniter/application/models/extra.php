<?php
class Extra extends DataMapper{ 
	var $table = 'extras';
	 
	var $has_many = array(
	'plato_extra'=> array(
            'class' => 'plato_extra',
            'other_field' => 'extra',
			'join_other_as' => 'plato_extra',
			'join_self_as' => 'extra'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}