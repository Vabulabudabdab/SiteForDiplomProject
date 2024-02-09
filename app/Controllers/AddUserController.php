<?php

namespace App\Controllers;

use App\QueryBuilder;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

class AddUserController {
    private $auth;
    private $querybuilder;



    public function __construct(QueryBuilder $queryBuilder, \Delight\Auth\Auth $auth) {
        $this->querybuilder = $queryBuilder;
        $this->auth = $auth;
    }

    public function addUser() {

        $email = $_POST['email'];

        $password = $_POST['password'];

        $name = $_POST['name'];

        $workplace = $_POST['workplace'];

        $telephone = $_POST['telephone'];

        $adress = $_POST['adress'];

        $status = $_POST['status'];

        $vk = $_POST['vk'];

        $telegram = $_POST['telegram'];

        $instagram = $_POST['instagram'];


        if(!empty($_FILES['file'])) {
            $file = $_FILES['file'];
            $filename = $file['name'];
            $pathFile = '../img/'.$filename;

            d($file);
            d($filename);
            d($pathFile);

            if(!move_uploaded_file($file['tmp_name'], $pathFile)) {
                echo 'Ошибка загрузки файла';
            }

        }


        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $getOne = $this->querybuilder->selectMail("addUser", ["email"], $email);

        $getSecond = $this->querybuilder->selectMail("users", ["email"], $email);


        if ($getOne == true || $getSecond == true) {
            header("Location:/users");
            $_SESSION['exstsUser'] = "Данный пользователь уже существует";
            exit;
        } else {
            $this->querybuilder->insert("addUser", ["workplace"=>$workplace, "telephone"=>$telephone, "adress"=>$adress,
            "email"=>$email, "password"=>$hashed_password, "status"=>$status, "avatar"=>$filename, "vk"=>$vk, "telegram"=>$telegram, "instagram"=>$instagram, "name"=>$name]);

            $userId = $this->auth->register($email, $password, $name);

            $_SESSION['successAdd'] = "Пользователь успешно добавлен!";
            header("Location:/users");
        }

        header("Location:/users");

    }


}