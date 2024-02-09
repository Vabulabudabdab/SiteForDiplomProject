<?php
if( !session_id() ) {session_start();}

require "../vendor/autoload.php";

use Aura\SqlQuery\QueryFactory;
use DI\ContainerBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;
use App\QueryBuilder;
$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    Engine::class => function () {
        return new Engine('../app/Views');
    },
    PDO::class => function () {
        $driver = "mysql";
        $host = "localhost";
        $database_name = "OOPDiplom";
        $username = "root";
        $password = "";

        return new PDO("$driver:host=$host; dbname=$database_name", $username, $password);

    },

    Auth::class => function ($container) {
        return new Auth($container->get('PDO'));
    },

//    App\QueryBuilder::class => function() {
//      return new App\QueryBuilder();
//    }


]);

$container = $containerBuilder->build();


$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    //Здесь всё то, что рендерится, front
    $r->addRoute('GET', '/register', ['App\Controllers\HomeController', 'register']);
    $r->addRoute('GET', '/login', ['App\Controllers\HomeController', 'login']);
    $r->addRoute('GET', '/users', ['App\Controllers\HomeController', 'users']);
    $r->addRoute('GET', '/addUser', ['App\Controllers\HomeController', 'addUser']);
    $r->addRoute('GET', '/users/media', ['App\Controllers\HomeController', 'media']);
    $r->addRoute('GET', '/logout', ['App\Controllers\HomeController', 'logout']);
    $r->addRoute('GET', '/delete', ['App\Controllers\HomeController', 'delete']);
    $r->addRoute('GET', '/users/status', ['App\Controllers\HomeController', 'setStatus']);
    $r->addRoute('GET', '/users/security', ['App\Controllers\HomeController', 'userSecurity']);
    $r->addRoute('GET', '/users/edit', ['App\Controllers\HomeController', 'editUser']);
    $r->addRoute('GET', '/users/profile', ['App\Controllers\HomeController', 'profile']);
    //Обработчики, ещё не умею с ними работать нормально, поэтому делаю так. Здесь back
    //Только потом я понял, что могу всё это закинуть в 1 файл, но ради экономии времени не стал переделывать, ибо очень долго
    $r->addRoute('GET', '/Controllers/MediaController.php', ['App\Controllers\MediaController', 'media']);
    $r->addRoute("POST", '/Controllers/RegisterUser.php', ['App\Controllers\RegisterUser', 'registerUser']);
    $r->addRoute('POST', '/Controllers/LoginUser.php', ['App\Controllers\LoginUser', 'loginUser']);
    $r->addRoute('POST', '/Controllers/AddUserController.php', ['App\Controllers\AddUserController', 'addUser']);
    $r->addRoute('POST', '/Controllers/MediaController.php', ['App\Controllers\MediaController', 'media']);
    $r->addRoute('GET', '/Controllers/SetUserStatus.php', ['App\Controllers\SetUserStatus', 'setStatus']);
    $r->addRoute("POST", '/Controllers/UserSecurity.php', ['App\Controllers\UserSecurity', 'edit']);
    $r->addRoute("GET", '/Controllers/UserEdit.php', ['App\Controllers\UserEdit', 'edit']);

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "error 404?..";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed\
        echo "Method not allow, try chainged link or check your code - 405";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($routeInfo[1], $routeInfo[2]);
        break;
}