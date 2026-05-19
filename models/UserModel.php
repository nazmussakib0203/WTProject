<?php
require_once __DIR__ . '/../config/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}