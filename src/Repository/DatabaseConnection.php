<?php

declare(strict_types=1);

namespace App\Library\Repository;

class DatabaseConnection
{
    public $db_h = "localhost";
    public $db_u = "root";
    public $db_p = "";
    public $db_n = "library_db";
    public $conn;

    function connect()
    {
        $this->conn = new \mysqli($this->db_h, $this->db_u, $this->db_p, $this->db_n);
        if ($this->conn->connect_error) {
            die("db error");
        }
    }
}
