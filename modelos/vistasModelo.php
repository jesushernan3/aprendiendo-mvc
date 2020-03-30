<?php 

  class vistasModelo  {
    protected function obtener_vistas_modelo($vistas)  {
      $listaBlanca=["admin", "admin-list", "adminsearch", "book-config", "book-info", "book", "catalog", "category", "category-list", "client-lis", "client-search", "client", "company-list", "company", "home", "my-account", "my-data", "provider", "provider-list", "search"];
      if (in_array($vistas, $listaBlanca)) {
        if (is_file("./vistas/contenidos/".$vistas."-view.php")) {
          $contenido="./vistas/contenidos".$vistas."-view.php";
        } else {
          $contenido="login";
        }
        
      } elseif ($vistas=="login") {
          $contenido="login";
      } elseif ($vistas=="index") {
        $contenido="login";
      } else {
        $contenido="login";
      }
        return $contenido;
    }
  }
  