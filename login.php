<?php
session_start();

// Simulated "mini database" of users
$users = [
    'alice' => ['password' => '1234', 'role' => 'worker'],
    'charlie' => ['password' => '5678', 'role' => 'worker'],
    'bob'   => ['password' => 'admin', 'role' => 'department_head'],
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Onjuiste gebruikersnaam of wachtwoord!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
          <link rel="stylesheet" href="login.css">
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Welkom bij het login scherm van Tilburg10!</h1>
<h2>Login om door te gaan naar het formulier</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Gebruikersnaam:</label>
        <input type="text" name="username" required>
        <br>
        <label>Wachtwoord:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Inloggen</button>
    </form>

    <div class="ButtonBack"> 
  <a href="opdrachten.html" target="_self" ><button>Terug</button></a>
    </div>

</body>
</html>
