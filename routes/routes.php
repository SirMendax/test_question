<?php

//ROUTES FOR QUESTION
$router->get('/users/{user_id}/services/{service_id}/tarifs', 'TarifController@getTarifs');
$router->put('/users/{user_id}/services/{service_id}/tarif', 'ServiceController@updateWithUser');

////TEXT FOR QUESTION
//$router->get('', 'IndexController@index');
//
////CRUD
//$router->get('/users', 'UserController@index');
//$router->get('/users/{id}', 'UserController@show');
//$router->post('/users', 'UserController@store');
//$router->put('/users/{id}', 'UserController@update');
//$router->delete('/users/{id}', 'UserController@delete');
//
////CRUD
//$router->get('/tarifs', 'TarifController@index');
//$router->get('/tarifs/{id}', 'TarifController@show');
//$router->post('/tarifs', 'TarifController@store');
//$router->put('/tarifs/{id}', 'TarifController@update');
//$router->delete('/tarifs/{id}', 'TarifController@delete');
//
////CRUD
//$router->get('/services', 'ServiceController@index');
//$router->get('/services/{id}', 'ServiceController@show');
//$router->post('/services', 'ServiceController@store');
//$router->put('/services/{id}', 'ServiceController@update');
//$router->delete('/services/{id}', 'ServiceController@delete');
//
//$router->put('/users/{user_id}/services/{service_id}/tarifs', 'TarifController@update');


