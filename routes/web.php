<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// Auth
$router->post('/auth/login', 'AuthController@login');

// GET Bioskop
$router->get('/bioskop', 'BioskopController@index');
$router->get('/bioskop/{id}', 'BioskopController@show');

// GET Jadwal Film
$router->get('/jadwal-film', 'JadwalFilmController@index');
$router->get('/jadwal-film/{id}', 'JadwalFilmController@show');

// Endpoint yang membutuhkan Basic Auth
$router->group(['middleware' => 'basic.auth'], function () use ($router) {

    // CRUD Bioskop
    $router->post('/bioskop', 'BioskopController@store');
    $router->put('/bioskop/{id}', 'BioskopController@update');
    $router->delete('/bioskop/{id}', 'BioskopController@destroy');

    // CRUD Jadwal Film
    $router->post('/jadwal-film', 'JadwalFilmController@store');
    $router->put('/jadwal-film/{id}', 'JadwalFilmController@update');
    $router->delete('/jadwal-film/{id}', 'JadwalFilmController@destroy');
});