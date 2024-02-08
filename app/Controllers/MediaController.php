<?php

namespace App\Controllers;

use App\QueryBuilder;

class MediaController {

    private $querybuilder;



    public function __construct(QueryBuilder $queryBuilder) {
        $this->querybuilder = $queryBuilder;
    }

    public function media() {

        $id = $_GET['id'];
        $avatar = $_GET['avatar'];

        $this->querybuilder->updateAvatar('avatar', $avatar, "addUser");
    }

}