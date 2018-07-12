<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 25.08.16
 * Time: 14:28
 */

namespace Models;

use Core\View;
use Core\Db;
use Controllers\UserController;
use PDO;


class UserModel {

    protected $db;
    private $username;
    private $pass;
    private $email;
    private $firstName;
    private $lastName;
    private $phone;
    private $groupName;


    public function __construct() {
        $username = $this->username;
        $pass = $this->pass;
        $this->db = Db::connect();
    }

    //Getters and setters

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }


    public function getGroupName()
    {
        return $this->groupName;
    }

    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }


    //Find functions

    public function findAll()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        $userList = $stmt->fetchAll();
        return $userList;
    }

    public function findUserbyId($id)
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE id = $id;");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }


    public function findByOrganisation($organisation)
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE organisation = '$organisation' ORDER BY created_at DESC");
        $stmt->execute();
        $userList = $stmt->fetchAll();
        return $userList;
    }



    //For CRUD functions

    public function checkUserType($id)
    {
        $stmt = $this->db->prepare("SELECT group_name FROM users WHERE id = $id;");
        $stmt->execute();
        $status = $stmt->fetchColumn();
        return $status;
    }

    public static function getIdByLogin($login)
    {
        $db = Db::connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE login = ?");
        $stmt->execute(array($login));
        $id = $stmt->fetchColumn();
        return $id;
    }

    public static function getLoginById($id)
    {
        $db = Db::connect();
        $stmt = $db->prepare("SELECT login FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $login = $stmt->fetchColumn();
        return $login;
    }

    public function getPhoneByDeviceId($deviceId)
    {
        $stmt = $this->db->query("SELECT phone FROM users, devices WHERE users.id = devices.customer_id AND devices.device_id = '$deviceId';");
        $stmt->execute();
        $phone = $stmt->fetchColumn();
        return $phone;
    }


    public function save()
    {
        $stmt = $this->db->prepare("INSERT INTO users(login, password,
 email, first_name, last_name,  phone, group_name) 
 values (?,?,?,?,?,?,?)");
        $result = $stmt->execute(array($this->getUsername(), $this->getPass(), $this->getEmail(), $this->getFirstName(),
            $this->getLastName(), $this->getPhone(), $this->getGroupName()));
        return $this->db->lastInsertId();
    }

    public function update($id)
    {
        $stmt = $this->db->prepare('UPDATE users SET first_name = ?, last_name = ?, phone = ?, email = ?
  WHERE id = ?');
        $firstName = $this->getFirstName();
        $lastName = $this->getLastName();
        $phone = $this->getPhone();
        $email = $this->getEmail();
        $stmt->execute(array($firstName, $lastName, $phone, $email, $id));
//        var_dump($stmt);
        return $this->db->lastInsertId();
    }

    public function updatePassword($id){
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $result = $stmt->execute(array($this->getPass(), $id));
        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $status = $stmt->execute();
        return $status;
    }

    //For login functions

    public function usernameExists($username) {
        $stmt = $this->db->prepare("SELECT count(login) FROM users where login=?");
        $stmt->execute(array($username));
        if ($stmt->fetchColumn() > 0) {
            return true;
        }
        return false;
    }

    public function isValidUser($username, $pass) {
        $stmt = $this->db->prepare("SELECT password FROM users where login = :login");
        $stmt->bindParam(':login', $username);
        $stmt->execute();
        $hash = $stmt->fetchColumn();
        if (password_verify($pass, $hash)) {
            return true;
        }
        return false;
    }


    //forgot password function

    public function emailExist($email) {
        $stmt = $this->db->query("SELECT email FROM users where email = '$email'");
        $email = $stmt->fetchColumn();
        if ($email) {
            return $email;
        }
        return false;
    }

    public function generatePassword($length = 8)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789/*()';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    function sendNewPassword($email)
    {
        $to = $email;
        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: " . $_SERVER['SERVER_NAME'] . " \r\n";
        $subject = "Сообщение с сайта " . $_SERVER['SERVER_NAME'];
        $password = $this->generatePassword();
        $message = "New passoword " . $password;
        if(mail($to, $subject, $message, $headers)){
            return $this->updatePasswordByEmail($email, password_hash($password, PASSWORD_DEFAULT));
        }else{
            return false;
        }
    }

    public function updatePasswordByEmail($email, $password)
    {
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE email = ?');
        $result = $stmt->execute(array($password, $email));
        return $result;
    }

    //remember me functions

    public function insertAuthToken($selector, $token, $userId)
    {
        $stmt = $this->db->prepare("INSERT INTO auth_tokens (selector, token, userid, expires) VALUES (?, ?, ?, ?)");
        $stmt->execute(array($selector, $token, $userId, date('Y-m-d\TH:i:s', time() + 864000)));
    }

    public function findAuthToken($selector)
    {
        $stmt = $this->db->prepare("SELECT * FROM auth_tokens WHERE selector = :selector");
        $stmt->bindParam(':selector', $selector);
        $stmt->execute();
        $authData = $stmt->fetch();
        return $authData;
    }

        //Session functions

    public static function sessionStart()
    {
        if(session_id() == "") {
            session_start();
            $_SESSION['login'] = $_POST['login'];
        }
    }

    public static function sessionStop()
    {
        if(isset($_SESSION['login'])){
            unset($_SESSION['login']);
            session_destroy();
            return true;
        }
        return false;
    }

}