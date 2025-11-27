<?php
class User
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $nombre;
    public $correo;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Login user
    public function login($correo, $password)
    {
        $query = "SELECT id, nombre, password_hash, foto_perfil FROM " . $this->table_name . " WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $correo = htmlspecialchars(strip_tags($correo));
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password_hash'])) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                return true;
            }
        }
        return false;
    }

    // Register user (Basic implementation for future use)
    public function register($nombre, $correo, $password)
    {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, correo=:correo, password_hash=:password_hash";
        $stmt = $this->conn->prepare($query);

        $nombre = htmlspecialchars(strip_tags($nombre));
        $correo = htmlspecialchars(strip_tags($correo));
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":password_hash", $password_hash);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>