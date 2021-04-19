<?php declare(strict_types=1);
require_once 'Db.class.php';
class User
{
    /**
     * The Db object
     * @var object
     */
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getUserInfoWithId($userId)
    {
        $sql = "SELECT * FROM `users` WHERE `id` = $userId";
        $connection = $this->db;
        return $connection->selectFirstRow($sql);
    }

    public function register($arg)
    {
        $sql = "INSERT INTO `users` (name, lastname, email, password, status) 
                VALUES (:name, :lastname, :email, :password, :status)";
        $connection = $this->db;
        $connection->insert($sql, $arg);
    }

}
