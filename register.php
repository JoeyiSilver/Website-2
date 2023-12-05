<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Account erstellen</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/f59e3fbd77.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Gemeinsamer CSS-Stil */
        /* ... */

        /* Login-Stil (aus style.css) */
        /* ... */

        /* Hero Section CSS (aus style.css) */
        /* ... */

        /* Anmeldeformular-Stil */
        body {
            background-color: #141414;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Kumbh Sans', sans-serif;
        }

        .form_container {
            max-width: 400px;
            width: 100%;
            padding: 40px;
            background-color: #141414;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .form_container h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
            text-align: center;
        }

        .form_container input[type="text"],
        .form_container input[type="password"],
        .form_container button {
            margin-bottom: 20px;
            width: calc(100% - 20px);
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form_container button {
            background-color: #ff8177;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form_container button:hover {
            background-color: #ff0844;
        }

        .form_container a {
            text-decoration: none;
            color: #fff;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Anmeldeformular -->
<?php
if (isset($_POST["submit"])) {
    require("mysql.php");
    $stmt = $dbh->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
    $stmt->bindParam(":user", $_POST["username"]);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count == 0) {
        // Username is available
        if ($_POST["pw"] == $_POST["pw2"]) {
            // Create user
            $stmt = $dbh->prepare("INSERT INTO accounts (USERNAME, PASSWORD) VALUES (:user, :pw)");
            $stmt->bindParam(":user", $_POST["username"]);
            $hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
            $stmt->bindParam(":pw", $hash);
            $stmt->execute();
            echo "Your account has been created";
        } else {
            echo "The passwords do not match";
        }
    } else {
        echo "The username is already taken";
    }
}
?>
<div class="form_container">
    <h1>Account erstellen</h1>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="pw" placeholder="Passwort" required><br>
        <input type="password" name="pw2" placeholder="Passwort wiederholen" required><br>
        <button type="submit" name="submit">Erstellen</button>
    </form>
    <br>
    <a href="anmeldung.php">Hast du bereits einen Account?</a>
</div>

</body>
</html>
