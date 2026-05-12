<?php
require_once 'vendor/autoload.php';

use app\Controllers\UserController;

if(session_status() == PHP_SESSION_NONE){
    session_start();
}


if(isset($_POST['register']))
{
   $userController = new UserController();
   $userController->register($_POST);
}