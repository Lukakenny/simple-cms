<?php
require_once 'vendor/autoload.php';

use app\Modeli\Posts;

if(session_status() == PHP_SESSION_NONE){
    session_start();
}


if(!isset($_SESSION['logIn']) || $_SESSION['logIn'] !== true) {
    header("Location: index.php");
    exit();
}


$post = new Posts();
$myPosts = $post->getPostsById($_SESSION['id']);

?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moji Blogovi - CMS</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f7f6;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 10;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #eeeeee;
        }

        .sidebar-header h2 { color: #333; font-size: 22px; }

        .nav-links { list-style: none; padding: 20px 0; flex: 1; }
        .nav-links li a {
            display: flex; align-items: center; padding: 15px 25px;
            color: #555555; text-decoration: none; font-size: 15px; font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-links li a:hover, .nav-links li a.active {
            background-color: #f0fdf4; color: #4CAF50; border-right: 4px solid #4CAF50;
        }
        .nav-links li a span { margin-right: 15px; font-size: 18px; }

        .sidebar-footer { padding: 20px; border-top: 1px solid #eeeeee; }
        .logout-btn {
            display: block; text-align: center; background-color: #ffe6e6;
            color: #d93025; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: bold;
        }

        /* --- GLAVNI DEO --- */
        .main-content {
            flex: 1; display: flex; flex-direction: column; overflow-y: auto;
        }

        .topbar {
            background-color: #ffffff; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            display: flex; justify-content: space-between; align-items: center;
        }
        .welcome-text h1 { font-size: 20px; color: #333; }

        .action-btn {
            background-color: #4CAF50; color: white; padding: 10px 20px;
            border: none; border-radius: 6px; font-weight: bold; cursor: pointer; text-decoration: none;
        }

        /* --- STILOVI ZA BLOG KARTICE --- */
        .content-wrapper { padding: 40px; }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .blog-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .blog-meta {
            font-size: 13px;
            color: #888;
            margin-bottom: 10px;
            /* Flex-end gura datum skroz udesno pošto nema autora levo */
            display: flex;
            justify-content: flex-end;
        }

        .blog-card h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .blog-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .blog-actions {
            display: flex;
            gap: 10px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            border: none;
        }

        .btn-read { background-color: #e3f2fd; color: #1976d2; flex-grow: 1; }
        .btn-read:hover { background-color: #bbdefb; }

        .btn-edit { background-color: #fff3e0; color: #f57c00; }
        .btn-edit:hover { background-color: #ffe0b2; }

        .btn-delete { background-color: #ffe6e6; color: #d93025; }
        .btn-delete:hover { background-color: #ffcccc; }
        .kategorija-minimal {
            font-size: 14px;
            color: #555;
            background-color: #f8f9fa; /* Jako svetla siva pozadina */
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            display: inline-block; /* Da ne zauzima ceo red */
        }

        .kategorija-minimal strong {
            color: #333;
            margin-right: 4px;
        }

        .kategorija-minimal span {
            color: #007BFF; /* Neka plava boja za link/kategoriju */
            font-weight: 600;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Pozdrav <?= $_SESSION['ime']?></h2>
    </div>
    <ul class="nav-links">
        <?php if (isset($_SESSION['uloga']) && $_SESSION['uloga'] === "admin"): ?>
            <li><a href="adminDashboard.php"><span>📊</span> Kontrolna tabla</a></li>
            <li><a href="dashboard.php" ><span>📝</span> Sve objave</a></li>
            <li><a href="mojiBlogovi.php" class="active"><span>📂</span> Moji blogovi</a></li>

        <?php else: ?>
            <li><a href="dashboard.php" class="active"><span>📝</span> Sve objave</a></li>
            <li><a href="mojiBlogovi.php"><span>📂</span> Moji blogovi</a></li>

        <?php endif; ?>

    </ul>
    <div class="sidebar-footer">
        <a href="decisionMaker.php?akcija=logout" class="logout-btn">Odjavi se</a>
    </div>
</aside>

<main class="main-content">
    <header class="topbar">
        <div class="welcome-text">
            <h1>Moji blogovi</h1>
            <p style="color: #777; font-size: 14px; margin-top: 5px;">Pregled i upravljanje vašim ličnim objavama.</p>
        </div>

        <a href="newPost.php" class="action-btn">+ Nova Objava</a>
    </header>

    <div class="content-wrapper">
        <div class="blog-grid">

               <?php if(!empty($myPosts)): ?>

                   <?php foreach ($myPosts as $post) : ?>
                       <div class="blog-card">
                           <div class="blog-meta">
                               <span>📅 <?= $post['kreiran_u'] ?></span>
                           </div>
                           <h3><?= $post['naslov'] ?></h3>
                           <p><?= $post['sadrzaj'] ?></p>
                           <p class="kategorija-minimal">
                               📁 <strong>Kategorija:</strong> <span><?= $post['imeKategorije'] ?></span>
                           </p>


                           <div class="blog-actions">


                               <a href="updatePost.php?id=<?= $post['id'] ?>" class="btn btn-edit">✎ Izmeni</a>



                               <form action="decisionMaker.php" method="POST" style="display:inline;" >

                                   <input type="hidden" name="delete" value="<?= $post['id'] ?>">

                                   <button type="submit" name="obrisiBlog" class="btn btn-delete">🗑️ Obriši</button>
                               </form>
                           </div>
                       </div>
                   <?php endforeach; ?>

              <?php else: ?>

                    <h3>Nema te jos ni jedan post</h3>

            <?php endif; ?>



        </div>
    </div>
</main>

</body>
</html>