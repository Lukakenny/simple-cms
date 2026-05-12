<?php
require_once 'vendor/autoload.php';

if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}


?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija - CMS</title>
    <style>
        /* Osnovno resetovanje i font */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Pozadina celog ekrana - centriranje kartice */
        body {
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Glavna bela kartica za formu */
        .register-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Naslov i podnaslov */
        .register-container h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .register-container p {
            text-align: center;
            color: #777777;
            margin-bottom: 30px;
            font-size: 14px;
        }

        /* Flexbox forma da ide jedno ispod drugog */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Grupa za svaki input (Label + Input) */
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .input-group label {
            font-size: 14px;
            font-weight: 600;
            color: #555555;
        }

        .input-group input,
        .input-group select {
            padding: 12px 15px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        /* Efekat kada korisnik klikne na polje da kuca */
        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        /* Dugme za registraciju */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Link za povratak na Login */
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }

        .login-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-container {
            background-color: #fdf3f2;
            border-left: 5px solid #e74c3c;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.15);
            animation: shake 0.4s ease-in-out;
        }


        .error-container p {
            color: #c0392b;
            font-size: 14px;
            font-weight: 600;
            margin: 4px 0;
        }


        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-5px); }
            40% { transform: translateX(5px); }
            60% { transform: translateX(-5px); }
            80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Napravi nalog</h2>
    <p>Pridruži se našem CMS sistemu</p>

    <form action="decisionMaker.php" method="POST">

        <input type="hidden" name="register">

        <div class="input-group">
            <label for="ime">Ime i prezime</label>
            <input  type="text" id="ime" name="ime" placeholder="Unesite vaše ime" required>
        </div>

        <div class="input-group">
            <label for="email">Email adresa</label>
            <input  type="email" id="email" name="email" placeholder="vas@email.com" required>
        </div>

        <div class="input-group">
            <label for="lozinka">Lozinka</label>
            <input  type="password" id="lozinka" name="lozinka" placeholder="Unesite jaku lozinku" minlength="4" required>
        </div>

        <button type="submit">Registruj se</button>
    </form>

    <?php if (isset($_SESSION['greska']) && !empty($_SESSION['greska'])): ?>

        <div class="error-container">
            <?php foreach ($_SESSION['greska'] as $greska): ?>

                <p>⚠️ <?= $greska ?></p>
            <?php endforeach; ?>
        </div>

        <?php
        unset($_SESSION['greska']);
        ?>

    <?php endif; ?>





    <div class="login-link">
        Već imate nalog? <a href="login.php">Prijavite se ovde</a>
    </div>


</div>

</body>
</html>



