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


}
