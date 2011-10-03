<?php
class Tiendascomida extends DataMapper{
	var $table = 'tiendascomida';
	var $has_one= array(
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'estados',
			'join_self_as' => 'tiendascomida'),
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'ciudades',
			'join_self_as' => 'tiendascomida'),
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'zonas',
			'join_self_as' => 'tiendascomida')); 
	var $has_many = array(
	'clasificacionestienda'=> array(
            'class' => 'clasificacionestienda',
            'other_field' => 'tiendascomida'),
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'platos',
			'join_self_as' => 'tiendascomida'),
	'imagen' => array(
            'class' => 'imagen',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'tiendascomida',
			'join_self_as' => 'tiendascomida'),
	'extrasplato'=> array(
            'class' => 'extrasplato',
            'other_field' => 'tiendascomida'),
	'horariosdespacho'=> array(
            'class' => 'horariosdespacho',
            'other_field' => 'tiendascomida'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'tiendascomida'),
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'tiendacomida',
			'join_self_as' => 'tiendacomida'),
	'tipotiendascomida'=> array(
						'class'=>'tipotiendascomida',
						'other_field' => 'tiendascomida',		
			            'join_self_as' => 'tiendascomida',		
			            'join_other_as' => 'tipotiendascomida',	
			            'join_table' => 'tiendascomida_tipotiendascomida'),
	'tiposventa'=> array(
						'class'=>'tiposventa',
						'other_field' => 'tiendascomida',		
			            'join_self_as' => 'tiendascomida',		
			            'join_other_as' => 'tiposventa',	
			            'join_table' => 'tiendascomida_tiposventa'),		
	);
	
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	function getEstadoById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){	
			$estado=$tienda->estado->where('estatus',1)->get();
				if($estado->exists()){
					return $estado;							
				}else{
					return false;	
				}
		}else{
			return false;
		}	
	}
	
	function getEstado(){
		$estado =$this->estado->where('estatus',1)->get();
			if($estado->exists()){
				return $estado;							
			}else{
				return false;	
			}
	}
	
	function getCiudadById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){	
			$ciudad=$tienda->ciudad->where('estatus',1)->get();
				if($ciudad->exists()){
					return $ciudad;							
				}else{
					return false;	
				}
		}else{
			return false;
		}	
	}
	
	function getCiudad(){
		$ciudad =$this->ciudad->where('estatus',1)->get();
			if($ciudad->exists()){
				return $ciudad;							
			}else{
				return false;	
			}
	}
	
	function getZonaById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){	
			$zona=$tienda->zona->where('estatus',1)->get();
				if($zona->exists()){
					return $zona;							
				}else{
					return false;	
				}
		}else{
			return false;
		}	
	}
	
	function getZona(){
		$zona =$this->zona->where('estatus',1)->get();
			if($zona->exists()){
				return $zona;							
			}else{
				return false;	
			}
	}
	
	function getTiposVentaById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){	
			$tipoVenta =$tienda->tiposventa->where('estatus',1)->get();
				if($tipoVenta->exists()){
					return $tipoVenta;							
				}else{
					return false;	
				}
		}else{
			return false;
		}	
	}
	function getTiposVenta(){
		$tipoVenta =$this->tiposventa->where('estatus',1)->get();
			if($tipoVenta->exists()){
				return $tipoVenta;							
			}else{
				return false;	
			}
	}
	//$dia valor numerico entre 0 y 6 
	
	function getHorarioDia($dia){
		$horario=$this->horariosdespacho;
		$horario->where('estatus',1)
				->where('dia',$dia)->get();	
		if($horario->exists()){
			return $horario;
		}
		else{ 
			return false;
		}	
	}
	function getHorarioDiabyId($dia,$id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$horario=$tienda->horariosdespacho;
			$horario->where('estatus',1)
			->where('dia',$dia)->get();
			if($horario->exists()){
				return $horario;
			}
			else{
				return false;
			}
		}else {
			return false;
		}
	}
	function getHorarioCompleto(){
		$horario=$this->horariosdespacho->where('estatus',1)->get();	
		if($horario->exists()){
			return $horario;
		}
		else{ 
			return false;
		}	
	}
	function getHorarioCompletobyId($dia,$id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$horario=$tienda->horariosdespacho->where('estatus',1)->get();
			if($horario->exists()){
				return $horario;
			}
			else{
				return false;
			}
		}else {
			return false;
		}
	}
	
	function getTiposComidaById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){	
			$tipoComida =$tienda->tipotiendascomida->where('estatus',1)->get();
				if($tipoComida->exists()){
					return $tipoComida;							
				}else{
					return false;	
				}
		}else{
			return false;
		}	
	}
	
	function getTiposComida(){
		$tipoComida =$this->tipotiendascomida->where('estatus',1)->get();
			if($tipoComida->exists()){
				return $tipoComida;						
			}else{
				return false;	
			}
	}
	function getImagen(){
		$img=$this->imagen->where('estatus',1)->get();
		if($img->exists()){
			return $img;
		}else {
			return false;
		}
	}

	function getImagenById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$img=$this->imagen->where('estatus',1)->get();
			if($img->exists()){
				return $img;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}
	
	function getPlatos(){
		$plato=$this->plato->where('estatus',1)->order_by('categoriaplatos_id asc,nombre asc')->get();
		if($plato->exists()){
			return $plato;
		}else {
			return false;
		}
	}

	function getPlatosById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$plato=$tienda->plato->where('estatus',1)->order_by('categoriaplatos_id asc,nombre asc')->get();
			if($plato->exists()){
				return $plato;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}
	
	//Retorna las categorias de los platos registrados en la tienda  
	function getCategoriaPlato(){
		$categoria = new Categoriaplato();
		$plato=$this->plato->select('categoriaplatos_id as "id"')->distinct()->where('estatus',1)->get();
		if ($plato->exists()){
			$categoria->where('estatus',1)->where_in('id',$plato)->order_by('nombre asc')->get();
			if($categoria->exists()){
				return $categoria;
			}else {
				return false;
			}
		}else{
			return false;
		}

	}

	//Igual que getCategoriaPlato() pero se debe suministra el id de la tienda  
	function getCategoriaPlatoById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$categoria = new Categoriaplato();
			$plato=$tienda->plato->select('categoriaplatos_id as "id"')->distinct()->where('estatus',1)->get();
			if ($plato->exists()){
				$categoria->where('estatus',1)->where_in('id',$plato)->order_by('nombre asc')->get();
				if($categoria->exists()){
					return $categoria;
				}else {
					return false;
				}
			}else{
				return false;
			}
		}else {
			return false;
		}

	}
}	
?>