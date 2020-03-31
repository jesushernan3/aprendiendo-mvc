<?php 

  class vistasModelo  {
    protected function obtener_vistas_modelo($vistas)  {

      $listaBlanca=[
        "admin", 
        "adminlist", 
        "adminsearch", 
        "bookconfig", 
        "bookinfo", 
        "book", 
        "catalog", 
        "category", 
        "categorylist", 
        "clientlist", 
        "clientsearch", 
        "client", 
        "companylist", 
        "company", 
        "home", 
        "myaccount", 
        "mydata", 
        "provider", 
        "providerlist", 
        "search"
      ];

      if (in_array($vistas, $listaBlanca)) {
        if (is_file("vistas/contenidos/".$vistas."-view.php")) {
          $contenido="vistas/contenidos/".$vistas."-view.php";
        } else {
          $contenido="login";
        }
      } elseif ($vistas=="login") {
          $contenido="login";
      } elseif ($vistas=="index") {
          $contenido="login";
      } else {
          $contenido="404";
      }
        return $contenido;
    }
  }