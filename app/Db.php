<?php


namespace App;

use PDO;

class Db
{
    private $dbh;

    public function __construct()
    {
        $dbConfig = include realpath(__DIR__ . '/../config/db-config.php');
        $this->dbh = new PDO($dbConfig['db'] . ':host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'], $dbConfig['user'], $dbConfig['password']);
    }

    public function execute($query, array $params = [])
    {
        $sth = $this->dbh->prepare($query);
        return $sth->execute($params);
    }

    public function query(string $sql, string $class, array $data = [])
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($data);
        return $sth->fetchAll(PDO::FETCH_CLASS, $class);
    }
}