<?php
/**
 * Routes - all standard routes are defined here.
 *
 * @author David Carr - dave@daveismyname.com
 * @version 3.0
 */

/** Create alias for Router. */
use Core\Router;
use Helpers\Hooks;

/** Get the Router instance. */
$router = Router::getInstance();

/** Define static routes. */

// Default Routing
Router::any('admin', 'App\Controllers\Admin\Admin@index');
Router::any('admin/login', 'App\Controllers\Admin\Auth@login');
Router::any('admin/logout', 'App\Controllers\Admin\Auth@logout');

Router::any('admin/users', 'App\Controllers\Admin\Users@index');
Router::any('admin/users/add', 'App\Controllers\Admin\Users@add');
Router::any('admin/users/edit/(:num)', 'App\Controllers\Admin\Users@edit');

Router::any('admin/posts', 'App\Controllers\Admin\Posts@index');
Router::any('admin/posts/add', 'App\Controllers\Admin\Posts@add');
Router::any('admin/posts/edit/(:num)', 'App\Controllers\Admin\Posts@edit');
Router::any('admin/posts/delete/(:num)', 'App\Controllers\Admin\Posts@delete');

Router::any('admin/cats', 'App\Controllers\Admin\Cats@index');
Router::any('admin/cats/add', 'App\Controllers\Admin\Cats@add');
Router::any('admin/cats/edit/(:num)', 'App\Controllers\Admin\Cats@edit');
Router::any('admin/cats/delete/(:num)', 'App\Controllers\Admin\Cats@delete');


Router::any('', 'App\Controllers\Blog@index');
Router::any('category/(:any)', 'App\Controllers\Blog@cat');
Router::any('(:any)', 'App\Controllers\Blog@post');
/** End default routes */

/** Module routes. */
$hooks = Hooks::get();
$hooks->run('routes');
/** End Module routes. */

/** If no route found. */
Router::error('Core\Error@index');

/** Execute matched routes. */
$router->dispatch();
