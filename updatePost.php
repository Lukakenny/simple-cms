<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Bezbednosna provera - da li je korisnik ulogovan
if(!isset($_SESSION['logIn']) || $_SESSION['logIn'] !== true) {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Objava - CMS</title>
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

        /* --- ZADRŽAN IDENTIČAN SIDEBAR --- */
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

        /* --- STILOVI ZA FORMU --- */
        .content-wrapper { padding: 40px; display: flex; justify-content: center; }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 800px; /* Šira kartica jer nam treba prostor za kucanje teksta */
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .input-group label {
            font-size: 15px;
            font-weight: 600;
            color: #555555;
        }

        .input-group input,
        .input-group textarea {
            padding: 12px 15px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s ease;
            width: 100%;
        }

        /* Textarea za sadržaj ima poseban stil da bude viša */
        .input-group textarea {
            min-height: 250px;
            resize: vertical; /* Dozvoljava korisniku da je razvuče na dole ako želi */
            line-height: 1.6;
        }

        .input-group input:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>CMS Admin</h2>
    </div>
    <ul class="nav-links">
        <li><a href="dashboard.php"><span>📊</span> Kontrolna tabla</a></li>
        <li><a href="blogovi.php" class="active"><span>📝</span> Objave / Blog</a></li>

    </ul>
    <div class="sidebar-footer">
        <a href="decisionMaker.php?akcija=logout" class="logout-btn">Odjavi se</a>
    </div>
</aside>

<main class="main-content">
    <header class="topbar">
        <div class="welcome-text">
            <h1>Kreiraj novu objavu</h1>
        </div>

        <a href="mojiBlogovi.php" style="color: #777; text-decoration: none; font-weight: 500;">← Nazad na tvoje objave</a>
    </header>

    <div class="content-wrapper">
        <div class="form-container">

            <form action="decisionMaker.php" method="POST">

                <input type="hidden" name="updatePost" value="<?= $_GET['id'] ?>">

                <div class="input-group">
                    <label for="naslov">Naslov objave</label>
                    <input type="text" id="naslovUpdate" name="naslovUpdate" placeholder="Unesite naslov..." required>
                </div>

                <div class="input-group">
                    <label for="sadrzaj">Sadržaj</label>
                    <textarea id="sadrzaj" name="sadrzajUpdate" placeholder="Ovde započnite pisanje vašeg blog posta..." required></textarea>
                </div>

                <button type="submit" name="azuriraj" class="submit-btn">💾 Sačuvaj izmene</button>
            </form>

        </div>
    </div>
</main>

</body>
</html>
