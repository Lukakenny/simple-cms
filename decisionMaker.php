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