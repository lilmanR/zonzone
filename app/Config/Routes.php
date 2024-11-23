<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */$routes->get('/', 'PostController::index', ['filter' => 'auth']);

$routes->get('/login', 'Auth::login');
$routes->post('/auth/processLogin', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'PostController::index', ['filter' => 'auth']);
$routes->post('/post/createPost', 'PostController::createPost');
$routes->get('/notifications', 'PostController::getNotifications');
$routes->get('/post/comments/(:num)', 'PostController::getPostComments/$1'); // Route untuk mengambil komentar
$routes->post('/post/addComment', 'PostController::addComment'); // Route untuk menambahkan komentar
$routes->post('/post/addReply', 'PostController::addReply');
$routes->post('/notifications/markAsRead', 'PostController::markAsRead');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/processRegister', 'Auth::processRegister');
// Rute untuk menandai notifikasi sebagai sudah dibaca dan menampilkan komentar terkait
$routes->get('/post/markNotificationAndShowComments/(:num)', 'PostController::markNotificationAndShowComments/$1');
// Rute untuk menandai semua notifikasi sebagai sudah dibaca
$routes->post('/post/markNotificationsAsRead', 'PostController::markNotificationsAsRead');

$routes->get('/user/profile', 'UserController::profile');
$routes->post('/user/updateProfilePicture', 'UserController::updateProfilePicture');
