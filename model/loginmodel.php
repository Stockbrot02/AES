<?php

class loginmodel
{
    function __construct($hostname, $user, $pw, $db)
    {
        $this->host = $hostname;
        $this->username = $user;
        $this->password = $pw;
        $this->database = $db;
    }

    //Opens connection to Database
    public function openDb()
    {
        try {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        } catch (mysqli_sql_exception $e) {
            die("Error connecting to DB:" . $e);
        }
    }

    //Closes Database connection
    public function closeDb()
    {
        $this->connection->close();
    }

    /**
     * Gets user from database
     *
     * @param string $loginEmail email from user
     * @param string $password password from user
     *
     * @return object Userobject from database
     */
    public function login($loginEmail, $loginPassword)
    {
        $this->openDb();
        $sql = $this->connection->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $sql->bind_param("ss", $loginEmail, $loginPassword);
        $sql->execute();
        $result = $sql->get_result();
        $sql->close();
        $this->closeDb();
        return $result->fetch_object();
    }

}