<?php
class Database
{
    private static $host = 'localhost';
    private static $db_name = 'sistema_diario';
    private static $username = 'root';
    private static $password = '';

    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn !== null) {
            return self::$conn;
        }

        try {
            self::$conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                self::$username,
                self::$password
            );
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw new RuntimeException(
                'Connection error: ' . $exception->getMessage()
            );
        }

        return self::$conn;
    }
}
