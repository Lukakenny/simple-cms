<?php
require_once 'vendor/autoload.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logIn']) || $_SESSION['logIn'] !== true) {
    header("Location: index.php");
    exit();
}

use app\Modeli\Posts;
use app\Modeli\User;

$post = new Posts();
$allPosts = $post->getAllPosts();
$postoviZaPrikaz = $post->getPostsByCategory($_GET['kategorija']);


$kategorije = new Posts();
$sveKategorije = $kategorije->getAllCategories();


?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objave - CMS</title>
    <style>
        /* --- TVOJI OSNOVNI STILOVI KOJE SI MI POSLAO --- */
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

        .sidebar-header h2 {
            color: #333;
            font-size: 22px;
        }

        .nav-links {
            list-style: none;
            padding: 20px 0;
            flex: 1;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #555555;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-links li a:hover, .nav-links li a.active {
            background-color: #f0fdf4;
            color: #4CAF50;
            border-right: 4px solid #4CAF50;
        }

        .nav-links li a span {
            margin-right: 15px;
            font-size: 18px;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #eeeeee;
        }

        .logout-btn {
            display: block;
            text-align: center;
            background-color: #ffe6e6;
            color: #d93025;
            padding: 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        /* --- GLAVNI DEO --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .topbar {
            background-color: #ffffff;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h1 {
            font-size: 20px;
            color: #333;
        }

        .content-wrapper {
            padding: 40px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* --- STILOVI DODATI ZA KATEGORIJE I KARTICE POSTOVA --- */

        /* Filteri / Kategorije */
        .kategorije-kontejner {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .kategorija-pill {
            text-decoration: none;
            background-color: #ffffff;
            color: #555;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #e0e0e0;
            transition: all 0.2s ease;
        }

        .kategorija-pill:hover,
        .kategorija-pill.aktivna {
            background-color: #4CAF50; /* Tvoja zelena boja */
            color: white;
            border-color: #4CAF50;
        }

        /* Grid za postove */
        .postovi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        /* Kartica posta */
        .post-kartica {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .post-kartica:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .post-naslov {
            font-size: 18px;
            color: #333;
            margin: 0 0 10px 0;
            line-height: 1.4;
        }

        .post-meta {
            font-size: 13px;
            color: #888;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .post-sadrzaj {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            flex-grow: 1; /* Gura tagove na dno */
            margin-bottom: 20px;
        }

        /* Tagovi u kartici */
        .tagovi-kontejner {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-baloncic {
            background-color: #f0fdf4; /* Svetlo zelena pozadina */
            color: #2e7d32; /* Tamnija zelena za tekst */
            padding: 4px 10px;
            border-radius: 6px; /* Blago zaobljeno, uklapa se u input polja iz tvog dizajna */
            font-size: 12px;
            font-weight: 600;
        }

        .prazno-stanje {
            grid-column: 1 / -1;
            background-color: #fff;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
            color: #777;
            border: 1px dashed #ccc;
        }
    </style>
</head>
<body>

<!-- TVOJ SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Pozdrav <?= $_SESSION['ime'] ?></h2>
    </div>
    <ul class="nav-links">
        <?php if (isset($_SESSION['uloga']) && $_SESSION['uloga'] === "admin"): ?>
            <li><a href="adminDashboard.php"><span>📊</span> Kontrolna tabla</a></li>
            <li><a href="dashboard.php"><span>📝</span> Sve objave</a></li>
            <li><a href="mojiBlogovi.php"><span>📂</span> Moji blogovi</a></li>

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
            <h1>Pregled objava</h1>
        </div>

        <a href="newPost.php"
           style="background-color: #4CAF50; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; font-size: 14px;">+
            Nova objava</a>
    </header>


    <div class="content-wrapper">


        <div class="kategorije-kontejner">
            <a href="dashboard.php" class="kategorija-pill <?= !isset($_GET['kategorija']) ? 'aktivna' : '' ?>">Sve
                objave</a>

            <?php foreach ($sveKategorije as $kategorija): ?>
                <?php
                $aktivnaKlasa = (isset($_GET['kategorija']) && $_GET['kategorija'] == $kategorija['id']) ? 'aktivna' : '';
                ?>
                <a href="kategorije.php?kategorija=<?= $kategorija['id'] ?>"
                   class="kategorija-pill <?= $aktivnaKlasa ?>">
                    <?= htmlspecialchars($kategorija['naziv']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="postovi-grid">
            <?php if (!empty($postoviZaPrikaz)): ?>

                <?php foreach ($postoviZaPrikaz as $post): ?>
                    <div class="post-kartica">
                        <h2 class="post-naslov"><?= htmlspecialchars($post['naslov']) ?></h2>

                        <div class="post-meta">
                            <span>👤 <?= htmlspecialchars($post['autor']) ?></span>
                            <span>📅 <?= date('d.m.Y', strtotime($post['kreiran_u'])) ?></span>
                        </div>

                        <p class="post-sadrzaj">
                            <?= htmlspecialchars(substr($post['sadrzaj'], 0, 120)) ?>...
                        </p>

                        <!-- PHP LOGIKA ZA ISPIS TAGOVA -->
                        <?php if (!empty($post['svi_tagovi'])): ?>
                            <div class="tagovi-kontejner">
                                <?php
                                $nizTagova = explode(',', $post['svi_tagovi']);
                                foreach ($nizTagova as $tag):
                                    ?>
                                    <span class="tag-baloncic">#<?= htmlspecialchars(trim($tag)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="prazno-stanje">
                    <h3>Nema rezultata</h3>
                    <p style="margin-top: 10px;">Trenutno nema objava u ovoj kategoriji.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

</body>
</html>