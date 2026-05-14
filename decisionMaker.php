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
    $postDelete= intval($_POST['delete']);
    $postController->deletePost($_SESSION['id'],$postDelete);
}


if(isset($_POST['updatePost'])) {

    $postController = new PostsController();
   $postId = intval($_POST['updatePost']);
    $postController->updatePost($postId,$_SESSION['id'], $_POST['naslovUpdate'], $_POST['sadrzajUpdate'] );
}
if(isset($_POST['deleteAdmin']))
{
    $postController = new PostsController();
    $postDelete= intval($_POST['deleteAdmin']);
    $postController->deleteAdmin($postDelete);
}








