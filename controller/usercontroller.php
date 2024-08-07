<?php
session_start();
//Get php scripts
require 'model/loginmodel.php';
require 'config.php';

class usercontroller
{

    private $connectionSettings;
    private $userobj;
    function __construct()
    {
        $this->connectionSettings = new Config();
        $this->userobj = new loginmodel($this->connectionSettings->getHost(), $this->connectionSettings->getUsername(), $this->connectionSettings->getPassword(), $this->connectionSettings->getDatabase());
    }

    public function handleRequest()
    {
        // Determine the operation to be performed based on the URL parameter
        if (isset($_GET['operation'])) {
            $op = $_GET['operation'];
        } else {
            $op = NULL;
        }

        switch ($op) {
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            case NULL:
                //check if session already exists
                if (isset($_SESSION["user_id"])) {
                    include 'view/main.php';
                } else {
                    include 'view/login.php';
                }
                break;
            default:
        }
    }

    public function login()
    {
        //Login Credentials from POST request 
        $loginEmail = $_POST["loginEmail"];
        $loginPassword = $_POST["loginPassword"];
        $user = $this->userobj->login($loginEmail, $loginPassword);
        if ($user) {
            $_SESSION["UserID"] = $user->UserID;
            $_SESSION["Name"] = $user->Name;
            $_SESSION["Surname"] = $user->Surname;
            $_SESSION["Email"] = $user->Email;
            $_SESSION["Role"] = $user->Role;
            // include 'view/main.php';
            $this->redirect("view/main.php"); //Change URL which is shown after login
        } else {
            //Login not successful
            include 'view/loginError.php';
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect("index.php");
    }

    public function redirect($location)
    {
        header("Location: " . $location);
        exit();
    }
}