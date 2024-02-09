<?php

namespace App\Controllers;

use App\QueryBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;

class HomeController {
    private $templates;
    private $auth;
    private $querybuilder;


    public function __construct(QueryBuilder $queryBuilder, Engine $engine, \Delight\Auth\Auth $auth) {
        $this->querybuilder = $queryBuilder;
        $this->templates = $engine;
        $this->auth = $auth;
    }

    public function register() {
        echo $this->templates->render('page_register');
    }

    public function login() {
//        $this->auth->admin()->addRoleForUserById(1, \Delight\Auth\Role::ADMIN);

        echo $this->templates->render('page_login');

    }

    public function users() {
        echo $this->templates->render('users');
    }

    public function addUser() {
        echo $this->templates->render('create_user');

    }

    public function profile() {
        echo $this->templates->render('page_profile');
    }

    public function media()
    {
        $id = $_GET['id'];
        $avatar = $_GET['avatar'];

        echo $this->templates->render('media');
    }

    public function editUser() {

        $id = $_GET['id'];
        $name = $_GET['name'];
        $workplace = $_GET['workplace'];
        $telephone = $_GET['telephone'];

        echo $this->templates->render('edit');
    }
    public function userSecurity() {
        $id = $_GET['id'];
        echo $this->templates->render('security');
    }

    public function setStatus() {
        $id = $_GET['id'];
        echo $this->templates->render('status');
    }

    public function delete() {
        $id = $_GET['id'];

        $this->querybuilder->delete('addUser', $id);
        $this->querybuilder->delete('users', $id);
        header("Location:/users");
    }

    public function logout() {
        header("Location:/users");
        $this->auth->logOut();
        $this->auth->destroySession();
    }





}