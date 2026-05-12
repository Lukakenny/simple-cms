<?php

namespace app\Modeli;



class User extends DB
{

    public function userExists(string $email):bool
    {
       $stmt = $this->connection->prepare("SELECT * FROM korisnici WHERE email = :email ");
       $stmt->bindParam(':email', $email);
       $stmt->execute();

       return $stmt->rowCount() > 0;
 }

    public function create(string $ime,string $email, string $lozinka):void
    {
        $stmt = $this->connection->prepare("INSERT INTO korisnici (ime,email,lozinka) VALUES (:ime, :email, :lozinka) ");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':ime', $ime);
        $stmt->bindParam(':lozinka', $lozinka);
        $stmt->execute();

 }


}
