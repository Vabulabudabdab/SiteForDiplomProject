<?php

namespace App\Controllers;

use App\QueryBuilder;
use League\Plates\Engine;

class MediaController {

    private $querybuilder;



    public function __construct(QueryBuilder $queryBuilder) {
        $this->querybuilder = $queryBuilder;
    }

    public function media() {

        $id = $_GET['id'];

        $file = $_FILES['file'];

        $name = $file['name'];

        $pathFile = __DIR__.'./img/'.$name;


        $this->querybuilder->update("addUser", ['avatar' => $name], $id);
        $this->querybuilder->loadImage();

        $_SESSION['successAdd'] = "Профиль обновлён!";

        header("Location:/users");
    }



}