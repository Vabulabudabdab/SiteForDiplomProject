<?php

namespace App\Controllers;

use App\QueryBuilder;
use League\Plates\Engine;

class SetUserStatus {
    private $querybuilder;



    public function __construct(QueryBuilder $queryBuilder) {
        $this->querybuilder = $queryBuilder;
    }

    public function setStatus() {

        $id = $_GET['id'];

        $status = $_GET['status'];


        $this->querybuilder->update("addUser", ['status' => $status], $id);
        $this->querybuilder->loadImage();

        $_SESSION['successAdd'] = "Профиль обновлён!";

        header("Location:/users");
    }



}