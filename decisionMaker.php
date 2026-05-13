<?php
require_once 'vendor/autoload.php';

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}


use app\Controllers\PostsController;
use app\Controllers\UserController;
use app\Modeli\Posts;


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
if(isset($_POST['newPost']))
{
    $userController = new PostsController();
    $userController->createPost($_POST);
}


if(isset($_POST['delete']))
{
    $postController = new PostsController();
    $postController->deletePost($_SESSION['id'],$_POST['delete']);
}



