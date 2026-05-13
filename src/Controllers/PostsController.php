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
            array_push($greske, "Ime nije prosledjeno");
        }



        $post = new Posts();
        $post->creat($data['naslov'], $data['sadrzaj'],$_SESSION['id']);
        header("Location: dashboard.php");
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


}
