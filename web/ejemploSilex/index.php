<?php
/**
 * El .htaccess que hay en la carpeta sirve para eliminar "index.php" de la URL, así queda más limpio.
 * 
 * 
 * Este es el principcio. En silex, el index tiene unas pocas lineas y lo que hace normalmente
 * es cargar el framework y el enrutador/controlador, que tiene una pinta como esta.
 * Aquí usaré el propio index como enrutador/controlador, y seguramente en la aplicacón del museo también.
 * */
require_once __DIR__.'/../../vendor/autoload.php'; //Primero cargamos Silex
require __DIR__.'/modelo/Modelo.php'; //Capa de abstracción, que hará las conexiones a la BD y devolverá los datos.

/**
 * "Importamos" el componente Request de Symfony, que viene a ser como el de Java. 
 * También esta el Response, claro, que habrá que usar en el proyecto.
 * */
use Symfony\Component\HttpFoundation\Request; 

$app = new Silex\Application(); //Inicializamos Silex en la variable $app;
$app['debug'] = true; //Activamos el modo depuración, así si hay un error de Silex éste dará información más detallada del mismo.

/**
 * Inicializamos los providers de Twig para las plantillas y UrlGenerator para las redirecciones.
 * */

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/vistas' //Le indicamos en qué directorio se almacenarán las vistas.
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


/**
 * Y ya empezamos con los enrutamientos. En Silex, la primera coincidencia que se encuentra es la que se lanza,
 * por eso es mejor colocarlas 'de abajo a arriba', poniendo las más genéricas al final. De ahí que "/", que sería la
 * principal, esté la última.
 * IMPORTANTE .- $app->get() no significa que la petición se esté haciendo con el método GET,
 * significa que está montando la página recogiendo datos del servidor. el método se puede especificar al final de la sentencia.
 * A $app->get() se le pasa una función anónima que es la que determinará qué hacer cuando esa ruta aparezca en la barra de direcciones.
 * A este función anónima se le pueden pasar parámetros, como una parte dinámica de la ruta (que está entre {}) o los objetos Request/Response.
 * Después, lo de "use ($app)" es solo para poder acceder a la varibale $app desde la función anónima.
 * */

/**
 * 5.- La última es "/blog/nuevo_post", que procesa los datos enviados desde "/blog/nuevo".
 * Recogemos los atributos mandados desde el formulario con el objeto $request y los almacenamos en variables.
 * Después llamamos al método addPost() del Modelo y si la inserción se efectúa redirigimos a "/blog", donde
 * se mostrará otra vez la lista de posts con el recién añadido.
 * Al final de la sentencia especificamos que se está ejecutando el método POST con method().
 * */
$app->get('/blog/nuevo_post',function(Request $request) use($app){
	$titulo = $request->request->get("titulo");
	$autor = $request->request->get("autor");
	$fecha = $request->request->get("fecha");
	$cuerpo = $request->request->get("cuerpo");
	if(Modelo::addPost($titulo, $autor, $cuerpo, $fecha)){
		return $app->redirect($app['url_generator']->generate('blog'));
	}else{
		return $app['twig']->render('error.twig', array(
			'msgerror' => 'ERROR AL INSERTAR POST'
			));
	}
})->method('POST');

/**
 * 4.- "/blog/nuevo" cargará un formulario para insertar un nuevo post en la BD.
 * Así que lo único que hacemos es cargar la vista del formulario con Twig.
 * */
$app->get('/blog/nuevo', function() use ($app){
	return $app['twig']->render('form.twig', array());
});

/**
 * 3.- Esto es un enrutado dinámico, aquí el valor de {id} es variable. 
 * En este caso lo que hace es cargar el contendio del post cuyo id de post coincida con {id}
 * Después se le pasa como parámetro a la función anónima, para terminar pasándolo al metodo verPost() del Modelo.
 * Lo que devuelva este método lo almacenamos en la variable $post.
 * Por último, dependiendo del valor de $post cargamos la vista del post en cuestión o la de mensaje de error.
 * */
$app->get('/blog/{id}', function($id) use ($app){
	$post = Modelo::verPost($id);
	if(!$post){
		return $app['twig']->render('error.twig', array(
			'msgerror' => 'NO RESULTS'
			));
	}else{
		return $app['twig']->render('post.twig', array(
			'post' => $post
		));	
	}
	
});
/**
 * 2.- "/blog" muestra una lista de los psot dentro de la BD, aquí ya cargamos una vista con el método render().
 * Con poner el nombre basta, ya que está en la misma carpeta que especificamos al cargar Twig.
 * A la vista se le pasa un array asociativo. Después, en la vista, podremos acceder a cada elemento del array poniendo el nombre.
 * Al final, con el metodo bind() le ponemos un alias a "/blog" para las redirecciones.
 * */
$app->get('/blog', function() use ($app){
	$listaPosts = Modelo::getListaPosts();
	return $app['twig']->render('blog.twig', array(
		'posts' => $listaPosts,
		'titulo' => 'Lista de Posts'
		));
})->bind('blog');

/**
 * 1.- La raíz, en esta app, como no tenemos una página de inicio, redireccionamos esta ruta a "/blog"
 * En el método redirect llamamos al UrlGeneratorProvider, y usamos el método generate() de éste para que genere la URL
 * con el argumento que le pasamos, en este caso el alias "blog" que tenemos puesto en la ruta "/blog".
 * */
$app->get('/',function() use($app) {
	return $app->redirect($app['url_generator']->generate('blog')); 
});

$app->run(); //Arrancamos la aplicación.
