<?php

namespace app\Controllers;



use app\Modeli\User;

class UserController
{
    public function register(array $data)
    {  $greske= [];




        if (!isset($_POST['ime']) || empty($_POST['ime']))
        {
            array_push($greske, "Ime nije prosledjeno");
        }
        if (!isset($_POST['email']) || empty($_POST['email']))
        {
            array_push($greske, "Email nije prosledjeno");
        }
         if (!isset($_POST['lozinka']) || empty($_POST['lozinka']))
         {
             array_push($greske, "Lozinka nije prosledjena");
         }
        $_SESSION['greska'] = $greske;

         if(!empty($greske))
         {
             header("Location: index.php");
             exit();
         }

         $password = password_hash($_POST['lozinka'], PASSWORD_DEFAULT);



         $user = new User();

         if($user->userExists($data['email']))
         {
             $greske= [];
             array_push($greske, "Korisnik vec postoji");
             $_SESSION['greska'] = $greske;
             header("location: index.php");
         }
         else
         {
             $succses = [];
             $user->create($data['ime'], $data['email'], $password);
             array_push($succses, "Uspesno ste registrovani, ulogujte se na svoj account");
             $_SESSION['uspesno'] = $succses;
             header("location: login.php");
         }





    }
}
