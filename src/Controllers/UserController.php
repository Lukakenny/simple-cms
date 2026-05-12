<?php

namespace app\Controllers;



use app\Modeli\User;

class UserController
{
    public function register(array $data)
    {

        if (!isset($_POST['ime']) || empty($_POST['ime']))
        {
           die("mniste uneli ime");
        }
        if (!isset($_POST['email']) || empty($_POST['email']))
        {
            die("niste uneli email");
        }
         if (!isset($_POST['lozinka']) || empty($_POST['lozinka']))
         {
            die('nise uneli lozinku ');
         }



         $user = new User();

         if($user->userExists($_POST['email']))
         {

             $greske= [];
             array_push($greske, "Korisnik vec postoji");
             $_SESSION['greska'] = $greske;


             header("index.php");

         }
         else
         {

         }


    }
}
