<?php
// public/database.php

class Database
{
    private $host = 'db'; // db = nom du conteneur Docker
    private $dbname = 'reservation_salles';
    private $username = 'root';
    private $password = 'root';
    public $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
}
?>
