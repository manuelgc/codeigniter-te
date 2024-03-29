<?php
class Pedido extends DataMapper{
	var $table = 'pedidos';
	var $has_one= array(
	'usuario'=> array(
            'class' => 'usuario',
            'other_field' => 'pedido'),
	'direccionesenvio'=> array(
            'class' => 'direccionesenvio',
            'other_field' => 'pedido',
			'join_other_as' => 'direccionenvio'),
	'tipospago'=> array(
            'class' => 'tipospago',
            'other_field' => 'pedido'),
	'tiposventa'=> array(
            'class' => 'tiposventa',
            'other_field' => 'pedido',
			'join_other_as' => 'tipoventa'),
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

	function getPedidoPorId($id) {
		$p = new Pedido();
		$arr_pedido = array();
		$p->where('estatus',1);
		$p->where('id',$id);
		$p->get();
		$arr_pedido['fecha_pedido'] = $p->fechaPedido;
		$arr_pedido['hora_pedido'] = $p->horaPedido;
		$arr_pedido['cantidad'] = $p->cantidad;
		$arr_pedido['subtotal'] = $p->subtotal;		
		$arr_pedido['iva'] = $p->iva;
		$arr_pedido['total'] = $p->total;
		$arr_pedido['descuento'] = $p->descuento;
		$arr_pedido['estado_pedido'] = $p->estadospedido->get()->nombre;
		$arr_pedido['tienda_comida'] = $p->tiendascomida->get()->nombre;
		$arr_pedido['tipo_venta'] = $p->tiposventa->get()->nombre;
		$arr_pedido['direccion_envio_zona'] = $p->direccionesenvio->get()->zona->get()->nombreZona;
		$arr_pedido['direccion_envio_ciudad'] = $p->direccionesenvio->get()->ciudad->get()->nombreCiudad;
		$arr_pedido['direccion_envio_calle'] = $p->direccionesenvio->get()->calle_carrera;
		$arr_pedido['direccion_envio_casa'] = $p->direccionesenvio->get()->casa_urb;
		$arr_pedido['direccion_envio_casa'] = $p->direccionesenvio->get()->numeroCasaApto;
		$arr_pedido['direccion_envio_lugarref'] = $p->direccionesenvio->get()->lugarreferencia;
		
		return $arr_pedido;
	}
	
	function getPedidosUsuario($id_usuario, $limit = '', $offset = '',$ordenacion = 'fechaPedido desc, horaPedido desc') {
		$u = new Usuario();
		$arr_pedidos = array();
		$contador = 0;
		$u->where('estatus',1);
		$u->where('id',$id_usuario);
		$u->get();
		
		foreach ($u->pedido->where('estatus',1)->order_by($ordenacion)->get($limit,$offset) as $fila_pedid_user) { //$u->pedido->get()					
			$arr_pedidos[$contador]['ruta_img'] = img(base_url().$fila_pedid_user->tiendascomida->get()->imagen->get()->rutaImagen);
			$arr_pedidos[$contador]['cant'] = $fila_pedid_user->cantidad;
			$arr_pedidos[$contador]['nombre'] = $fila_pedid_user->estadospedido->get()->nombre;
			$arr_pedidos[$contador]['total'] = $fila_pedid_user->total;
			$arr_pedidos[$contador]['mas_info'] = img(array(
														'src' => base_url().'application/img/icon/Add-icon.png',
														'alt' => $fila_pedid_user->id,
														'class' => "mas-info-pedido"));
			$arr_pedidos[$contador]['reordenar'] = anchor('carrito/c_orden/'.$fila_pedid_user->id,
													img(base_url().'application/img/arrow_double.png'),
													array('title' => 'start'));
			$contador++;
		}

		return $arr_pedidos;
	}

	function getPedidoPorParam($parametros_pedido = array(),$parametros_usuario = array(),$limit = '',$offset = '',$ordenacion = 'fechaPedido desc, horaPedido desc') {
		if (empty($parametros_pedido) || empty($parametros_usuario)) {
			return FALSE;
		}else{
			$arr_pedidos = array();
			$u = new Usuario();
			$u->where($parametros_usuario);
			$u->get();
			$contador = 0;
			foreach ($u->pedido->where($parametros_pedido)->order_by($ordenacion)->get($limit,$offset) as $fila_pedid_user) {									
				$arr_pedidos[$contador]['ruta_img'] = img(base_url().$fila_pedid_user->tiendascomida->get()->imagen->get()->rutaImagen);
				$arr_pedidos[$contador]['cant'] = $fila_pedid_user->cantidad;
				$arr_pedidos[$contador]['nombre'] = $fila_pedid_user->estadospedido->get()->nombre;
				$arr_pedidos[$contador]['total'] = $fila_pedid_user->total;
				$arr_pedidos[$contador]['mas_info'] = img(array(
														'src' => base_url().'application/img/icon/Add-icon.png',
														'alt' => $fila_pedid_user->id,
														'class' => "mas-info-pedido"));
				$arr_pedidos[$contador]['reordenar'] = anchor('carrito/c_orden/'.$fila_pedid_user->id,
													img(base_url().'application/img/arrow_double.png'),
													array('title' => 'start'));
				$contador++;
			}			
			return $arr_pedidos;
		}
	}
	
	function getCantPedUsuario($id_usuario, $filtro = array(),$order = '') {
		$u = new Usuario();
		$u->where('estatus',1);
		$u->where('id',$id_usuario);
		$u->get();
		if (empty($filtro) && empty($order)) {										
			return $u->pedido->where('estatus',1)->count();
		}elseif (empty($filtro) && !empty($order)){
			return $u->pedido->where('estatus',1)->order_by($order)->count();
		}elseif (!empty($filtro) && empty($order)){
			return $u->pedido->where($filtro)->count();
		}elseif (!empty($filtro) && !empty($order)){
			return $u->pedido->where($filtro)->order_by($order)->count();
		}				
	}
}
?>