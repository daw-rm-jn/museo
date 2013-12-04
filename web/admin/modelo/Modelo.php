<?php 
	require 'ListaClases.php';
	require 'ListaModelos.php';

	class Modelo{
		/*-----------------------------------------*/
		/*--- FUNCIONES DE LA PÁGINA PRINCIPAL ---*/
		/*---------------------------------------*/

		/*--- COMPRUEBA SI EL SUSUARIO ENVIADO ES ADMINISTRADOR ---*/
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

		/*--- DEVULVE LA ID DE UN PINTOR ---*/
		static function getIdPintor($nombre){
			return Model_Pintores::getIdPintor($nombre);
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

		/*--- DEVUELVE LA ID DE UN ESTILO ---*/
		static function getIdEstilo($nombre){
			return Model_Estilos::getIdEstilo($nombre);
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
			return Model_Exposiciones::getExposiciones();
		}

		/*--- DEVULVE LA ID DE UNA EXPOSICION ---*/
		static function getIdExposicion($nombre){
			return Model_Exposiciones::getIdExposicion($nombre);
		}

		/*--- BORRA UNA O MÁS EXPOSICIONES ---*/
		static function borrarExposiciones($idExposiciones){
			return Model_Exposiciones::borrarExposiciones($idExposiciones);
		}

		/*--- DEVUELVE UNA EXPOSICION CON UNA ID INDICADA ---*/
		static function getExposicionPorId($idExposicion){
			return Model_Exposiciones::getExposicionPorId($idExposicion);
		}

		/*--- AÑADE UNA EXPOSICION ---*/	
		static function addExposicion($exposicion, $descriptor){
			return Model_Exposiciones::addExposicion($exposicion, $descriptor);
		}

		/*--- MODIFICA UNA EXPOSICION ---*/
		static function modificaExpo($expo, $descriptor){
			return Model_Exposiciones::modificaExpo($expo, $descriptor);
		}

		/*--- DEVUELVE LAS SALAS DEL MUSEO ---*/
		static function getSalas(){
			return Model_Salas::getSalas();
		}

		/*--- DEVUELVE TODAS LAS PLANTAS DEL MUSEO ---*/
		static function getPlantas(){
			return Model_Plantas::getPlantas();
		}

		/*--- BORRA UNA O MÁS PLANTAS ---*/
		static function borrarPlantas($idPlantas){
			return Model_Plantas::borrarPlantas($idPlantas);
		}

		static function addPlanta($planta){
			return Model_Plantas::addPlanta($planta);
		}

		/*--- MODIFICA UNA PLANTA ---*/
		static function modificaPlanta($planta){
			return Model_Plantas::modificaPlanta($planta);
		}

		static function getPlantaPorId($idPlanta){
			return Model_Plantas::getPlantaPorId($idPlanta);
		}
	}
?>