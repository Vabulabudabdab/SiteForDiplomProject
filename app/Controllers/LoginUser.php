<?php
namespace App\Controllers;

use App\QueryBuilder;
use League\Plates\Engine;
use \Delight\Auth\Auth;
use function DI\string;

if( !session_id() ) {session_start();}
class LoginUser {

    private $auth;
    private $querybuilder;
    public function __construct(QueryBuilder $queryBuilder, Engine $engine, \Delight\Auth\Auth $auth) {
        $this->querybuilder = $queryBuilder;
        $this->auth = $auth;
    }

    public function loginUser() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $getPerm = $this->querybuilder->getAll("addUser");

        foreach ($getPerm as $perm) {
            if($perm['email'] == $email && $perm['permissions'] == "Admin"){
                $_SESSION['Permission'] = "Admin";
            } elseif($perm['email'] == $email && $perm['permissions'] == "user") {
                $_SESSION['Permission'] = "user";
            }
        }

        try {

            $this->auth->login($email, $password);
            $_SESSION['login'] = $email;

            header("Location:/users");

        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            header("Location:/login");
            die('Wrong email address');

        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            header("Location:/login");
            die('Wrong password');

        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {

            die('Email not verified');

        }
        catch (\Delight\Auth\TooManyRequestsException $e) {

            die('Too many requests');

        }

    }

}


