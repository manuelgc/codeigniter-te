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
			'join_other_as' => 'imagenes',
			'join_self_as' => 'tiendascomida'),
	'extrasplato'=> array(
            'class' => 'extrasplato',
            'other_field' => 'tiendascomida'),
	'horariosdespacho'=> array(
            'class' => 'horariosdespacho',
            'other_field' => 'tiendascomida'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'direccionesentrega',
			'join_self_as' => 'tiendascomida'),
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'tiendascomida',
			'join_other_as' => 'pedidos',
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
	function getPlatosArreglo(){
		$plato=$this->plato->where('estatus',1)->order_by('categoriaplatos_id asc,nombre asc')->get();
		if($plato->exists()){
			foreach ($plato as $p) {
				$respuesta[$p->id]['id']=$p->id;
				$respuesta[$p->id]['nombre']=$p->nombre;
				$respuesta[$p->id]['precio']=$p->precio;
				$respuesta[$p->id]['descripcion']=$p->descripcion;
				$respuesta[$p->id]['tamano']=$p->tamano;
				$respuesta[$p->id]['descuento']=$p->descuento;
				$respuesta[$p->id]['estatus']=$p->estatus;
				$respuesta[$p->id]['categoriaplatos_id']=$p->categoriaplatos_id;
				$respuesta[$p->id]['tiendacomida_id']=$p->tiendacomida_id;
				
			}
			
			return $respuesta;
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
			$categoria->where('estatus',1)->where_in('id',$plato)->get();
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
				$categoria->where('estatus',1)->where_in('id',$plato)->get();
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
	
	function getDireccionesEntrega(){
		$direccion = $this->direccionesentrega->where('estatus',1)->order_by('estados_id,ciudades_id')->get();
		if($direccion->exists()){
			return $direccion;
		}else {
			return false;
		}
	}

	function getDireccionesEntregaById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$direccion = $tienda->direccionesentrega->where('estatus',1)->order_by('estados_id,ciudades_id')->get();
			if($direccion->exists()){
				return $direccion;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}
	
	//Retorna las ciudades donde la tienda puedes hacer envios  
	function getCiudadesEntrega(){
		 $direcciones= $this->direccionesentrega->select('ciudades_id as "id"')->distinct()->where('estatus',1)->get();
		 if($direcciones->exists()){
		 	$ciudades = new Ciudad();
			$ciudades->where('estatus',1)->where_in('id',$direcciones)->order_by('nombreCiudad')->get();
			
			if ($ciudades->exists()) {
				return $ciudades;
			}else {
				return false;
			}
		 }else {
		 	return false;
		 }
	}
	
	//igual que getCiudadesEntrega() pero se debe suministrar el id de la tienda 
	function getCiudadesEntregaById($id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$direcciones= $tienda->direccionesentrega->select('ciudades_id as "id"')->distinct()->where('estatus',1)->get();
			if($direcciones->exists()){
			 	$ciudades = new Ciudad();
			 	$ciudades->where('estatus',1)->where_in('id',$direcciones)->order_by('nombreCiudad')->get();
			 	 
			 	if ($ciudades->exists()) {
			 		return $ciudades;
			 	}else {
			 		return false;
			 	}
			}else {
				return false;
			}
		}else{
			return false;
		}
	}
	
	//Retorna las zonas donde la tienda puedes hacer envios, se debe suministrar el id de la ciudad
	function getZonasEntrega($id_ciudad){
		 $direcciones= $this->direccionesentrega->select('zonas_id as "id"')->distinct()->where('ciudades_id',$id_ciudad)->where('estatus',1)->get();
		 if($direcciones->exists()){
		 	$zonas = new Zona();
			$zonas->where('estatus',1)->where_in('id',$direcciones)->order_by('nombreZona')->get();
			
			if ($zonas->exists()) {
				return $zonas;
			}else {
				return false;
			}
		 }else {
		 	return false;
		 }
	}
	//Igual que getZonazEntrega() pero se debe suministrar el id de la tienda 
	function getZonasEntregaById($id_ciudad,$id_tienda){
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1)->get_by_id($id_tienda);
		if($tienda->exists()){
			$direcciones= $tienda->direccionesentrega->select('zonas_id as "id"')->distinct()->where('ciudades_id',$id_ciudad)->where('estatus',1)->get();
			if($direcciones->exists()){
				$zonas = new Zona();
				$zonas->where('estatus',1)->where_in('id',$direcciones)->order_by('nombreZona')->get();
					
				if ($zonas->exists()) {
					return $zonas;
				}else {
					return false;
				}
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
	
	function getCantTiendasComida($filtro = array()) {
		$tc = new Tiendascomida();
		$tc->where('estatus',1);
		if (!empty($filtro)) {
			$tc->where($filtro);
		}		
		return $tc->count();
	}
	
	function getTiendasComida($limit = '',$offset = '',$ordenacion = 'nombre asc') {
		$tc = new Tiendascomida();
		$arr_tiendas = array();
		$contador = 0;
		$tc->where('estatus',1);
		$tc->get_iterated($limit,$offset);
		if (!$tc->exists()) {
			return FALSE;
		}else {
			foreach ($tc as $fila_tienda) {
				$arr_tiendas[$contador]['nombre'] = $fila_tienda->nombre;
				$arr_tiendas[$contador]['razon_social'] = $fila_tienda->razonsocial;
				$arr_tiendas[$contador]['descripcion'] = $fila_tienda->descripcion;
				$arr_tiendas[$contador]['ci_rif'] = $fila_tienda->ci_rif;
				$arr_tiendas[$contador]['ciudad'] = $fila_tienda->ciudad->nombreCiudad;
				$arr_tiendas[$contador]['zona'] = $fila_tienda->zona->nombreZona;
			}
			return $arr_tiendas;
		}
	}
}
?>