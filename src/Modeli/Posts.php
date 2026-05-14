<?php

namespace app\Modeli;

use app\Modeli\DB;

class Posts extends DB
{
    public function creat(string $naslov, string $tekst, int $korisnikId, int $kategorijaID): void
    {
        $stmt = $this->connection->prepare("INSERT INTO postovi(naslov,sadrzaj,korisnik_id,kategorija_id,kreiran_u)
VALUES (:naslov,:tekst,:korisnik_id,:kategorijaID,NOW())");
        $stmt->bindParam(':naslov', $naslov);
        $stmt->bindParam(':tekst', $tekst);
        $stmt->bindParam(":kategorijaID", $kategorijaID);
        $stmt->bindParam(':korisnik_id', $korisnikId);

        $stmt->execute();
    }

    public function getPostsById(int $id): array
    {
        $stmt = $this->connection->prepare("
    SELECT 
        postovi.*, 
        kategorije.naziv AS imeKategorije
    FROM postovi
    LEFT JOIN kategorije ON postovi.kategorija_id = kategorije.id
    WHERE postovi.korisnik_id = :id
    ORDER BY postovi.kreiran_u DESC
");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deletePost(int $id, int $postId): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM postovi WHERE korisnik_id = :id AND id = :postId");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':postId', $postId);
        return $stmt->execute();
    }

    public function updatePost(int $postId, int $userId, string $naslov, string $sadrzaj): bool
    {

        $stmt = $this->connection->prepare("UPDATE postovi SET naslov = :naslov, sadrzaj = :sadrzaj, kreiran_u = NOW() WHERE id = :postId AND korisnik_id = :userId");


        $stmt->bindParam(':naslov', $naslov);
        $stmt->bindParam(':sadrzaj', $sadrzaj);
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':userId', $userId);


        return $stmt->execute();
    }

    public function getAllPosts()
    {
        $stmt = $this->connection->prepare(
            "SELECT 
                  postovi.*, 
                  korisnici.ime AS autor,
                  kategorije.naziv AS imeKategorije
                  FROM postovi 
                   INNER JOIN korisnici ON postovi.korisnik_id = korisnici.id 
                  LEFT JOIN kategorije ON postovi.kategorija_id = kategorije.id
                   ORDER BY postovi.kreiran_u DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deletePostAdmin(int $postId): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM postovi WHERE  id = :postId");
        $stmt->bindParam(':postId', $postId);
        return $stmt->execute();
    }


}
