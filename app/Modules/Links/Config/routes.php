<?php

return [
    'GET /' => 'Links\Controllers\LinksController@index',
    'GET /links' => 'Links\Controllers\LinksController@list',
    'GET /links/create' => 'Links\Controllers\LinksController@create',
    'POST /links/create' => 'Links\Controllers\LinksController@store',
    'GET /links/{id}/edit' => 'Links\Controllers\LinksController@edit',
    'POST /links/{id}/edit' => 'Links\Controllers\LinksController@update',
    'POST /links/{id}/delete' => 'Links\Controllers\LinksController@delete',
    'GET /{code}' => 'Links\Controllers\LinksController@redirect'
];
