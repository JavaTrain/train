<?php

namespace Core;

class User implements UserInterface{

    public $user = null;


    public function authorize($login, $password, $remember)
    {
        $config = Service::get('config');
        $db = Service::get('pdo');

        $query = $db->prepare(
            "SELECT * FROM `user` WHERE `email`= :email AND `password`= :password"
        );

        $query->execute(array(
            ':email' => $login,
            ':password' => md5($password)
        ));

        $user = $query->fetchObject();

        $userid = $user->id;

        if($user->password === md5($password)) {

            if ($remember === 'on') {

                $hash = hash('sha256', uniqid());

                $hashcheck = $user->hash;

                if (!$hashcheck) {

                    $query = $db->prepare(
                        "UPDATE `user` SET `hash` = :hash WHERE `id` = :id");

                    $query->execute(array(
                        ':hash' => $hash,
                        ':id' => $userid
                    ));
                } else {
                    $hash = $user->hash;
                }


                Cookie::put($config->getVal('remember/cookie_name'), $hash, $config->getVal('remember/cookie_expiry'));
            }

            if ($userid) {
                $this->user = $user;

                $session = Service::get('session');
                $session->set($config->getVal('session/session_name'), $userid);
            }

            return $userid;
        }
    }

    public function getUser(){

        if(empty($this->user)){
            $db = Service::get('pdo');
            $session = Service::get('session');
            $config = Service::get('config');
            if($userid = $session->get($config->getVal('session/session_name'))){
                $query = $db->prepare("SELECT * FROM `user` WHERE `id`= :id");
                $query->bindParam(':id', $userid);

                $query->execute();
                $this->user = $query->fetchObject();
            }
        }

        return $this->user;
    }

    public function save($data){
        try {
            $db = Service::get('pdo');
            $sql = 'INSERT INTO `user`
                    (`name`, `role`, `email`,`password`)
                    VALUES (:name, :role, :email, :password)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':role', $data['role']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', md5($data['password']));
            $stmt->execute();
        }catch(\PDOException $e){
            echo $e->getMessage();die;
        }
    }

    public function logout($id){

            $db = Service::get('pdo');

            $sql = "UPDATE `user` SET
                    `hash` = :hash
                    WHERE `id` = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute(array(
                ':hash' => "",
                ':id' => $id,
            ));

        $config = Service::get('config');
        Cookie::delete($config->getVal('remember/cookie_name'));
        $session = Service::get('session');
        $session->delete($config->getVal('session/session_name'));
    }

    public function find(){

        $config = Service::get('config');
        $hash = Cookie::get($config->getVal('remember/cookie_name'));

        $db = Service::get('pdo');
        $query = $db->prepare(
            "SELECT * FROM `user` WHERE `hash` = :hash"
        );

        $query->execute(array(
            ':hash' => $hash
        ));

        $this->user = $query->fetchObject();

        $config = Service::get('config');
        $session = Service::get('session');
        $session->set($config->getVal('session/session_name'), $this->user->id);
        return $this->user;
    }

    public function changepass($data){

            $db = Service::get('pdo');
            if($this->user->password == md5($data['password_current'])){
                $query = $db->prepare("UPDATE `user` SET
                                        `password` = :pass
                                        WHERE `id` = :id");
                $query->bindParam(':id', $this->user->id);
                $query->bindParam(':pass', md5($data['password_new']));

                $query->execute();
            }else{
                echo 'Enter wrong password';die;
        }

        return $this->user;
    }


    public function getRole(){
        $user = $this->getUser();
        return empty($user) ? null : $user->role;
    }
}