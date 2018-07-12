<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 25.08.16
 * Time: 16:53
 */

namespace Controllers;

use Core\View;
use Models\BanknoteModel;
use Models\UserModel;

class MainController
{
    public static function notFound()
    {
        $view = new View();
        echo $view->render('errors/notfound');
    }

    public  static function index()
    {
        if(isset($_SESSION['login']))
        {
//            $thermometer = new ThermometerModel();
//            $thermometers = $thermometer->getThermometersByCustomer($_SESSION['id']);
//            echo View::render('main', $thermometers);
//            self::mapView();
//            $banknote = new BanknoteModel();
//            $customerId = $_SESSION['id'];
//            $banknotes = $banknote->getBanknotesForUser($customerId);
            echo View::render('main');
        }else
        {
            UserController::loginFormView();
        }
    }

    public static function rememberMe()
    {
        if(empty($_SESSION['login']) && !empty($_COOKIE['remember']))
        {
            $user = new UserModel();
            list($selector, $authenticator) = explode(':', $_COOKIE['remember']);
            $authData = $user->findAuthToken($selector);

            if(hash_equals($authData['token'], hash('sha256', base64_decode($authenticator))))
            {
                $_SESSION['login'] = $user->getLoginById($authData['userid']);
                $_SESSION['id'] = $authData['userid'];
                $type = UserController::checkUserType();
                $_SESSION['type'] = $type;
                if (!empty($_SESSION['login']))
                {
//                    header("Refresh:0");
                }
            }
        }
    }

    public static function signUp()
    {
        if(!isset($_SESSION['login']))
        {
            echo View::render('registration');
        } else {
            $warning['title'] = 'You already registered';
            echo View::render('errors/warning', $warning);
        }
    }

    public static function lostPass()
    {
        if(!isset($_SESSION['login']))
        {
            echo View::render('forgotPass');
        } else {
            $warning['title'] = 'You already authorized';
            echo View::render('errors/warning', $warning);
        }
    }

}