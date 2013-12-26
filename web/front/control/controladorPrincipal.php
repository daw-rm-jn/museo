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

        if (isset($_SESSION['user'])) {
            return $app['twig']->render('inicio.twig', array('session' => $_SESSION['user']));
        } else {
            return $app['twig']->render('inicio.twig', array());
        }
    }

    static function pintoresBuscar(Request $req, Application $app) {
        $key = $req->request->get("pintorFormName");
        $pintores = Modelo::getPintorByName($key);
        return $app['twig']->render('pintores.twig', array(
                    'pintores' => $pintores
        ));
    }
    static function cuadrosBuscar(Request $req, Application $app) {
        $key = $req->request->get("cuadroFormName");
        $cuadros = Modelo::getCuadroByName($key);
        return $app['twig']->render('cuadros.twig', array(
                    'cuadros' => $cuadros
        ));
    }
}

?>