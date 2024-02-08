<?php

namespace App\Controllers;

use App\QueryBuilder;

class MediaController {

    private $querybuilder;



    public function __construct(QueryBuilder $queryBuilder) {
        $this->querybuilder = $queryBuilder;
    }

    public function media() {

        $id = $_POST['id'];
        $avatar = $_POST['avatar'];

        $this->querybuilder->updateAva('addUser','avatar',$id,$avatar);
    }

}