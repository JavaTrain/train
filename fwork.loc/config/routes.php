<?php

return array(
    array(
        'pattern' => '/changepassword',
        'controller' => 'Users\Controller\User',
        'action' => 'changepassword'
    ),
    array(
        'pattern' => '/change',
        'controller' => 'Users\Controller\User',
        'action' => 'change'
    ),
    array(
        'pattern' => '/profile',
        'controller' => 'Users\Controller\User',
        'action' => 'profile'
    ),
    array(
        'pattern' => '/gate',
        'controller' => 'Users\Controller\User',
        'action' => 'gate'
    ),
    array(
        'pattern' => '/reg',
        'controller' => 'Users\Controller\User',
        'action' => 'reg'
    ),
    array(
        'pattern' => '/register',
        'controller' => 'Users\Controller\User',
        'action' => 'register'
    ),
    array(
        'pattern' => '/logout',
        'controller' => 'Users\Controller\User',
        'action' => 'logout'
    ),
    array(
        'pattern' => '/login',
        'controller' => 'Users\Controller\User',
        'action' => 'login'
    ),
    array(
        'pattern' => '/auth',
        'controller' => 'Users\Controller\User',
        'action' => 'auth'
    ),
    array(
        'pattern' => '/users',
        'controller' => 'Users\Controller\User',
        'action' => 'default'
    ),
    array(
        'pattern' => '/',
        'controller' => 'Users\Controller\User',
        'action' => 'index'
    ),
    array(
        'pattern' => '/ajax',
        'controller' => 'Users\Controller\User',
        'action' => 'ajax'
    ),
    array(
        'pattern' => '/add/{action}',
        'controller' => 'Users\Controller\User',
        'action' => 'add'
    ),
    array(
        'pattern' => '/create',
        'controller' => 'Users\Controller\User',
        'action' => 'create'
    ),
    array(
        'pattern' => '/del/{id}',
        'controller' => 'Users\Controller\User',
        'action' => 'delete',
        'requirements' => array(
            'id'=>'\d+'
        )
    ),
    array(
        'pattern' => '/edit/{id}/{action}',
        'controller' => 'Users\Controller\User',
        'action' => 'edit',
        'requirements' => array(
            'id'=>'\d+'
        )
    ),
    array(
        'pattern' => '/update',
        'controller' => 'Users\Controller\User',
        'action' => 'update'
    ),
    array(
        'pattern' => '/error',
        'controller' => 'Users\Controller\User',
        'action' => 'error'
    )
);