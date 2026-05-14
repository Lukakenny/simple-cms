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

    public function getPostsById(int $id) :array
    {
        $stmt = $this->connection->prepare("SELECT * FROM postovi WHERE korisnik_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
     }

    public function deletePost(int $id,string $postId) :bool
    {
        $stmt = $this->connection->prepare("DELETE FROM postovi WHERE korisnik_id = :id AND id = :postId");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':postId', $postId);
       return $stmt->execute();
    }
    public function updatePost(int $postId, int $userId, string $naslov, string $sadrzaj) : bool
    {
        
        $stmt = $this->connection->prepare("UPDATE postovi SET naslov = :naslov, sadrzaj = :sadrzaj, kreiran_u = NOW() WHERE id = :postId AND korisnik_id = :userId");

        // 2. Vezujemo sve parametre pazeći na tačna imena!
        $stmt->bindParam(':naslov', $naslov);
        $stmt->bindParam(':sadrzaj', $sadrzaj);
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':userId', $userId);


        return $stmt->execute();
    }



}
