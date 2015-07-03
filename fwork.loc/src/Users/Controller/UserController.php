<?php
namespace Users\Controller;

use Core\Service;
use Users\Models\User as Model;
use Core\Response;
use Core\RedirectResponse;
use Core\Renderer;
use Core\Controller as Base;

class UserController extends Base{

    public function defaultAction(){

        $mod = new Model();

        $list = $mod->getList();

        $renderer = new Renderer($this->getView('default'));

        $renderer->setVars(array(
            'list' => $list
        ));

        return new Response($renderer->render());
    }

    public function indexAction(){

        $mod = new Model();

        $list = $mod->getList();

        $renderer = new Renderer($this->getView('index'));

        $renderer->setVars(array(
            'list' => $list
        ));

        return new Response($renderer->render());
    }

    public function ajaxAction(){

        $mod = new Model();

        $list = $mod->getList($_POST['role'], $_POST['course']);

        $renderer = new Renderer($this->getView('ajx'));

        $renderer->setVars(array(
            'list' => $list
        ));

        return new Response($renderer->render(), 200, 'success', 'json');
    }

    public function changepasswordAction(){

        $renderer = new Renderer($this->getView('changepassword'));

        return new Response($renderer->render());
    }

    public function changeAction(){

        $user = Service::get('user');

        $user->changepass($_POST);

        $ref = new RedirectResponse('/');
        $ref->send();
    }

    public function profileAction(){

        $user = Service::get('user')->user;

        if(empty($user)) {

            $ref = new RedirectResponse('/');
            $ref->send();
        }

        $renderer = new Renderer($this->getView('profile'));

        $renderer->setVars(array(
            'user' => $user
        ));

        return new Response($renderer->render());

    }

    public function logoutAction(){

        $user = Service::get('user');

        $user->logout($user->user->id);

        $ref = new RedirectResponse('/');
        $ref->send();
    }

    public function gateAction(){

        $user = Service::get('user')->getUser();

        if(empty($user)){
            $renderer = new Renderer($this->getView('gate'));
            return new Response($renderer->render());
        }else{
            $ref = new RedirectResponse('/');
            $ref->send();
        }

    }

    public function loginAction(){

        $user = Service::get('user')->getUser();

        if(empty($user)){
            $renderer = new Renderer($this->getView('login'));
            return new Response($renderer->render());
        }else{
            $ref = new RedirectResponse('/');
            $ref->send();
        }

    }

    public function authAction(){

        $user = Service::get('user');

        $user->authorize($_POST['login'], $_POST['password'], $_POST['remember']);

        return new RedirectResponse('/', 303);
    }

    public function registerAction(){

        $user = Service::get('user')->getUser();

        if(empty($user)){
            $renderer = new Renderer($this->getView('register'));
            return new Response($renderer->render());
        }else{
            $ref = new RedirectResponse('/');
            $ref->send();
        }

    }

    public function regAction(){

        $user = Service::get('user');

        $user->save($_POST);

        return new RedirectResponse('/', 303);
    }

    public function addAction($action){

        $renderer = new Renderer($this->getView('form'));

        $renderer->setVars(array(
            'action' => $action
        ));

        return new Response($renderer->render());
    }

    public function createAction(){

        $mod = new Model();

        $id = $mod->createStud();

        $mod->addCourse($id);

        $ref = new RedirectResponse('/');
        $ref->send();
    }

    public function deleteAction($id){

        $mod = new Model();

        $mod->delUser($id);

        $ref = new RedirectResponse('/');
        $ref->send();
    }

    public function editAction($id,$action){

        $mod = new Model();

        $data = $mod->singleUser($id);

        $renderer = new Renderer($this->getView('form'));

        $renderer->setVars(array(
            'action' => $action,
            'data' => $data
        ));

        return new Response($renderer->render());
    }

    public function updateAction(){

        $mod = new Model();

        $mod->updateUser($_POST);

        $ref = new RedirectResponse('/');
        $ref->send();
    }

    public function errorAction(){

        $renderer = new Renderer($this->getView('error'));

        return new Response($renderer->render());
    }


}