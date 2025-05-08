<?php 
class Database {
    private $host = "localhost";
    private $db_name = "pemrograman_web";
    private $username = "root";
    private $password = "";
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        } catch (Exception $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>