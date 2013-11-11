<?php 
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Silex\Application;
	use Silex\Provider\FormServiceProvider;
	use Symfony\Component\Validator\Constraints as Assert;

	class controlPintor{
		public function verPintores(Application $app){
			$pintores = Modelo::getPintores();
			return $app ['twig']->render('/pintores/ver_pintores.twig', array(
				'pintores' => $pintores,
				'msgCabecera' => 'Administración de pintores',
				'sessionId' => $_SESSION['admin']
				)
			);
		}

		public function verFichaPintor(Request $req, Application $app, $id){
			$pintores = Modelo::getPintorPorId($id);
			$form = $app['form.factory']->createBuilder('form')
					->add('idPintor', 'hidden', array())
			        ->add('nombrePintor', "text", array())
			        ->add('fechaNacimiento', "text",  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fechaMuerte', "text",  array(
			        	'constraints' => array(
			        		new Assert\Regex(array(
            					'pattern' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
				        		)
			        		)
			        	)
			        ))
			        ->add('fotoPintor', "text", array())
			        ->getForm();

		   if ('POST' == $req->getMethod()) {
		        $form->bind($req);

		        if ($form->isValid()) {
		        	$data = $form->getData();
					if(Modelo::modificaPintor($data)){
		        		Modelo::modificaPintor($data);
						return $app['twig']->render('/pintores/mod_pintor.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Modificada',
				    		'msgoperacion' => 'Pintor modifiado con éxito'
						));
					}else{
						return $app['twig']->render('/pintores/mod_pintor.twig', array(
				    		'sessionId' => $_SESSION['admin'],
				    		'msgCabecera' => 'Entrada Modificada',
				    		'msgoperacion' => 'Error al modificar el pintor.'
						));
					}
		        }
		    }

		    return $app['twig']->render('/pintores/ficha_pintor.twig', array(
		    	'form' => $form->createView(),
		    	'pintores' => $pintores,
				'msgCabecera' => 'Ficha de pintor',
				'sessionId' => $_SESSION['admin']
		    	)
		    );
		}
	}
?>