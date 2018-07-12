<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 25.08.16
 * Time: 14:27
 */

namespace Controllers;

use Core\View;
use Models\MachineModel;
use Models\UserModel;

class UserController
{
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function checkUserType()
    {
        if(!isset($_SESSION['login']))
        {
            $view = new View();
            echo $view->render('errors/unauthorized');
        } else {
            $user = new UserModel();
            $id = $user->getIdByLogin($_SESSION['login']);
            $type = $user->checkUserType($id);
            return $type;
        }
    }

    public static function saveUser()
    {
        $user = new UserModel();
        $hub = new HubModel();
        $userId = '';
        if ($user->usernameExists($_POST['login'])) {
                $warning['title'] = 'Username already exist';
                echo View::render('errors/warning', $warning);
            return;
        } elseif($user->emailExist($_POST['email'])){
            $warning['title'] = 'E-mail already exist';
            echo View::render('errors/warning', $warning);
            return;
        }elseif ($_POST['password'] == $_POST['repeat-password']){
                if($hub->checkLicenseKey($_POST['hub-id'], $_POST['license-key']) == true){
                    $user->setUsername($_POST['login']);
                    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $user->setPass($hash);
                    $user->setEmail($_POST['email']);
                    $user->setFirstName($_POST['firstname']);
                    $user->setLastName($_POST['lastname']);
                    $user->setPhone($_POST['phone']);
                    $user->setGroupName('user');
                    $userId = $user->save();
                    if(!$hub->checkCustomerExist($_POST['hub-id'])){
                        $hub->setCustomer($userId, $_POST['hub-id']);
                    }else{
                        $user->delete($userId);
                        $warning['title'] = 'Device is already registred';
                        echo View::render('errors/warning', $warning);
                        return;
                    }
                }else{
                    $user->delete($userId);
                    $warning['title'] = 'Wrong pair HUB ID and License key.';
                    echo View::render('errors/warning', $warning);
                    return;
                }
        }else{
            $warning['title'] = 'Passwords do not match';
            echo View::render('errors/warning', $warning);
            return;
        }
        $_SESSION['status'] = 'new';
        header('Location: /');
    }

    public static function userOptions()
    {
        if (!isset($_SESSION['login'])) {
            $view = new View();
            echo $view->render('errors/unauthorized');
        } else {
            $user = new UserModel();
            $user = $user->findUserbyId($_SESSION['id']);
            echo View::render('userOptions', $user);
        }
    }

    public static function saveUserOptions(){
        if (!isset($_SESSION['login'])) {
            $view = new View();
            echo $view->render('errors/unauthorized');
        } else {
            $userModel = new UserModel();
            $userModel->setUsername($_SESSION['login']);
            $userModel->setFirstName($_POST['firstname']);
            $userModel->setLastName($_POST['lastname']);
            $userModel->setPhone($_POST['phone']);
            $userModel->setEmail($_POST['email']);
            if(filter_var($userModel->getEmail(), FILTER_VALIDATE_EMAIL))
            {
                $userModel->update($_SESSION['id']);
                $user = $userModel->findUserbyId($_SESSION['id']);
                $user['changed'] = true;
                echo View::render('userOptions', $user);
            }else{
                $warning['title'] = 'Please, enter a valide e-mail!';
                echo View::render('errors/warning', $warning);
            }

        }
    }

    public static function changePassword(){
        if (!isset($_SESSION['login'])) {
            echo View::render('errors/unauthorized');
        } else {
            echo View::render('changePassword');
        }
    }

    public static function saveChangePassword(){
        $user = new UserModel();
        if (!isset($_SESSION['login'])) {
            $view = new View();
            echo $view->render('errors/unauthorized');
        } else {
            if($user->isValidUser($_SESSION['login'], $_POST['old-password'])){
                if($_POST['password'] == $_POST['repeat-password']){
                    $user = new UserModel();
                    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $user->setPass($hash);
                    $user->updatePassword($_SESSION['id']);
                    $passChange = true;
                    echo View::render('changePassword', $passChange);
                }else{
                    $warning['title'] = 'Password does not match the confirm password.';
                    echo View::render('errors/warning', $warning);
                }
            }else{
                $warning['title'] = 'Wrong old password';
                echo View::render('errors/warning', $warning);
            }
        }
    }


    public static function loginFormView()
    {
        if(isset($_SESSION['login'])){
            echo "Вы уже авторизованы!";
            header('Location: /');
        }else{
            $view = new View();
            echo $view->render('login');
        }
    }

    public static function login()
    {
        $user = new UserModel();
        if ($user->usernameExists($_POST['login']) &&
            $user->isValidUser($_POST['login'], $_POST['password'])) {
            if(isset($_POST['remember'])) {
                $selector = base64_encode(random_bytes(9));
                $authenticator = random_bytes(33);

                setcookie(
                    'remember',
                    $selector.':'.base64_encode($authenticator),
                    time() + 864000
                );

                $token = hash('sha256', $authenticator);
                $userId = $user->getIdByLogin($_POST['login']);
                $user->insertAuthToken($selector, $token, $userId);
            }
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['id'] = $user->getIdByLogin($_SESSION['login']);
            $type = self::checkUserType();
            $_SESSION['type'] = $type;
            $machine = MachineModel::getDevicesByCustomer($_SESSION['id']);
            $_SESSION['device_id'] = $machine['device_id'];
            if (!empty($_SESSION['login'])) {
                header('Location: /');
            }
        }elseif(isset($_SESSION['login'])) {
            header('Location: /');
        }else{
            $warning['title'] = "Wrong pair login/password";
            echo View::render('errors/warning', $warning);
        }
    }

    public static function logout()
    {
        session_destroy();
        unset($_SESSION['login']);
        unset($_SESSION['id']);
        unset($_SESSION['type']);
        setcookie(
            'remember',
            '',
            time() - 10
        );
        header('Location: /');
    }

    public static function remindPassword()
    {
        $user = new UserModel();
        if($user->emailExist($_POST['email'])){
            $user->sendNewPassword($_POST['email']);
            $_POST['remindPass'] = true;
            MainController::lostPass();
        }else{
            $warning['title'] = "Email doesn`t exist!";
            echo View::render('errors/warning', $warning);
        }
    }

}