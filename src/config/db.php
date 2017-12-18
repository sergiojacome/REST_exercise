<?php
class db {
    private $host;
    private $db_name;
    private $username;
    private $password;

    function __construct($host, $db_name, $username, $password) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
    }
    // Connect
    public function connect(){
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->db_name";
        $dbConnection = new PDO($mysql_connect_str, $this->username, $this->dbpassword);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}