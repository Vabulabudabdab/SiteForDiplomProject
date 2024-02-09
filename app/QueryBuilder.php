<?php

namespace App;

use Aura\SqlQuery\QueryFactory;

use PDO;
Class QueryBuilder {
    private $pdo;
    private $queryFactory;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $this->queryFactory = new QueryFactory('mysql');
    }
    public function getAll($table) {

        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])->from($table);


        $sth = $this->pdo->prepare($select->getStatement($table));

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOne($table, $cols) {

        $select = $this->queryFactory->newSelect();

        $select->cols($cols)->from($table);

        $sth = $this->pdo->prepare($select->getStatement($table));

        $sth->execute($select->getBindValues());

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function insert($table, $data) {


        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());

    }

    public function selectMail($table, $data, $email) {

        $select = $this->queryFactory->newSelect();

        $select
            ->from($table)
            ->cols($data)
            ->where('email = :email', ['email' => $email]);

        $sth = $this->pdo->prepare($select->getStatement($table));

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getAllById($table, $id) {

        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])->from($table)->where('id = :id', ['id' => $id]);
        //Для записи в сессию

        $sth = $this->pdo->prepare($select->getStatement($table));

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getPerm($table, $id) {

        $select = $this->queryFactory->newSelect();

        $select->cols(['permissions'])->from($table)->where('id = :id', ['id' => $id]);
        //Для записи в сессию

        $sth = $this->pdo->prepare($select->getStatement($table));

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC );

        return $result;
    }

    public function update($table,$data, $id) {

        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id', ['id'=>$id]);

        $sth = $this->pdo->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }

    public function delete($table, $id) {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)                   // FROM this table
            ->where('id = :id', ['id' => $id]);

        $sth = $this->pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());
    }

    public function loadImage()
    {
        if (!empty($_FILES['file'])) {
            $file = $_FILES['file'];
            $filename = $file['name'];
            $pathFile = '../img/' . $filename;

            d($file);
            d($filename);
            d($pathFile);

            if (!move_uploaded_file($file['tmp_name'], $pathFile)) {
                echo 'Ошибка загрузки файла';
            }
        }
    }
}