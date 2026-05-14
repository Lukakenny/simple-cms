<?php
namespace app\Controllers;

use app\Modeli\Posts;

class PostsController
{
    public function createPost(array $data):void
    {
        $greske = [];
        if (!isset($data['naslov']) || empty($data['naslov'])) {
            array_push($greske, "Naslov nije pronadjen");
        }
        if (!isset($data['sadrzaj']) || empty($data['sadrzaj'])) {
            array_push($greske, "Sadrzaj nije prosledjeno");
        }
        if (  empty($data['kategorijaID'])) {
            array_push($greske, "Morate izabrati kategoriju");
        }
        $_SESSION['greska'] = $greske;
        if (!empty($greske)) {
            header("Location: newPost.php");
            exit();
        }


        $tagoviIzForme = $data['tagovi'] ?? [];

        $post = new Posts();


        $noviPostId = $post->creat(
            $data['naslov'],
            $data['sadrzaj'],
            $_SESSION['id'],
           $data['kategorijaID']
        );


        if (!empty($tagoviIzForme)) {

            $post->addTag($tagoviIzForme, $noviPostId);
        }

        header("Location: mojiBlogovi.php");
        exit();
        }

    public function deletePost(int $sessionId, string $postId):void
    {
          $post =new Posts();
          $obrisiPost = $post-> deletePost($sessionId, $postId);



          if ($obrisiPost) {

              header("Location: mojiBlogovi.php");
          }
    }

    public function updatePost(int $postId, int $sessionId, string $naslov,string $sadrzaj):void
    {

        $greske = [];
        if (!isset($data['naslovUpdate']) || empty($data['naslovUpdate'])) {
            array_push($greske, "Naslov nije pronadjen");
        }
        if (!isset($data['sadrzajUpdate']) || empty($data['sadrzajUpdate'])) {
            array_push($greske, "Sadrzaj nije prosledjeno");
        }
        $_SESSION['greska'] = $greske;
        if (!empty($greske)) {
            header("Location: newPost.php");
            exit();
        }


        $post =new Posts();
        $updatePost = $post->updatePost($postId,$sessionId ,$naslov, $sadrzaj);
        if ($updatePost)
        {
            header("Location: mojiBlogovi.php");
            exit();
        }
    }

    public function deleteAdmin(int $postId):void
    {
          $post =new Posts();
          $obrisiPost = $post-> deletePostAdmin($postId);
          header("Location: adminDashboard.php");
          exit();
    }

    public function prikaziPostovePoKategoriji(int $kategorijaID): void
    {
        $postModel = new Posts();
        $sveKategorije = $postModel->getAllCategories();
        $postoviZaPrikaz = $postModel->getPostsByCategory($kategorijaID);
        require_once "kategorije.php";
    }








}
