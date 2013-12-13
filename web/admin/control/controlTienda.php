<?php  
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlTienda{
		static function verCarritos(Request $req, Application $app){
			$carritos = Modelo::getCarritos();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idCarritos = $req->request->get('cb_borrar');
		        	if(Modelo::borrarCarritos($idCarritos)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'tienda/carritos',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'tienda/carritos',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
		        }
		    }

			return $app ['twig']->render('/tienda/ver_carritos.twig', array(
		    	'form' => $form_borrar->createView(),
				'carritos' => $carritos,
				'msgCabecera' => 'Administración de carritos',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addCarrito(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
					->add('email','text', array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        		)
			        	)
			        )
					->add('fechaCreacion','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
					->add('fechaExpir','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

					if(Modelo::addCarrito($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Carrito añadido con éxito',
				    		'seccion' => 'tienda/carritos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Carrito',
				    		'seccion' => 'tienda/carritos'
						));
					}
		        }
		    }

		    return $app['twig']->render('/tienda/add_carrito.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Añadir carrito',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaCarrito(Request $req, Application $app, $id){
			$carrito = Modelo::getCarritoPorId($id);
			$lineas = Modelo::getLineasCarrito($id);
			$isLineas = false;
			if($lineas != null){
				$isLineas = true;
			}
			$form = $app['form.factory']->createBuilder('form')
					->add('idCarrito','hidden',array())
					->add('email','text', array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        		)
			        	)
			        )
					->add('fechaCreacion','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
					->add('fechaExpir','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
					->add('idCopia_Cuadro','text',array(
						"required" => false
						)
					)
					->add('nombreProducto','text',array(
						"required" => false
						)
					)
					->add('unidades','text',array(
						"required" => false
						)
					)
					->add('precio','text',array(
						"required" => false
						)
					)
					->add('IVA','text',array(
						"required" => false
						)
					)
			        ->add('borrarLineas', 'submit', array())
			        ->add('addLinea', 'submit', array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					$idLineas = $req->request->get('cb_borrarLineas');

		        	if ($form->get("addLinea")->isClicked()){
		        		if(Modelo::addLineaCarrito($data)){
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Operación correcta',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada añadida',
					    		'msgoperacion' => 'Línea añadida con éxito',
					    		'seccion' => 'tienda/carritos'
							));
						}else{
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Error',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada NO añadida',
					    		'msgoperacion' => 'Error al añadir Línea al Carrito',
					    		'seccion' => 'tienda/carritos'
							));
						}
		        	}else if($form->get("borrarLineas")->isClicked()){
		        		if(Modelo::borrarLineasCarrito($idLineas, $data['idCarrito'])){
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Operación correcta',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada modificada',
					    		'msgoperacion' => 'Linea de Carrito eliminada con éxito',
					    		'seccion' => 'tienda/carritos'
							));
						}else{
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Error',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada NO modificada',
					    		'msgoperacion' => 'Error al eliminar el registro Linea de Carrito',
					    		'seccion' => 'tienda/carritos'
							));
						}
		        	}else if($form->get("guardar")->isClicked()){
		        		if(Modelo::modificaCarrito($data)){
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Operación correcta',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada modificada',
					    		'msgoperacion' => 'Carrito modificado con éxito',
					    		'seccion' => 'tienda/carritos'
							));
						}else{
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Error',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada NO modificada',
					    		'msgoperacion' => 'Error al modificar el registro Carrito',
					    		'seccion' => 'tienda/carritos'
							));
						}
		        	}
		        }
		    }

		    return $app['twig']->render('/tienda/ficha_carrito.twig', array(
		    	'form' => $form->createView(),
		    	'carrito' => $carrito,
		    	'isLineas' => $isLineas,
		    	'lineas' => $lineas,
				'msgCabecera' => 'Ficha de carrito',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verLinea_Carrito(Request $req, Application $app, $id, $idLinea){
			$linea = Modelo::getLineaCarritoPorId($id, $idLinea);
			$form = $app['form.factory']->createBuilder('form')
					->add('idLinea_Carrito', 'hidden', array())			        
					->add('idCarrito', 'hidden', array())			        
					->add('idCopia_Cuadro','text',array())
					->add('nombreProducto','text',array())
					->add('unidades','text',array())
					->add('precio','text',array())
					->add('IVA','text',array())
					->add('totalLinea','text',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);		       

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaLineaCarrito($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Linea de Carrito modificada con éxito',
				    		'seccion' => 'tienda/carritos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Linea de Carrito',
				    		'seccion' => 'tienda/carritos'
						));
					}
		        }
		    }

		    return $app['twig']->render('/tienda/ver_linea_carrito.twig', array(
		    	'form' => $form->createView(),
		    	'linea' => $linea,
				'msgCabecera' => 'Ficha de administrador',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verPedidos(Request $req, Application $app){
			$pedidos = Modelo::getPedidos();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idPedidos = $req->request->get('cb_borrar');
		        	if(Modelo::borrarPedidos($idPedidos)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'tienda/pedidos',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'tienda/pedidos',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
		        }
		    }

			return $app ['twig']->render('/tienda/ver_pedidos.twig', array(
		    	'form' => $form_borrar->createView(),
				'pedidos' => $pedidos,
				'msgCabecera' => 'Administración de pedidos',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addPedido(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
					->add('email','text', array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        		)
			        	)
			        )
					->add('fecha','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

					if(Modelo::addPedido($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Pedido añadido con éxito',
				    		'seccion' => 'tienda/pedidos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Pedido',
				    		'seccion' => 'tienda/pedidos'
						));
					}
		        }
		    }

		    return $app['twig']->render('/tienda/add_pedido.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Añadir pedido',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaPedido(Request $req, Application $app, $id){
			$pedido = Modelo::getPedidoPorId($id);
			$lineas = Modelo::getLineasPedido($id);
			$estados = array(
				'En Espera'   => 'En Espera',
				'Confirmado' => 'Confirmado',
				'Enviado'   => 'Enviado',
				'Entregado'   => 'Entregado',
			);
			$isLineas = false;
			if($lineas != null){
				$isLineas = true;
			}
			$form = $app['form.factory']->createBuilder('form')
					->add('idPedido','hidden',array())
					->add('email','text', array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        		)
			        	)
			        )
					->add('fecha','text',  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
					->add('precioTotal','text',array(
						"required" => false
						)
					)
					->add('idCopia_Cuadro','text',array(
						"required" => false
						)
					)
					->add('nombreProducto','text',array(
						"required" => false
						)
					)
					->add('unidades','text',array(
						"required" => false
						)
					)
					->add('precio','text',array(
						"required" => false
						)
					)
					->add('IVA','text',array(
						"required" => false
						)
					)
			        ->add('borrarLineas', 'submit', array())
			        ->add('addLinea', 'submit', array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					$idLineas = $req->request->get('cb_borrarLineas');

					$descriptorModPedido = array(
						'estado' =>$req->request->get('selestados')
					);

		        	if ($form->get("addLinea")->isClicked()){
		        		if(Modelo::addLineaPedido($data)){
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Operación correcta',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada añadida',
					    		'msgoperacion' => 'Línea añadida con éxito',
					    		'seccion' => 'tienda/pedidos'
							));
						}else{
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Error',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada NO añadida',
					    		'msgoperacion' => 'Error al añadir Línea al Pedido',
					    		'seccion' => 'tienda/pedidos'
							));
						}
		        	}else if($form->get("borrarLineas")->isClicked()){
		        		if(Modelo::borrarLineasPedido($idLineas, $data['idPedido'])){
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Operación correcta',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada modificada',
					    		'msgoperacion' => 'Pedido modificado con éxito',
					    		'seccion' => 'tienda/pedidos'
							));
						}else{
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Error',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada NO modificada',
					    		'msgoperacion' => 'Error al modificar el registro Pedido',
					    		'seccion' => 'tienda/pedidos'
							));
						}
		        	}else if($form->get("guardar")->isClicked()){
		        		if(Modelo::modificaPedido($data, $descriptorModPedido)){
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Operación correcta',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada modificada',
					    		'msgoperacion' => 'Carrito modificado con éxito',
					    		'seccion' => 'tienda/pedidos'
							));
						}else{
							return $app['twig']->render('mod.twig', array(
								'msgCabecera' => 'Error',
					    		'sessionId' => $_SESSION['admin'],
					    		'titulo' => 'Entrada NO modificada',
					    		'msgoperacion' => 'Error al modificar el registro Carrito',
					    		'seccion' => 'tienda/pedidos'
							));
						}
		        	}					
		        }
		    }

		    return $app['twig']->render('/tienda/ficha_pedido.twig', array(
		    	'form' => $form->createView(),
		    	'pedido' => $pedido,
		    	'isLineas' => $isLineas,
		    	'lineas' => $lineas,
		    	'estados' => $estados,
				'msgCabecera' => 'Ficha de pedido',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verLinea_Pedido(Request $req, Application $app, $id, $idLinea){
			$linea = Modelo::getLineaPedidoPorId($id, $idLinea);
			$form = $app['form.factory']->createBuilder('form')
					->add('idLinea_Pedido', 'hidden', array())			        
					->add('idPedido', 'hidden', array())			        
					->add('idCopia_Cuadro','text',array())
					->add('nombreProducto','text',array())
					->add('unidades','text',array())
					->add('precio','text',array())
					->add('IVA','text',array())
					->add('totalLinea','text',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);		       

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaLineaPedido($data)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Linea de Pedido modificada con éxito',
				    		'seccion' => 'tienda/pedidos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Linea de Pedido',
				    		'seccion' => 'tienda/pedidos'
						));
					}
		        }
		    }

		    return $app['twig']->render('/tienda/ver_linea_pedido.twig', array(
		    	'form' => $form->createView(),
		    	'linea' => $linea,
				'msgCabecera' => 'Ficha de administrador',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verProductos(Request $req, Application $app){
			$productos = Modelo::getProductos();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idProductos = $req->request->get('cb_borrar');
		        	if(Modelo::borrarProductos($idProductos)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
							'titulo' => 'Entrada(s) eliminada(s)',
							'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
							'seccion' => 'tienda/productos',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
							'titulo' => 'Error en la operacion',
							'msgoperacion' => 'Hubo un error al eliminar las entradas del registro',
							'seccion' => 'tienda/productos',
							'sessionId' => $_SESSION['admin']
					    	)
					    );
					}
		        }
		    }

			return $app ['twig']->render('/tienda/ver_productos.twig', array(
		    	'form' => $form_borrar->createView(),
				'productos' => $productos,
				'msgCabecera' => 'Administración de productos',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addProducto(Request $req, Application $app){
			$pintores = Modelo::getPintores();
			$estilos = Modelo::getEstilos();
			$form = $app['form.factory']->createBuilder('form')
					->add('nombreProducto','text',array())
					->add('precio','text',array())
					->add('fotoCuadro','file',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../../img/productos/'.$data['nombreProducto'];

		            $extension = $files['fotoCuadro']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombreProducto'].'.'.$extension;
					$files['fotoCuadro']->move($path, $filename);

		        	$descriptorAddProd = array(
		        		'pintor' => $req->request->get('selpintores'),
		        		'estilo' => $req->request->get('selestilos'),
		        		'descripcion' => $req->request->get('descProducto'),
		        		'foto' => $filename
		        	);

					if(Modelo::addProducto($data, $descriptorAddProd)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Producto añadido con éxito',
				    		'seccion' => 'tienda\productos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Producto',
				    		'seccion' => 'tienda\productos'
						));
					}
		        }
		    }

		    return $app['twig']->render('/tienda/add_producto.twig', array(
		    	'form' => $form->createView(),
		    	'pintores' => $pintores,
		    	'estilos' => $estilos,
				'msgCabecera' => 'Añadir producto',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}

		static function verFichaProducto(Request $req, Application $app, $id){
			$producto = Modelo::getProductoPorId($id);
			$pintores = Modelo::getPintores();
			$estilos = Modelo::getEstilos();
			$form = $app['form.factory']->createBuilder('form')
					->add('idCopia_Cuadro','hidden',array())
					->add('nombreProducto','text',array())
					->add('precio','text',array())
					->add('fotoCuadro','file',array())
			        ->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

		        	$files = $req->files->get($form->getName());
		        		$path = __DIR__.'/../../img/productos/'.$data['nombreProducto'];

			            $extension = $files['fotoCuadro']->guessExtension();
						if (!$extension) {
						    $extension = 'bin';
						}

						$filename = $data['nombreProducto'].'.'.$extension;
						$files['fotoCuadro']->move($path, $filename);

		        	$descriptoModProd = array(
		        		'pintor' => $req->request->get('selpintores'),
		        		'estilo' => $req->request->get('selestilos'),
		        		'descripcion' => $req->request->get('descProducto'),
		        		'foto' => $filename
		        	); 

					if(Modelo::modificaProducto($data, $descriptoModProd)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Producto modificado con éxito',
				    		'seccion' => 'tienda\productos'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Producto',
				    		'seccion' => 'tienda\productos'
						));
					}
		        }
		    }

		    return $app['twig']->render('/tienda/ficha_producto.twig', array(
		    	'form' => $form->createView(),
		    	'pintores' => $pintores,
		    	'estilos'=> $estilos,
		    	'producto'=> $producto,
				'msgCabecera' => 'Ficha de cuadro',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}
?>