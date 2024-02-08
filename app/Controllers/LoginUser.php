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
//        $get = $this->querybuilder->selectPermission("addUser", ["permissions"], "Admin");



        $test = $this->auth->getUserId();

        $result = $this->querybuilder->getPerm("addUser", $test);


        $getSecond = $this->querybuilder->selectMail("users", ["email"], $email);
//        var_dump($get);




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


