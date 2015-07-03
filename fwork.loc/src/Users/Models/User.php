<?php
namespace Users\Models;

use Core\Model;
use Core\Service;
use Core\Session;
use Core\Cookie;

/**
 * Created by PhpStorm.
 * User: lamp
 * Date: 11.06.15
 * Time: 21:11
 */
class User extends Model{

    public function getList($role = null, $course = null)
    {
        try{
            if (!empty($role) && empty($course)) {
                $sql = 'SELECT u.*, GROUP_CONCAT(DISTINCT c.name ORDER BY c.name ASC SEPARATOR ", ") AS "course"
                        FROM user u
                        LEFT JOIN user_course uc ON u.id = uc.user_id
                        LEFT JOIN course c ON uc.course_id = c.id
                        WHERE u.role = :role
                        GROUP by u.id';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':role', $role);

            }
            if (empty($role) && !empty($course)) {
                $sql .= 'SELECT u.*, c.name as "course"
                        FROM user u
                        LEFT JOIN user_course uc ON u.id = uc.user_id
                        LEFT JOIN course c ON uc.course_id = c.id
                        WHERE c.id = :course
                        ORDER BY u.role DESC';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':course', $course);

            }
            if (!empty($role) && !empty($course)) {
                $sql .= 'SELECT u.*, c.name as "course"
                        FROM user u
                        LEFT JOIN user_course uc ON u.id = uc.user_id
                        LEFT JOIN course c ON uc.course_id = c.id
                        WHERE u.role = :role AND c.id = :course';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':course', $course);

            }
            if (empty($role) && empty($course)) {
                $sql = 'SELECT u.*, GROUP_CONCAT(DISTINCT c.name ORDER BY c.name ASC SEPARATOR ", ") AS "course"
                        FROM `user` u
                        LEFT JOIN user_course uc ON u.id = uc.user_id
                        LEFT JOIN course c ON uc.course_id = c.id
                        GROUP by u.id
                        ORDER BY u.role DESC';
                $stmt = $this->db->prepare($sql);
            }

            $stmt->execute();
            $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $res;
        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }

    }

    public function createStud(){
        try{
            $sql = 'INSERT INTO `user`
                    (`name`, `role`, `email`)
                    VALUES (:name, :role, :email)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':name' => $_POST['name'],
                ':role' => $_POST['role'],
                ':email' => $_POST['email']
            ));
            return $this->db->lastInsertId();
        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }
    }

    public function addCourse($id){
        try{
            $sql = 'INSERT INTO `user_course`
                    (`user_id`, `course_id`)
                    VALUES (:user_id, :course_id)';
            $stmt = $this->db->prepare($sql);
            foreach ($_POST['courses'] as $val) {
                $stmt->execute(array(
                    ':user_id' => $id,
                    ':course_id' => $val
                ));
            }
        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }
    }

    public function delUser($id){
        try {
            $sql = "DELETE FROM `user`
                    WHERE `id`= :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }
    }

    public function singleUser($id) {
        try {
            $sql = 'SELECT u.*, GROUP_CONCAT(DISTINCT uc.course_id SEPARATOR " ") AS "course"
                    FROM `user` u
                    LEFT JOIN `user_course` uc ON u.id = uc.user_id
                    WHERE u.id = :id
                    GROUP BY u.id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $res = $stmt->fetch(\PDO::FETCH_ASSOC);
            $res['course'] = explode(' ', $res['course']);
            return $res;
        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }
    }

    public function updateUser($data){
        try{
            $sql = 'UPDATE user SET
                    `name` = :name,
                    `role` = :role,
                    `email` = :email
                    WHERE id = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':id' => $data['id'],
                ':name' => $data['name'],
                ':role' =>  $data['role'],
                ':email' =>  $data['email']
            ));

            $this->updtUserCourse($data['id'], $data['courses']);

        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }
    }

    public function delCourse($id){
        try {
            $sql = "DELETE FROM `user_course`
                    WHERE `user_id`= :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }
    }

    public function insCourse($id, $arr){
        try {
            $sql = "INSERT INTO `user_course`
                    (`user_id`,`course_id`)
                    VALUES
                    ( :id, :course)";
            $stmt = $this->db->prepare($sql);
            foreach($arr as $val) {
                $stmt->execute(array(
                    ':id' => $id,
                    ':course' => $val
                ));
            }
        }catch(\PDOException $e){
            Service::get('log')->error($e->getMessage() . " & Code " . $e->getCode());
            require URL ."/src/error.php";exit;
        }
    }


    public function updtUserCourse($id, $val){
        $this->delCourse($id);
        $this->insCourse($id, $val);
    }

}