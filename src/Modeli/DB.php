<?php

namespace app\Modeli;

use PDO;

class DB
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new  PDO("mysql:host=localhost;dbname=cms", "root", "");
    }
}
