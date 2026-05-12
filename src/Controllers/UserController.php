<?php

namespace app\Controllers;

class UserController
{
    public function register(array $data)
    {
        if (!isset($_POST['ime']) || empty($_POST['ime']))
        {
            die("Niste prosledili ime");
        }
        if (!isset($_POST['email']) || empty($_POST['email']))
        {
            die("Niste prosledili email");
        }
         if (!isset($_POST['lozinka']) || empty($_POST['lozinka']))
         {
             die("Niste prosledili lozinku");
         }



    }
}
