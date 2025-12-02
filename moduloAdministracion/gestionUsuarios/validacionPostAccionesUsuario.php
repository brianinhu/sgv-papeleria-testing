<?php
require_once "controllerGestionUsuarios.php";
require_once "panelGestionUsuarios.php";
$controller = new ControllerGestionUsuarios();
$objPanelGestionUsuarios = new PanelGestionUsuarios();
$usuarios = $controller->obtenerUsuarios();
$objPanelGestionUsuarios->mostrarPanel($usuarios);
