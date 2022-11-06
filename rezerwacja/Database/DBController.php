<?php

class DBController
{
    /* dane bazy danych */
    protected $host = "localhost";
    protected $user = "root";
    protected $password = "";
    protected $database = "reserveit";

    /* rozpoczęcie połączenia z bazą */
    public $con = null;

    public function  __construct(){
        $this->con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if($this->con->connect_error){
            echo "Błąd".$this->con->connect_error;
        }
    }

    public function __destruct(){
        $this->closeConnection();
    }

    /* zamknięcie połączenia z bazą */
    protected function closeConnection()
    {
        if ($this->con != null) {
            $this->con->close();
            $this->con = null;
        }
    }

}