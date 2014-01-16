<?php

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\Validator\Constraints as Assert;

	class Controller{

		static function noAuth($app){
			return $app->redirect($app['url_generator']->generate('login'));
		}

		static function checkLog(){
			if(isset($_SESSION['cliente'])){
				return true;
			}else{
				return false;
			}
		}

		static function forgotPassword(Request $req, Application $app){
			$logged = Controller::checkLog();
			$form = $app['form.factory']->createBuilder('form')
					->add('email', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        	)
			        	)
			        )
			        ->add('enviar','submit',array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);


		        if ($form->isValid()) {
		        	$data = $form->getData();

					if(Modelo::existeCliente($data['email'])){
						$newPass = Modelo::generaNuevaPass($data['email']);
						$user = Modelo::getDatosCliente($data['email']);
						$message = \Swift_Message::newInstance()
                                  ->setSubject('Recuperación de contraseña')
                                  ->setFrom(array('dawrmjn@gmail.com'))
                                  ->setTo(array($data['email']))
                                  ->setBody($app['twig']->render('email_recupera_pass.twig',array(
                                  	'user' => $user,
                                  	'newPass' => $newPass)),'text/html');
                                  
 
                        $app['mailer']->send($message);
 
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Correo enviado.',
							'msg' => 'Se ha enviado un correo a su dirección con su nueva contraseña. Compruebe su bandeja de entrada.',
							'logged' => $logged
						));
					}else{
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Error',
							'msg' => 'No se encuentra la dirección de correo introducida',
							'logged' => $logged
						));
					}
		        }
		    }

		    return $app['twig']->render('forgot_password.twig', array(
		    	'form' => $form->createView(),
		    	'logged'=> $logged
		    	)
		    );
		}

		static function main(Application $app){
			$productos = Modelo::getUltimosProductos();
			$logged = Controller::checkLog();
			return $app['twig']->render('inicio.twig', array(
				'productos' => $productos,
				'logged' => $logged
				)
			);
			
		}

		static function verCuadros(Application $app){
			$productos = Modelo::getAllProductos();
			$logged = Controller::checkLog();
			return $app['twig']->render('ver_cuadros.twig', array(
				'productos' => $productos,
				'logged' => $logged
				)
			);
		}

		static function verPintores(Application $app){
			$pintores = Modelo::getAllPintores();
			$logged = Controller::checkLog();
			return $app['twig']->render('ver_pintores.twig', array(
				'pintores' => $pintores,
				'logged' => $logged
				)
			);
		}

		static function detallePintor(Application $app, $nombrePintor){
			$pintor = Modelo::getPintorByName($nombrePintor);
			$cuadros = Modelo::getCuadrosDePintor($nombrePintor);
			$logged = Controller::checkLog();
			return $app['twig']->render('detalle_pintor.twig', array(
				'pintor' => $pintor,
				'cuadros' => $cuadros,
				'logged' => $logged
				)
			);
		}

		static function verEstilos(Application $app){
			$estilos = Modelo::getAllEstilos();
			$logged = Controller::checkLog();
			return $app['twig']->render('ver_estilos.twig', array(
				'estilos' => $estilos,
				'logged' => $logged
				)
			);
		}

		static function detalleEstilo(Application $app, $nombreEstilo){
			$estilo = Modelo::getEstiloByName($nombreEstilo);
			$cuadros = Modelo::getCuadrosDeEstilo($nombreEstilo);
			$logged = Controller::checkLog();
			return $app['twig']->render('detalle_estilo.twig', array(
				'estilo' => $estilo,
				'cuadros' => $cuadros,
				'logged' => $logged
				)
			);
		}

		static function verExpos(Application $app){
			$expos = Modelo::getAllExpos();
			$logged = Controller::checkLog();
			return $app['twig']->render('ver_expos.twig', array(
				'expos' => $expos,
				'logged' => $logged
				)
			);
		}

		static function detalleExpo(Application $app, $nombreExpo){
			$expo = Modelo::getExpoByName($nombreExpo);
			$cuadros = Modelo::getCuadrosDeExpo($expo->getidExposicion());
			$logged = Controller::checkLog();
			return $app['twig']->render('detalle_expo.twig', array(
				'expo' => $expo,
				'cuadros' => $cuadros,
				'logged' => $logged
				)
			);
		}

		static function buscar(Request $req, Application $app){
			$logged = Controller::checkLog();
			$key = $req->request->get("form_keyword");
			$results = Modelo::busqueda($key);
			return $app['twig']->render('resultados_busqueda.twig', array(
				'results' => $results,
				'logged' => $logged
			));
		}

		static function item(Request $req,Application $app, $id){
			$producto = Modelo::getDetallesProducto($id);
			$form = $app['form.factory']->createBuilder('form')
					->add("cliente",'hidden',array())
					->add("idCopia_Cuadro",'hidden',array())
					->add("nombreProducto",'hidden',array())
					->add("precio",'hidden',array())
					->add("enviar",'submit',array())
					->getForm();
			$logged = Controller::checkLog();
			if($logged){
				$cliente = $_SESSION['cliente'];
			}else{
				$cliente = "";
			}

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);


		        if ($form->isValid()) {
		        	$data = $form->getData();
		        	$unidades = $req->request->get('selunidades');

					if(Modelo::addLineaCarrito($data,$unidades)){
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Producto añadido',
							'msg' => 'Se ha añadido el producto a su carrito',
							'logged' => $logged
						));
					}else{
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Error',
							'msg' => 'Ha ocurrido un error al añadir el producto, inténtelo de nuevo',
							'logged' => $logged
						));
					}
		        }
		    }

			return $app['twig']->render('item.twig', array(
				'logged' => $logged,
				'producto' => $producto,
				'cliente' => $cliente,
				'form' => $form->createView()
				)
			);
		}

		static function logIn(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('usuario', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        		)
			        	)
			        )
			        ->add('clave', "password", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Length(array(
						            'min' => 6,
						            'max' => 12
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add("clavecifrada", "hidden", array())
			        ->add("acceder", "submit", array())
					->getForm();

		    if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::isCliente($data)){
						$_SESSION['cliente'] = $data['usuario'];
						Modelo::checkCarrito($data['usuario']);
						return $app->redirect($app['url_generator']->generate('inicio'));
					}else{
						return $app['twig']->render('login.twig', array(
					    	'form' => $form->createView(),
					    	'logged' => false,
					    	'msgerr' => 'Nombre de Usuario a contraseña no válidos.'
					    	)
					    );
					}
		        }
		    }

		    return $app['twig']->render('login.twig', array(
		    	'form' => $form->createView(),
		    	'logged' => false,
				'msgerr' => ''
		    	)
		    );
		}

		static function logOut(Application $app){
			session_destroy();
			return $app['twig']->render('logout.twig', array(
				'logged' => false,
				'user' => 'usuario anónimo'
				)
			);
		}

		static function signIn(Request $req, Application $app){
			$form = $app['form.factory']->createBuilder('form')
			        ->add('email', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Email()
				        	)
			        	)
			        )
			        ->add('clave', "password", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Length(array(
						            'min' => 6,
						            'max' => 12
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add("clavecifrada", "hidden", array())
			        ->add('nombre', "text", array())
			        ->add('nif', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^(X(-|\.)?0?\d{7}(-|\.)?[A-Z]|[A-Z](-|\.)?\d{7}(-|\.)? [0-9A-Z]|\d{8}(-|\.)?[A-Z])$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('direccion', "text", array())
			        ->add('pais', "text", array())
			        ->add('provincia', "text", array())
			        ->add('poblacion', "text", array())
			        ->add('codigoPostal', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('telf', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^[9|8|6|7][0-9]{8}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('numeroTarjeta','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{16}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('CCV','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{3}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('registrar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$fechaCad = $req->request->get('selfechCadAnio') . '-' . $req->request->get('selfechCadMes') . '-01';

					if(Modelo::registroCliente($data, $fechaCad)){
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Registro completo',
							'msg' => 'El registro de su cuenta se ha completado satisfactoriamente, puede acceder a su cuenta desde el menú superior',
							'logged' => false
						));
					}else{
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Error en el registro',
							'msg' => 'Ha ocurrido un error durante el registro, inténtelo de nuevo.',
							'logged' => false
						));
					}
		        }
		    }

		    return $app['twig']->render('sign.twig', array(
		    	'form' => $form->createView(),
		    	'logged' => false,
		    	'curYear' => date("Y")
		    	)
		    );
		}

		static function verDatosCuenta(Request $req, Application $app){
			$datosCuenta = Modelo::getDatosCliente($_SESSION['cliente']);
			$datosBanc = Modelo::getDatosBanc($_SESSION['cliente']);
			$fechCad = explode("-", $datosBanc['fechaCaducidad']);
			$form = $app['form.factory']->createBuilder('form')
					->add('email','hidden',array())
			        ->add('claveActual', "password", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(), 
				        		new Assert\Length(array(
						            'min' => 6,
						            'max' => 12
						    	    )
						    	)
						    )
			        	)
			        )
			        ->add("claveactualcifrada", "hidden", array())
			        ->add('claveNueva', "password", array(
			        	'constraints' => array( 
				        		new Assert\Length(array(
						            'min' => 6,
						            'max' => 12
						    	    )
						    	)
						    ),
			        	'required' => false
			        	)
			        )
			        ->add("clavenuevacifrada", "hidden", array())
			        ->add('nombre', "text", array())
			        ->add('nif', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^(X(-|\.)?0?\d{7}(-|\.)?[A-Z]|[A-Z](-|\.)?\d{7}(-|\.)? [0-9A-Z]|\d{8}(-|\.)?[A-Z])$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('direccion', "text", array())
			        ->add('pais', "text", array())
			        ->add('provincia', "text", array())
			        ->add('poblacion', "text", array())
			        ->add('codigoPostal', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('telf', "text", array(
			        	'constraints' => array(
				        		new Assert\NotBlank(),
				        		new Assert\Regex(array(
						            'pattern' => '/^[9|8|6|7][0-9]{8}$/'
						        	)
						        )
						    )
			        	)
			        )
			        ->add('numeroTarjeta','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{16}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('CCV','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{3}/',
				        		)
			        		)
			        	),
			        	'required' => false
			        ))
			        ->add('guardar', 'submit', array())
			        ->add('borrarCuenta', 'submit', array())
			        ->getForm();

		  if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$fechaCad = $req->request->get('selfechCadAnio') . '-' . $req->request->get('selfechCadMes') . '-01';

		        	if($form->get("guardar")->isClicked()){
		        		if(Modelo::modificaCuenta($data, $fechaCad)){
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Datos modificados',
								'msg' => 'Sus datos se han modificado correctamente',
								'logged' => true
							));
						}else{
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Error',
								'msg' => 'Ha ocurrido un error durante la modificación de datos, inténtelo de nuevo.',
								'logged' => true
							));
						}
		        	}else if($form->get("borrarCuenta")->isClicked()){
		        		session_destroy();
		        		if(Modelo::borrarCuenta($datosCuenta->getEmail())){
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Usuario borrado',
								'msg' => 'Su cuenta se ha borrado correctamente',
								'logged' => false
							));
						}else{
							return $app['twig']->render('operation.twig', array(
								'operation' => 'Error',
								'msg' => 'Ha ocurrido un error durante la baja de su cuenta, inténtelo de nuevo.',
								'logged' => true
							));
						}
		        	}
		        }
		    }

		    return $app['twig']->render('mi_cuenta.twig', array(
		    	'form' => $form->createView(),
		    	'logged' => true,
		    	'curYear' => date("Y"),
		    	'cliente' => $datosCuenta,
		    	'datosBanc' => $datosBanc,
		    	'fechCad' => $fechCad
		    	)
		    );
		}

		static function verCarrito(Request $req, Application $app){
			$idCarrito = Modelo::getIdCarrito($_SESSION['cliente']);
			$lineasCarrito = Modelo::getLineasCarrito($idCarrito);
			$totalCarrito = Modelo::getTotalCarrito($idCarrito);
			$logged = Controller::checkLog();
			$form = $app['form.factory']->createBuilder('form')
					->add("borrarLineas",'submit',array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
		        	$idLineas = $req->request->get('cb_borrarLineas');
		        	Modelo::borrarLineasCarrito($idLineas, $idCarrito);		        		
					return $app->redirect($app['url_generator']->generate('ver_carrito'));
		        }
		    }

			return $app['twig']->render('ver_carrito.twig', array(
				'logged' => $logged,
				'lineas' => $lineasCarrito,
				'totalCarrito' => $totalCarrito,
				'form' => $form->createView()
				)
			);
		}

		static function confirmaCompra(Request $req, Application $app){			
			$logged = Controller::checkLog();

			$cliente = Modelo::getDatosCliente($_SESSION['cliente']);

			$idCarrito = Modelo::getIdCarrito($_SESSION['cliente']);
			$totalCarrito = Modelo::getTotalCarrito($idCarrito);

			$datosBancUser = Modelo::getDatosBanc($_SESSION['cliente']);
			$fechCad = explode("-", $datosBancUser['fechaCaducidad']);

			$form = $app['form.factory']->createBuilder('form')			
					->add("cliente",'hidden',array())				
					->add("idCarrito",'hidden',array())				
					->add("totalCarrito",'hidden',array())
					->add("direccion",'text',array())						
			        ->add('numeroTarjeta','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{16}/',
				        		)
			        		)
			        	)
			        ))
			        ->add('CCV','text',array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/\d{3}/',
				        		)
			        		)
			        	)
			        ))
			        ->add("confirmar", "submit", array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$fechaCad = $req->request->get('selfechCadAnio') . '-' . $req->request->get('selfechCadMes') . '-01';

		        	$datosBanc = array(
		        		'email' => $data['cliente'],
		        		'numeroTarjeta' => $data['numeroTarjeta'],
		        		'CCV' => $data['CCV'],
		        		'fechaCad' => $fechaCad
		        	);

		        	$checkVacio = array_filter(Modelo::getDatosBanc($data['cliente']));

		        	if(empty($checkVacio)){		        		
						Modelo::addDatosBancarios($datosBanc);	
					}else{
						Modelo::modificaDatosBancarios($datosBanc);
					}

					Modelo::modificaDirEnvio($data['cliente'],$data['direccion']);

		        	if(Modelo::crearPedido($data)){
		        		Modelo::vaciarCarrito($data['idCarrito']);
						return $app->redirect($app['url_generator']->generate('ver_pedidos'));
					}else{
						return $app['twig']->render('operation.twig', array(
							'operation' => 'Error',
							'msg' => 'Ha ocurrido un error durante la confirmación de su pedido, inténtelo de nuevo.',
							'logged' => $logged
						));
					}

		        }
		    }

			return $app['twig']->render('confirma_compra.twig', array(
				'logged' => $logged,
				'totalCarrito' => $totalCarrito,
				'idCarrito' => $idCarrito,
				'datosBanc' => $datosBancUser,
				'fechCad' => $fechCad,
				'form' => $form->createView(),		
		    	'curYear' => date("Y"),		
				'cliente' => $cliente
				)
			);

		}

		static function verPedidos(Application $app){
			$logged = Controller::checkLog();
			$pedidos = Modelo::getPedidos($_SESSION['cliente']);			
			return $app['twig']->render('ver_pedidos.twig', array(
				'logged' => $logged,
				'pedidos' => $pedidos
				)
			);
		}

		static function verDetallesPedido(Request $req, Application $app, $id){
			$logged = Controller::checkLog();
			$lineasPedido = Modelo::getLineasPedido($id);
			$totalPedido = Modelo::getTotalPedido($id);
			$estado = Modelo::getEstadoDePedido($id);
			$form = $app['form.factory']->createBuilder('form')
					->add('idPedido','hidden',array())
					->add('obtenerRecibo','submit',array())
			        ->getForm();

			if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
		        	$html = Modelo::getHtmlRecibo($data['idPedido']);

				    $html2pdf = new HTML2PDF('P','A4','en');
				    $html2pdf->WriteHTML($html);
				    $nompdf = "recibo_Pedido_#" . $data['idPedido'] . ".pdf";
				    $html2pdf->Output($nompdf, 'D');
		        }
		    }


			return $app['twig']->render('detalle_pedido.twig', array(
				'logged' => $logged,
				'idPedido' => $id,
				'lineas' => $lineasPedido,
				'totalPedido' => $totalPedido,
				'estado' => $estado,
				'form' => $form->createView(),	
				'cliente' => $_SESSION['cliente']
				)
			); 
		}
	}
?>