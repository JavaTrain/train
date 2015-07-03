<?php

namespace Core;

class Application{
	
	/**
	 * 
	 */
	public function __construct(){

        $config = new Config();
        $config ->loadConfig('config.yml');
        Service::set('config', $config);

        $request = new Request();
        Service::set('request', $request);

        $session = new Session();
        Service::set('session', $session);

        $routes = include('../config/routes.php');

        $router = new Router($routes);
        Service::set('router', $router);

        Service::set('pdo', new \PDO($config->getVal('mysql/type')
                        .':host=' . $config->getVal('mysql/host')
                        .';dbname=' . $config->getVal('mysql/db'),
                        $config->getVal('mysql/username'),
                        $config->getVal('mysql/pass'),
                        array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        ));

        $log = new Log(URL.'/logs/log.txt');
        Service::set('log', $log);

        Service::set('user', new User());

	}

    /**
     * Dispatch
     */
    public function run()
    {
        $config = Service::get('config');

        $request = Service::get('request');

        $route = Service::get('router')->find($request->getUrl());

        $user = Service::get('user')->getUser();

        if(empty($user) & !empty(Cookie::get($config->getVal('remember/cookie_name')))) {

            $user = Service::get('user');
            $user = $user->find();
        }

        if(empty($user)){
            if(!in_array($request->getUrl(), array('/login', '/auth', '/gate', '/register', '/reg'))){
                $response = new RedirectResponse('/gate');
                $response->send();
            }
        }

        if(!empty($route)){

            $controller_class = $route['controller'].'Controller';

            if(!class_exists($controller_class)){
                throw new \Exception("Controller class [" . $route['controller'] . "] doesn't exist");
            }

            $controller = new $controller_class();

            if(!method_exists($controller, $route['action'].'Action'))
                throw new \Exception("Method [" . $route['action'] . "Action ] doesn't exist in [" . $route['controller'] . "]");

            $action = $route['action'].'Action';

            $response = call_user_func_array(array($controller, $action), $route['params']);

            if($response->type == 'html'){
                $renderer = new Renderer(URL . '/src/template.php');
                $renderer->setVars(array(
                    'content' => $response->content
                ));

                $response->content = $renderer->render();
            }
            $response->send();
        }else{
            throw new \Exception("Wrong route [" . $request->getUrl() . "]");
        }
    }
}