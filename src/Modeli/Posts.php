<?php

namespace app\Modeli;

use app\Modeli\DB;

class Posts extends DB
{
    public function creat(string $naslov, string $tekst,int $korisnikId) :void
    {
        $stmt = $this->connection->prepare("INSERT INTO postovi(naslov,sadrzaj,korisnik_id,kreiran_u)
VALUES (:naslov,:tekst,:korisnik_id,NOW())");
        $stmt->bindParam(':naslov', $naslov);
        $stmt->bindParam(':tekst', $tekst);
        $stmt->bindParam(':korisnik_id', $korisnikId);

   $stmt->execute();
     }
}
