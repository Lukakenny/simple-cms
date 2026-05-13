<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['logIn']) || $_SESSION['logIn'] !== true)
{
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objave - Blog CMS</title>
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
            display: flex;
            justify-content: space-between;
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
            flex-grow: 1; /* Gura dugmiće na dno kartice */
        }

        .blog-actions {
                display: flex;
                gap: 10px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        /* Specifični dugmići na kartici */
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
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Pozdrav <?= $_SESSION['ime']?></h2>
        </div>
        <ul class="nav-links">
            <li><a href="dashboard.html"><span>📊</span> Kontrolna tabla</a></li>
            <li><a href="dashboard.php" class="active"><span>📝</span> Objave / Blog</a></li>

        </ul>
        <div class="sidebar-footer">
            <a href="decisionMaker.php?akcija=logout" class="logout-btn">Odjavi se</a>

        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="welcome-text">
                <h1>Sve objave</h1>
            </div>

            <a href="newPost.php" class="action-btn">+ Nova Objava</a>
        </header>

        <div class="content-wrapper">
            <div class="blog-grid">

                <!-- KARTICA 1 (Prikaz sa svim dugmićima - Admin pogled) -->
                <div class="blog-card">
                    <div class="blog-meta">
                        <span>👤 Ana Marić</span>
                        <span>📅 12. Maj 2026.</span>
                    </div>
                    <h3>Top 5 Webflow trikova za brži dizajn</h3>
                    <p>Otkrijte kako da ubrzate proces izrade sajtova koristeći napredne Webflow funkcije, komponente i prečice na tastaturi koje koriste profesionalci.</p>

                    <div class="blog-actions">
                        <a href="#" class="btn btn-read">Pročitaj sve</a>
                        <a href="#" class="btn btn-edit">✎ Izmeni</a>
                        <button class="btn btn-delete">🗑️ Obriši</button>
                    </div>
                </div>

                <!-- KARTICA 2 (Prikaz samo sa Read dugmetom - Editor pogled) -->
                <div class="blog-card">
                    <div class="blog-meta">
                        <span>👤 Marko Petrović</span>
                        <span>📅 10. Maj 2026.</span>
                    </div>
                    <h3>Uvod u PHP MVC arhitekturu</h3>
                    <p>Model-View-Controller (MVC) obrazac je standard u modernom web programiranju. Saznajte kako da organizujete svoj kod za lakše održavanje i bolju sigurnost.</p>

                    <div class="blog-actions">
                        <a href="#" class="btn btn-read">Pročitaj sve</a>
                    </div>
                </div>

                <!-- KARTICA 3 -->
                <div class="blog-card">
                    <div class="blog-meta">
                        <span>👤 Jelena Savić</span>
                        <span>📅 08. Maj 2026.</span>
                    </div>
                    <h3>Zašto je UI/UX dizajn presudan?</h3>
                    <p>Dobar dizajn nije samo estetika, već pre svega funkcionalnost. Istražujemo kako pravilno postavljene senke i tipografija poboljšavaju korisničko iskustvo na vašem sajtu.</p>

                    <div class="blog-actions">
                        <a href="#" class="btn btn-read">Pročitaj sve</a>
                        <a href="#" class="btn btn-edit">✎ Izmeni</a>
                        <button class="btn btn-delete">🗑️ Obriši</button>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>