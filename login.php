<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava - CMS</title>
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
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .login-container p.subtitle {
            text-align: center;
            color: #777777;
            margin-bottom: 30px;
            font-size: 14px;
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
            font-size: 14px;
            font-weight: 600;
            color: #555555;
        }

        .input-group input {
            padding: 12px 15px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: #4CAF50;
        }

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

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }

        .register-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* STIL ZA KUTIJU SA GREŠKAMA */
        .error-container {
            background-color: #fdf3f2;
            border-left: 5px solid #e74c3c;
            border-radius: 6px;
            padding: 15px;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.15);
            animation: shake 0.4s ease-in-out;
        }

        .error-container p {
            color: #c0392b;
            font-size: 14px;
            font-weight: 600;
            margin: 4px 0;
        }


        .success-container {
            background-color: #e8f5e9;
            border-left: 5px solid #4CAF50;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(76, 175, 80, 0.15);
        }

        .success-container p {
            color: #2e7d32;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-5px);
            }
            40% {
                transform: translateX(5px);
            }
            60% {
                transform: translateX(-5px);
            }
            80% {
                transform: translateX(5px);
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    <?php if (isset($_SESSION['uspesno']) && !empty($_SESSION['uspesno'])): ?>
        <div class="success-container">
            <?php foreach ($_SESSION['uspesno'] as $uspeh): ?>
                <p>✅ <?= $uspeh ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['uspesno']); ?>
    <?php endif; ?>

    <h2>Prijavi se</h2>
    <p class="subtitle">Pristupi svom nalogu i upravljaj sadržajem</p>

    <!-- Forma gađa tvoj decisionMaker.php -->
    <form action="decisionMaker.php" method="POST">

        <input type="hidden" name="login">

        <div class="input-group">
            <label for="email">Email adresa</label>
            <input required type="email" id="email" name="email" placeholder="vas@email.com">
        </div>

        <div class="input-group">
            <label for="lozinka">Lozinka</label>
            <input required type="password" id="lozinka" name="lozinka" placeholder="Vaša lozinka">
        </div>


        <button type="submit" name="login">Prijavi se</button>
    </form>


    <?php if (isset($_SESSION['greska']) && !empty($_SESSION['greska'])): ?>
        <div class="error-container">
            <?php foreach ($_SESSION['greska'] as $greska): ?>
                <p>⚠️ <?= $greska ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['greska']); ?>
    <?php endif; ?>

    <div class="register-link">
        Nemate nalog? <a href="index.php">Registrujte se ovde</a>
    </div>
</div>

</body>
</html>