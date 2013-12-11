<?php 
	require 'ListaClases.php';
	require 'ListaModelos.php';

	class Modelo{
		/*-----------------------------------------*/
		/*--- FUNCIONES DE LA PÁGINA PRINCIPAL ---*/
		/*---------------------------------------*/

		/*--- COMPRUEBA SI EL USUARIO ENVIADO ES ADMINISTRADOR ---*/
		static function isAdmin($datos){
			return Model_Misc::isAdmin($datos);
		}

		/*--- DEVUELVE TODAS LAS ACTUALIZACIONES ORDENADAS ---*/
		static function getUpdates(){
			return Model_Misc::getUpdates();
		}

		static function insertUpdate($descriptor){
			return Model_Misc::insertUpdate($descriptor);
		}

		/*-----------------------------*/
		/*---FUNCIONES DE PINTORES ---*/
		/*---------------------------*/

		/*--- DEVUELVE TODOS LOS PINTORES ---*/
		static function getPintores(){
			return Model_Pintores::getPintores();
		}

		/*--- DEVUELVE PINTOR CON ID INDICADA ---*/
		static function getPintorPorId($idPintor){
			return Model_Pintores::getPintorPorId($idPintor);
		}

		/*--- MODIFICA UN PINTOR ---*/
		static function modificaPintor($pintor, $descriptor){
			return Model_Pintores::modificaPintor($pintor, $descriptor);
		}

		/*--- ELIMINA UNO O MAS PINTORES ---*/
		static function borrarPintores($idPintores){
			return Model_Pintores::borrarPintores($idPintores);
		}

		/*--- AÑADE UN PINTOR ---*/
		static function addPintor($pintor, $descriptor){
			return Model_Pintores::addPintor($pintor, $descriptor);
		}

		/*-----------------------------*/
		/*--- FUNCIONES DE ESTILOS ---*/
		/*---------------------------*/

		/*--- DEVUELVE TODOS LOS ESTILOS ---*/
		static function getEstilos(){
			return Model_Estilos::getEstilos();
		}

		/*--- DEVUELVE ESTILO POR ID ---*/
		static function getEstiloPorId($idEstilo){
			return Model_Estilos::getEstiloPorId($idEstilo);
		}

		/*--- MODIFICA UN ESTILO ---*/
		static function modificaEstilo($estilo, $desc){
			return Model_Estilos::modificaEstilo($estilo, $desc);

		}

		/*--- ELIMINA UNO O MAS ESTILOS ---*/
		static function borrarEstilos($idEstilos){
			return Model_Estilos::borrarEstilos($idEstilos);
		}

		/*--- AÑADE UN ESTILO ---*/
		static function addEstilo($estilo, $desc){
			return Model_Estilos::addEstilo($estilo, $desc);
		}

		/*-----------------------------*/
		/*--- FUNCIONES DE CUADROS ---*/
		/*---------------------------*/

		/*--- DEVUELVE CUADRO CON ID INDICADA ---*/
		static function getDatosCuadro($id){
			return Model_Cuadros::getDatosCuadro($id);
		}

		/*--- DEVUELVE TODOS LOS CUADROS ---*/
		static function getCuadros(){
			return Model_Cuadros::getCuadros();
		}

		/*--- AÑADE UN CUADRO ---*/
		static function addCuadro($cuadro, $descriptor){
			return Model_Cuadros::addCuadro($cuadro, $descriptor);
		}

		/*--- MODIFICA UN CUADRO ---*/
		static function modificaCuadro($cuadro, $descriptor){
			return Model_Cuadros::modificaCuadro($cuadro, $descriptor);
		}

		/*--- DEVUELVE EL NOMBRE DE PINTOR DE UN CUADRO ---*/
		static function getPintordeCuadro($idPintorCuadro){
			return Model_Cuadros::getPintordeCuadro($idPintorCuadro);
		}

		/*--- ELIMINA UNO O MAS CUADROS ---*/
		static function borrarCuadros($idCuadros){
			return Model_Cuadros::borrarCuadros($idCuadros);
		}

		/*--- DEVUELVE EL NOMBRE DE ESTILO DE UN CUADRO ---*/
		static function getEstilodeCuadro($idEstiloCuadro){
			return Model_Cuadros::getEstilodeCuadro($idEstiloCuadro);

		}

		/*------------------------------------------*/
		/*--- FUNCIONES PERTENECIENTES AL MUSEO ---*/
		/*----------------------------------------*/

		/*--- DEVUELVE LAS EXPOSICIONES ---*/
		static function getExposiciones(){
			return Model_Museo::getExposiciones();
		}

		/*--- BORRA UNA O MÁS EXPOSICIONES ---*/
		static function borrarExposiciones($idExposiciones){
			return Model_Museo::borrarExposiciones($idExposiciones);
		}

		/*--- DEVUELVE UNA EXPOSICION CON UNA ID INDICADA ---*/
		static function getExposicionPorId($idExposicion){
			return Model_Museo::getExposicionPorId($idExposicion);
		}

		/*--- AÑADE UNA EXPOSICION ---*/	
		static function addExposicion($exposicion, $descriptor){
			return Model_Museo::addExposicion($exposicion, $descriptor);
		}

		/*--- MODIFICA UNA EXPOSICION ---*/
		static function modificaExpo($expo, $descriptor){
			return Model_Museo::modificaExpo($expo, $descriptor);
		}

		/*--- DEVUELVE LAS SALAS DEL MUSEO ---*/
		static function getSalas(){
			return Model_Museo::getSalas();
		}

		/*--- BORRA UNA O MÁS SALAS ---*/
		static function borrarSalas($idSalas){
			return Model_Museo::borrarSalas($idSalas);
		}

		/*--- AÑADE UNA SALA ---*/
		static function addSala($sala, $descriptor){
			return Model_Museo::addSala($sala, $descriptor);
		}

		/*--- MODIFICA UNA SALA ---*/
		static function modificaSala($sala, $descriptor){
			return Model_Museo::modificaSala($sala, $descriptor);
		}

		/*--- DEVUELVE UNA SALA CON ID INDICADA ---*/
		static function getSalaPorId($idSala){
			return Model_Museo::getSalaPorId($idSala);
		}

		/*--- DEVUELVE TODAS LAS PLANTAS DEL MUSEO ---*/
		static function getPlantas(){
			return Model_Museo::getPlantas();
		}

		/*--- BORRA UNA O MÁS PLANTAS ---*/
		static function borrarPlantas($idPlantas){
			return Model_Museo::borrarPlantas($idPlantas);
		}

		/*--- AÑADE UNA PLANTA ---*/
		static function addPlanta($planta){
			return Model_Museo::addPlanta($planta);
		}

		/*--- MODIFICA UNA PLANTA ---*/
		static function modificaPlanta($planta){
			return Model_Museo::modificaPlanta($planta);
		}

		/*--- DEVUELVE UNA PLANTA CON ID INDICADA ---*/
		static function getPlantaPorId($idPlanta){
			return Model_Museo::getPlantaPorId($idPlanta);
		}

		/*------------------------------*/
		/*--- FUNCIONES DE USUARIOS ---*/
		/*----------------------------*/

		/*--- CLIENTES ---*/
		static function getClientes(){
			return Model_Usuarios::getClientes();
		}

		static function getDatosBancarios($cliente){
			return Model_Usuarios::getDatosBancarios($cliente);
		}

		static function addCliente($cliente){
			return Model_Usuarios::addCliente($cliente);
		}

		static function borrarClientes($emailClientes){
			return Model_Usuarios::borrarClientes($emailClientes);
		}

		static function getClientePorId($email){
			return Model_Usuarios::getClientePorId($email);
		}

		static function modificaCliente($cliente){
			return Model_Usuarios::modificaCliente($cliente);
		}

		/*--- ADMINISTRADORES ---*/
		static function getAdmins(){
			return Model_Usuarios::getAdmins();
		}

		static function addAdmin($admin){
			return Model_Usuarios::addAdmin($admin);
		}

		static function borrarAdmins($emailAdmins){
			return Model_Usuarios::borrarAdmins($emailAdmins);
		}

		static function getAdminPorId($email){
			return Model_Usuarios::getAdminPorId($email);
		}

		static function modificaAdmin($admin){
			return Model_Usuarios::modificaAdmin($admin);
		}

		/*-------------------------------*/
		/*--- FUNCIONES DE LA TIENDA ---*/
		/*-----------------------------*/

		static function getCarritos(){
			return Model_Tienda::getCarritos();
		}

		static function addCarrito($carrito){
			return Model_Tienda::addCarrito($carrito);
		}

		static function modificaCarrito($carrito){
			return Model_Tienda::modificaCarrito($carrito);
		}

		static function borrarCarritos($idCarritos){
			return Model_Tienda::borrarCarritos($idCarritos);
		}

		static function borrarLineasCarrito($idLineas, $idCarrito){
			return Model_Tienda::borrarLineasCarrito($idLineas, $idCarrito);
		}

		static function modificaLineaCarrito($linea){
			return Model_Tienda::modificaLineaCarrito($linea);
		}

		static function getCarritoPorId($idCarrito){
			return Model_Tienda::getCarritoPorId($idCarrito);
		}

		static function getLineasCarrito($idCarrito){
			return Model_Tienda::getLineasCarrito($idCarrito);
		}

		static function getLineaCarritoPorId($id, $idLinea){
			return Model_Tienda::getLineaCarritoPorId($id, $idLinea);
		}

		static function addLineaCarrito($carrito){
			return Model_Tienda::addLineaCarrito($carrito);
		}

		static function getPedidos(){
			return Model_Tienda::getPedidos();
		}

		static function addPedido($pedido){
			Model_Tienda::addPedido($pedido);
		}

		static function borrarPedidos($idPedidos){
			return Model_Tienda::borrarPedidos($idPedidos);
		}

		static function borrarLineasPedido($idLineas, $idPedido){
			return Model_Tienda::borrarLineasPedido($idLineas, $idPedido);
		}

		static function modificaLineaPedido($linea){
			return Model_Tienda::modificaLineaPedido($linea);
		}

		static function getPedidoPorId($idPedido){
			return Model_Tienda::getPedidoPorId($idPedido);
		}

		static function getLineasPedido($idPedido){
			return Model_Tienda::getLineasPedido($idPedido);
		}

		static function getLineaPedidoPorId($id, $idLinea){
			return Model_Tienda::getLineaPedidoPorId($id, $idLinea);
		}

		static function addLineaPedido($pedido){
			return Model_Tienda::addLineaPedido($pedido);
		}

		static function modificaPedido($pedido, $descriptor){
			return Model_Tienda::modificaPedido($pedido, $descriptor);
		}

	}
?>