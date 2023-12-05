<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rennrad Werk - Anmeldung</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Gemeinsamer CSS-Stil */
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Kumbh Sans', sans-serif;
}

body {
    background-color: #141414;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Anmeldeformular-Stil */
form {
    background-color: #000;
    padding: 40px;
    border-radius: 8px;
    text-align: center;
}

form input[type="text"],
form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 4px;
    border: none;
    background-color: #fff;
    color: #000;
}

form button[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 4px;
    background-color: #f77062;
    color: #fff;
    cursor: pointer;
    transition: all 0.35s ease;
}

form button[type="submit"]:hover {
    background-color: #4837ff;
}

.register-button {
    display: block;
    margin-top: 10px;
    text-decoration: none;
    color: #f77062;
    font-weight: bold;
}
    </style>
</head>
<body>

<!-- Header und Titel -->
<header>
    <a href="index.html">
        <h1>Rennrad Werk</h1>
    </a>
</header>

<!-- Navbar -->
<nav class="navbar">
    <!-- ... (Dein Navbar-Code hier) -->
</nav>

<!-- Anmeldeformular -->
<?php
session_start();
require("mysql.php");
    
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["pw"];
    
    $stmt = $dbh->prepare("SELECT * FROM accounts WHERE username = :user");
    $stmt->execute(['user' => $username]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            header("Location: index.html");
            exit();
        } else {
            echo "Der Login ist fehlgeschlagen";
        }
    } else {
        echo "Der Login ist fehlgeschlagen";
    }
}
?>
<form action="index.php" method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="pw" placeholder="Passwort" required><br>
    <button type="submit" name="submit">Einloggen</button>
    <a href="register.php" class="register-button">Account erstellen</a>
</form>

</body>
</html>
