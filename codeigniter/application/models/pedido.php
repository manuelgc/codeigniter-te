<?php
class Pedido extends DataMapper{
	var $table = 'pedidos';
	var $has_one= array(
	'usuario'=> array(
            'class' => 'usuario',
            'other_field' => 'pedido'),
	'direccionesenvio'=> array(
            'class' => 'direccionesenvio',
            'other_field' => 'pedido'),
	'tipospago'=> array(
            'class' => 'tipospago',
            'other_field' => 'pedido'),
	'tiposventa'=> array(
            'class' => 'tiposventa',
            'other_field' => 'pedido'),
	'estadospedido'=> array(
            'class' => 'estadospedido',
            'other_field' => 'pedido',
			'join_other_as' => 'estadopedido'),
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'pedido',
			'join_other_as' => 'tiendacomida',
			'join_self_as' => 'pedido')); 
	var $has_many = array(
	'plato'=> array(
			'class'=>'plato',
			'other_field' => 'pedido',		
	        'join_self_as' => 'pedido',		
	        'join_other_as' => 'plato',	
	        'join_table' => 'pedidos_platos'),
	'extrasplato'=> array(
            'class' => 'extrasplato',
            'other_field' => 'pedido',
			'join_self_as' => 'pedido',		
			'join_other_as' => 'extrasplato',	
			'join_table' => 'extrasplato_pedido'));
	
	function __construct($id = NULL) {
		parent::__construct($id);		
	}
	
	function getPedidosUsuario($id_usuario) {
		$u = new Usuario();
		$arr_pedidos = array();
		$contador = 0;	
		$u->where('estatus',1);
		$u->where('id',$id_usuario);
		$u->get();		
		$u->pedido->where('estatus',1)->get();
		//$u->pedido->order_by('horaPedido','asc');						
		foreach ($u->pedido->get() as $fila_pedid_user) {					
			$arr_pedidos[$contador]['ruta_img'] = img(base_url().$fila_pedid_user->tiendascomida->get()->imagen->get()->rutaImagen);
			$arr_pedidos[$contador]['cant'] = $fila_pedid_user->cantidad;
			$arr_pedidos[$contador]['nombre'] = $fila_pedid_user->estadospedido->get()->nombre;						
			$arr_pedidos[$contador]['total'] = $fila_pedid_user->total;
			$contador++;			
		}		
		
		return $arr_pedidos;
	}
}	
?>