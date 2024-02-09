<?php

namespace App\Controllers;

use App\QueryBuilder;

class UserEdit
{
    private $querybuilder;

    public function __construct(QueryBuilder $queryBuilder, \Delight\Auth\Auth $auth)
    {
        $this->querybuilder = $queryBuilder;
    }

    public function edit()
    {

        $id = $_GET['id'];

        $name = $_GET['name'];

        $workplace = $_GET['workplace'];

        $telephone = $_GET['telephone'];

        $adress = $_GET['adress'];

        $this->querybuilder->update('addUser',['name' => $name, 'workplace' => $workplace, 'telephone' => $telephone, 'adress' => $adress], $id);

        $_SESSION['successAdd'] = "Профиль успешно обновлён!";
        header("Location:/users");


    }

}