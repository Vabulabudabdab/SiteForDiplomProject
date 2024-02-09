<?php

namespace App\Controllers;

use App\QueryBuilder;

class UserSecurity
{
    private $querybuilder;

    private $auth;

    public function __construct(QueryBuilder $queryBuilder, \Delight\Auth\Auth $auth)
    {
        $this->querybuilder = $queryBuilder;
    }

    public function edit()
    {

        $id = $_POST['id'];

        $email = $_POST['email'];

        $password = $_POST['password'];

        $confirmPassword = $_POST['confirmPassword'];


        $firstPass = password_hash($password, PASSWORD_DEFAULT);

        $secondPass = password_hash($confirmPassword, PASSWORD_DEFAULT);


            if (password_verify($_POST['password'], $secondPass)) {


                  $first =  $this->querybuilder->update('addUser',['email' => $email], $id);

                  $second = $this->querybuilder->update('users',['email' => $email], $id);

                    $_SESSION['successAdd'] = "Профиль успешно обновлён!";
                    header("Location:/users");
            }
        header("Location:/users");
        }

}