<?php
namespace app\models;
use PDO;

class User {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ? $result : null;
    }

    public function create($email) {
        $sql = "INSERT INTO users (email) VALUES (:email)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $this->findByEmail($email);
    }
}
?>