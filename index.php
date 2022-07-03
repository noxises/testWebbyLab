<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
include 'autoload.php';
include 'config.php';
define('ROOT_FOLDER', realpath(__DIR__ . '/'));
session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

$router = new Router();
$router->get('/', 'MovieList::index');
$router->get('/movie/all', 'MovieList::index');
$movies = (new Movie())->all();
foreach ($movies as $one) {
    $router->get('/movie/' . $one['id'], 'MovieList::info');
}
$router->get('/movie/add', 'MovieList::addForm');
$router->post('/movie/create', 'MovieList::create');
$router->post('/movie/find', 'MovieList::findByTitle');
$router->post('/movie/savefromfile', 'MovieList::saveFromFile');
$router->post('/movie/delete', 'MovieList::delete');


$router->get('/login', 'Users::index');
$router->get('/registration', 'Users::registration');
$router->post('/registration/create', 'Users::create');
$router->post('/login/authorization', 'Users::login');
$router->get('/logout', 'Users::logout');


$router->check();
