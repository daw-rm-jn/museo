<?php

require 'ListaModelos.php';

class Modelo {

    static function abrirConexion() {
        $host = 'localhost';
        $usuario = 'root';
        $clave = 'root';

        try {
            $con = new PDO("mysql:host=$host;dbname=bd_Museo;charset=utf8", $usuario, $clave);
            return $con;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getPintores() {
        $pintores = array();
        $con = Modelo::abrirConexion();
        $query = "SELECT * FROM Pintor ORDER BY nombrePintor ASC";
        $res = $con->query($query);

        foreach ($res as $row) {
            $pintor = new Pintor($row['idPintor'], $row['nombrePintor'], $row['bioPintor'], $row['fechaNacimiento'], $row['fechaMuerte'], $row['fotoPintor']);
            $pintores[] = $pintor;
        }
        return $pintores;
        $con = null;
    }

    public static function getCuadros() {
        $cuadros = array();
        $con = Modelo::abrirConexion();
        $query = "SELECT * FROM Cuadro ORDER BY nombreCuadro ASC";
        $res = $con->query($query);

        foreach ($res as $row) {
            $cuadro = new Cuadro($row['idCuadro'],$row['idPintor'],$row['idExposicion'],$row['idEstilo'],$row['nombreCuadro'],$row['descripcionCuadro'],$row['orientacion'],$row['anioCuadro'],$row['fotoCuadro']);
            $cuadros[] = $cuadro;
        }
        return $cuadros;
        $con = null;
    }
    
    public static function getExposiciones() {
        $exposiciones = array();
        $con = Modelo::abrirConexion();
        $query = "SELECT * FROM Exposicion";
        $res = $con->query($query);

        foreach ($res as $row) {
            $exposicion = new Exposicion($row['idExposicion'], $row['idSala'], $row['nombreExposicion'], $row['fechaInicio'], $row['fechaFin'], $row['descripcionExpo'], $row['cartel']);
            $exposiciones[] = $exposicion;
        }
        return $exposiciones;
        $con = null;
    }

    static function getPintorByName($nombrePintor) {
        $pintores = array();
        $con = Modelo::abrirConexion();
        $stmt = $con->prepare("SELECT * FROM Pintor WHERE nombrePintor LIKE ?");
        $stmt->bindValue(1, "%$nombrePintor%", PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $pintor = new Pintor($row['idPintor'], $row['nombrePintor'], $row['bioPintor'], $row['fechaNacimiento'], $row['fechaMuerte'], $row['fotoPintor']);
            $pintores[] = $pintor;
        }
        return $pintores;
        $con = null;
    }

    static function getCuadroByName($nombreCuadro) {
        $cuadros = array();
        $con = Modelo::abrirConexion();
        $stmt = $con->prepare("SELECT * FROM Cuadro WHERE nombreCuadro LIKE ?");
        $stmt->bindValue(1, "%$nombreCuadro%", PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $cuadro = new Cuadro($row['idCuadro'], $row['idPintor'], $row['idExposicion'], $row['idEstilo'], $row['nombreCuadro'], $row['descripcionCuadro'], $row['fotoCuadro'], $row['foto']);
            $cuadros[] = $cuadro;
        }
        return $cuadros;
        $con = null;
    }

}

?>