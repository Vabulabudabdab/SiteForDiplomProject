<?php

namespace App\Controllers;

use App\QueryBuilder;
use League\Plates\Engine;
use \Delight\Auth\Auth;
if( !session_id() ) {session_start();}
class RegisterUser {

    private $auth;
    private $querybuilder;


    public function __construct(QueryBuilder $queryBuilder, Engine $engine, \Delight\Auth\Auth $auth) {
        $this->querybuilder = $queryBuilder;
        $this->auth = $auth;
    }

    public function registerUser() {

        $email = $_POST['email'];

        $password = $_POST['password'];

        $name = $_POST['username'];

        $workplace = "";

        $telephone = "";

        $adress = "";

        $status = "Онлайн";

        $vk = "";

        $telegram = "";

        $instagram = "";

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $getOne = $this->querybuilder->selectMail("addUser", ["email"], $email);

        $getSecond = $this->querybuilder->selectMail("users", ["email"], $email);

        if ($getOne == true || $getSecond == true) {
            header("Location:/register");
            $_SESSION['exists'] = "Данный пользователь уже существует!";
            exit;
        } else {
            $this->querybuilder->insert("addUser", ["workplace" => $workplace, "telephone" => $telephone, "adress" => $adress,
                "email" => $email, "password" => $hashed_password, "status" => $status, "avatar" => "kot.jpg", "vk" => $vk, "telegram" => $telegram, "instagram" => $instagram, "name" => $name]);

                 $userId = $this->auth->register($email, $password, $name);

            header("Location:/login");
             }
        }

}