<?php

//On doit inclure tous les Controllers dont on veut disposer
require_once 'app/Controllers/Home.php';

//On définit nos routes
$routes = [
  '/' => ['Home','index'],
  '/articles/add' => ['Home','add']
];

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //on récupère l'URL

if(key_exists($path, $routes)) { //On regarde si l'url existe dans le tableau $routes

  $controller_name = $routes[$path][0]; //on récupère le nom du Controller
  $action_name = $routes[$path][1]; //on récupère le nom de l'action

  $controller = new $controller_name; //on instancie le Controller
  $controller->$action_name(); //on appelle la fonction correspondante
}
else {
  http_response_code(404);
  echo 'page non trouvée';
}

