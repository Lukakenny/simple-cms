<?php


require_once 'vendor/autoload.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['logIn']) || $_SESSION['logIn'] !== true || !isset($_SESSION['uloga']) || $_SESSION['uloga'] !== 'admin') {

    header("Location: index.php");
    exit();
}

use app\Modeli\Posts;
use app\Modeli\User;

$users = new User();
$allUsers = $users->getAllUsers();
$posts = new Posts();
$allPosts = $posts->getAllPosts();


?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CMS</title>
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
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        /* --- STATISTIKE (KARTICE NA VRHU) --- */
        .stats-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            flex: 1;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .stat-card h3 {
            color: #777;
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .number {
            font-size: 40px;
            font-weight: bold;
            color: #4CAF50;
        }

        /* --- LISTA POSTOVA --- */
        .section-title {
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
            border-bottom: 2px solid #4CAF50;
            display: inline-block;
            padding-bottom: 5px;
        }

        .post-item {
            display: flex;
            flex-direction: row;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px 25px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s ease;
        }

        .post-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }


        .post-info h4 {
            color: #333;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .post-info p {
            color: #777;
            font-size: 13px;
        }

        /* --- DUGME ZA BRISANJE --- */
        .btn-delete {
            background-color: #ffe6e6;
            color: #d93025;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #ffcccc;
        }

    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Pozdrav <?= $_SESSION['ime'] ?></h2>
    </div>
    <ul class="nav-links">
        <li><a href="adminDashboard.php" class="active"><span>📊</span> Kontrolna tabla</a></li>
        <li><a href="dashboard.php"><span>📝</span> Sve objave</a></li>
        <li><a href="mojiBlogovi.php"><span>📂</span> Moji blogovi</a></li>
    </ul>
    <div class="sidebar-footer">
        <a href="decisionMaker.php?akcija=logout" class="logout-btn">Odjavi se</a>
    </div>
</aside>

<main class="main-content">
    <header class="topbar">
        <div class="welcome-text">
            <h1>Dobrodošli, Administratore</h1>
            <p style="color: #777; font-size: 14px; margin-top: 5px;">Pregled sistema i upravljanje sadržajem.</p>
        </div>
    </header>

    <div class="content-wrapper">


        <div class="stats-grid">
            <div class="stat-card">
                <h3>Ukupno Objava</h3>
                <div class="number"><?= count($allPosts) ?></div>
            </div>
            <div class="stat-card">
                <h3>Ukupno Korisnika</h3>
                <div class="number"><?= count($allUsers) ?></div>
            </div>
        </div>


        <h2 class="section-title">Upravljanje objavama</h2>

        <?php if (!empty($allPosts)) : ?>
            <?php foreach ($allPosts as $post) : ?>

                <div class="post-item">
                    <div class="post-info">
                        <h4><?= $post['naslov'] ?></h4>
                        <p><?= $post['autor'] ?> | <?= $post['kreiran_u'] ?></p>
                    </div>
                    <form action="decisionMaker.php" method="POST" style="display:inline;">
                        <input type="hidden" name="deleteAdmin" value="<?= $post['id'] ?>">
                        <button type="submit" name="obrisiBlog" class="btn-delete">🗑️ Obriši</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h3 style="margin-top: 20px; color: #777;">Nema ni jednog posta</h3>
        <?php endif; ?>


    </div>


</main>

</body>
</html>
