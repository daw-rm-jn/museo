<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints as Assert;

class controladorPrincipal {

    public static function pintores(Application $app) {
        $pintores = Modelo::getPintores();
        return $app['twig']->render('pintores.twig', array(
                    'pintores' => $pintores));
    }

    public static function cuadros(Application $app) {
        $cuadros = Modelo::getCuadros();
        return $app['twig']->render('cuadros.twig', array(
                    'cuadros' => $cuadros));
    }

    public static function main(Application $app) {
$exposiciones = Modelo::getExposiciones();
       return $app['twig']->render('inicio.twig', array(
           'exposiciones' => $exposiciones));
    }

    static function pintoresBuscar(Request $req, Application $app) {
        $key = $req->request->get("pintorFormName");
        $select = $req->request->get("select");
        $pintores = Modelo::getPintorByName($key, $select);
        return $app['twig']->render('pintores.twig', array(
                    'pintores' => $pintores
        ));
    }
    static function cuadrosBuscar(Request $req, Application $app) {
        $key = $req->request->get("cuadroFormName");
        $select = $req->request->get("select");
        $cuadros = Modelo::getCuadroByName($key, $select);
        return $app['twig']->render('cuadros.twig', array(
                    'cuadros' => $cuadros
        ));
    }
}

?>