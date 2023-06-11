<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Index', 'action' => 'index']);
$router->add('/', ['controller' => 'Index', 'action' => 'index']);
$router->add('rooms/load', ['controller' => 'Index', 'action' => 'roomsLoader']);
$router->add('rooms/load/calendar/{id:\d+}', ['controller' => 'Index', 'action' => 'loadCalendarToRoom']);
$router->add('application/post', ['controller' => 'Index', 'action' => 'applicationPost']);

$router->add('admin', ['controller' => 'Admin', 'action' => 'index']);
$router->add('admin/filter', ['controller' => 'Admin', 'action' => 'filter']);
$router->add('admin/application/accept/{id:\d+}', ['controller' => 'Admin', 'action' => 'accept']);
$router->add('admin/application/reject/{id:\d+}', ['controller' => 'Admin', 'action' => 'reject']);
$router->add('admin/rooms/delete/{id:\d+}', ['controller' => 'Admin', 'action' => 'delete']);
$router->add('admin/rooms/add', ['controller' => 'Admin', 'action' => 'add']);
$router->add('admin/rooms/edit', ['controller' => 'Admin', 'action' => 'edit']);

$router->dispatch($_SERVER['QUERY_STRING']);
