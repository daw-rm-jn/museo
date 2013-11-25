<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
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
					$idPintores = $req->request->get('cb_borrar');
		        	Modelo::borrarCuadros($idPintores);
					return $app['twig']->render('/cuadros/del_cuadro.twig', array(
						'msgCabecera' => 'Entrada(s) borrada(s)',
						'msgoperacion' => 'Entrada(s) eliminada(s) del registro.',
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
			$pintores = Modelo::getNombresDePintores();
			$estilos = Modelo::getNombresDeEstilos();
			$expos = Modelo::getNombresDeExpos();
			$form = $app['form.factory']->createBuilder('form')
					->add('nombreCuadro', 'text', array())
					->add('descripcionCuadro', 'text', array())
					->add('fotoCuadro', 'file', array())
					->add('pintor', 'choice', array(
						'choices' => $pintores,
						'required' => false,
						)
					)
					->add('exposicion', 'choice', array(
						'choices' => $expos,
						'required' => false,
						)
					)
					->add('estilo', 'choice', array(
						'choices' => $estilos,
						'required' => false,
						)
					)
					->add('guardar', 'submit', array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();

		        	$files = $req->files->get($form->getName());
		            $path = __DIR__.'/../img/Cuadros/'.$data['nombreCuadro'];

		            $extension = $files['fotoCuadro']->guessExtension();
					if (!$extension) {
					    $extension = 'bin';
					}

					$filename = $data['nombreCuadro'].'.'.$extension;
					$files['fotoCuadro']->move($path, $filename);

					if(Modelo::addCuadro($data, $filename)){
						return $app['twig']->render('/cuadros/cuadro_added.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Añadida',
				    		'msgoperacion' => 'Cuadro añadido con éxito'
						));
					}else{
						return $app['twig']->render('/cuadros/cuadro_added.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada NO Añadida',
				    		'msgoperacion' => 'Error al añadir el cuadro.'
						));
					}
		        }
		    }

		    return $app['twig']->render('/cuadros/add_cuadro.twig', array(
		    	'form' => $form->createView(),
				'msgCabecera' => 'Añadir cuadro',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}
?>