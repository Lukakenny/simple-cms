<?php
require_once 'vendor/autoload.php';

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}


use app\Controllers\UserController;

if(session_status() == PHP_SESSION_NONE){
    session_start();
}


if(isset($_POST['register']))
{
   $userController = new UserController();
   $userController->register($_POST);
}
if(isset($_POST['login']))
{
    $userController = new UserController();
    $userController->login($_POST);
}

// Proveravamo da li je u URL-u prosleđen parametar za logout
if (isset($_GET['akcija']) && $_GET['akcija'] === 'logout') {

    $userController = new UserController();
    $userController->logout();
}

