<?php

namespace app\Controllers;


use app\Modeli\User;

class UserController
{
    public function register(array $data)
    {
        $greske = [];


        if (!isset($data['ime']) || empty($data['ime'])) {
            array_push($greske, "Ime nije prosledjeno");
        }
        if (!isset($data['email']) || empty($data['email'])) {
            array_push($greske, "Email nije prosledjeno");
        }
        if (!isset($data['lozinka']) || empty($data['lozinka'])) {
            array_push($greske, "Lozinka nije prosledjena");
        }
        $_SESSION['greska'] = $greske;

        if (!empty($greske)) {
            header("Location: index.php");
            exit();
        }

        $password = password_hash($data['lozinka'], PASSWORD_DEFAULT);


        $user = new User();

        if ($user->userExists($data['email'])) {
            $greske = [];
            array_push($greske, "Korisnik vec postoji");
            $_SESSION['greska'] = $greske;
            header("location: index.php");
        } else {
            $succses = [];
            $user->create($data['ime'], $data['email'], $password);
            array_push($succses, "Uspesno ste registrovani, ulogujte se na svoj account");
            $_SESSION['uspesno'] = $succses;
            header("location: login.php");
        }


    }

    public function login(array $data)
    {
        $greske = [];
        if (!isset($data['email']) || empty($data['email'])) {
            array_push($greske, "Email nije prosledjeno");
        }
        if (!isset($data['lozinka']) || empty($data['lozinka'])) {
            array_push($greske, "Lozinka nije prosledjena");
        }
        $_SESSION['greska'] = $greske;

        if (!empty($greske)) {
            header("Location: login.php");
            exit();
        }

       $user = new User();

    $korisnik = $user->getUserByEmail($data['email']);

        if ($korisnik && password_verify($data['lozinka'], $korisnik['lozinka']))
        {
            $_SESSION['id'] = $korisnik['id'];
            $_SESSION['logIn'] = true;
            header("location: dashboard.php");
            exit();

        }
        else
        {
           array_push($_SESSION['greska'], "Email/Lozinka nisu ispravni");
           header("Location: login.php");
        }



    }
}
