<?php
class Database {
    private static $host = 'localhost';
    private static $db_name = 'bookstore'; // Update with your actual database name
    private static $username = 'root';     // Update credentials
    private static $password = '';
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                die(json_encode(['status' => 'error', 'message' => 'Connection Error: ' . $e->getMessage()]));
            }
        }
        return self::$conn;
    }
}