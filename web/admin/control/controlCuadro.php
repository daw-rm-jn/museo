<?php 
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlCuadro{
		static function verCuadros(Request $req, Application $app){
			$cuadros = Modelo::getCuadros();
			$form_borrar = $app['form.factory']->createBuilder('form')
					->add('Borrar', 'submit', array())
					->getForm();

			if ('POST' == $req->getMethod()) {
		        $form_borrar->bind($req);
		        if ($form_borrar->isValid()) {
		        	$data = $form_borrar->getData();
					$idCuadros = $req->request->get('cb_borrar');
		        	Modelo::borrarCuadros($idCuadros);
					return $app['twig']->render('mod.twig', array(
						'msgCabecera' => 'Operación correcta',
						'titulo' => 'Entrada(s) eliminada(s)',
						'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
						'seccion' => 'cuadros',
						'sessionId' => $_SESSION['admin']
				    	)
				    );
		        }
		    }

			return $app ['twig']->render('/cuadros/ver_cuadros.twig', array(
		    	'form' => $form_borrar->createView(),
				'cuadros' => $cuadros,
				'msgCabecera' => 'Administración de cuadros',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		static function addCuadro(Request $req, Application $app){
			$pintores = Modelo::getPintores();
			$estilos = Modelo::getEstilos();
			$expos = Modelo::getExposiciones();
			$form = $app['form.factory']->createBuilder('form')
					->add('nombreCuadro', 'text', array())
					->add('fotoCuadro', 'file', array())
					->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {

		        	$data = $form->getData();

		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../../img/cuadros/'.$data['nombreCuadro'];

		            $extension = $files['fotoCuadro']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombreCuadro'].'.'.$extension;
					$files['fotoCuadro']->move($path, $filename);

		        	$descriptor = array(
		        		'pintor' => $req->request->get('selpintores'),
		        		'estilo' => $req->request->get('selestilos'),
		        		'expo' => $req->request->get('selexpos'),
		        		'descripcion' => $req->request->get('descCuadro'),
		        		'foto' => $filename
		        	);

					if(Modelo::addCuadro($data, $descriptor)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada Añadida',
				    		'msgoperacion' => 'Cuadro añadido con éxito',
				    		'seccion' => 'cuadros'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al insertar el registro Cuadro',
				    		'seccion' => 'cuadros'
						));
					}
		        }
		    }

		    return $app['twig']->render('/cuadros/add_cuadro.twig', array(
		    	'form' => $form->createView(),
		    	'pintores' => $pintores,
		    	'estilos'=> $estilos,
		    	'exposiciones' => $expos,
				'msgCabecera' => 'Añadir cuadro',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
		static function verFichaCuadro(Request $req, Application $app, $id){
			$cuadro = Modelo::getCuadroPorId($id);
			$foto = MOdelo::getFoto($id);
			$pintores = Modelo::getPintores();
			$estilos = Modelo::getEstilos();
			$expos = Modelo::getExposiciones();
			$form = $app['form.factory']->createBuilder('form')
					->add('nombreCuadro', 'text', array())
					->add('fotoCuadro', 'file', array())
					->add('guardar', 'submit', array())
			        ->getForm();

		   /*if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        $files = $req->files->get($form->getName());
		            $path = __DIR__.'/../../img/pintores/'.$data['nombrePintor'];

		            $extension = $files['fotoPintor']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombrePintor'].'.'.$extension;
					$files['fotoPintor']->move($path, $filename);

					$descriptor = array(
						'bio' => $req->request->get('bioPintor'),
						'foto' => $filename
					);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaPintor($data, $descriptor)){
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Operación correcta',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada modificada',
				    		'msgoperacion' => 'Pintor modificado con éxito',
				    		'seccion' => 'pintores'
						));
					}else{
						return $app['twig']->render('mod.twig', array(
							'msgCabecera' => 'Error',
				    		'sessionId' => $_SESSION['admin'],
				    		'titulo' => 'Entrada NO modificada',
				    		'msgoperacion' => 'Error al modificar el registro Pintor',
				    		'seccion' => 'pintores'
						));
					}
		        }
		    }*/
			return $app['twig']->render('foto.twig', array(
				'foto' => $foto,
				'msgCabecera' => 'Ficha de cuadro',
				'sessionId' => $_SESSION['admin']
		    	)
		    );/*
		    return $app['twig']->render('/cuadros/ficha_cuadro.twig', array(
		    	'form' => $form->createView(),
		    	'cuadro' => $cuadro,
		    	'pic' => $cuadro->getfotoCuadro(),
		    	'pintores' => $pintores,
		    	'estilos'=> $estilos,
		    	'exposiciones' => $expos,
				'msgCabecera' => 'Ficha de cuadro',
				'sessionId' => $_SESSION['admin']
		    	)
		    );*/
		}
	}
?>