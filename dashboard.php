<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$worked_hours = [
    ['user' => 'daria', 'date' => '2024-05-01', 'hours' => 8, 'description' => 'Userstory'],
    ['user' => 'daria', 'date' => '2024-05-02', 'hours' => 6, 'description' => 'Project A'],
    ['user' => 'jan',   'date' => '2024-05-01', 'hours' => 9, 'description' => 'Userstory 2'],
];

$username = $_SESSION['username'];
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $role === 'medewerker') {
    // Save new work hours into session (simulation)
    $new_entry = [
        'user' => $username,
        'date' => $_POST['date'],
        'hours' => $_POST['hours'],
        'description' => $_POST['description'],
    ];

    if (!isset($_SESSION['logged_hours'])) {
        $_SESSION['logged_hours'] = [];
    }

    $_SESSION['logged_hours'][] = $new_entry;
}

// Combine hardcoded + session-stored hours
$all_hours = $worked_hours;

if (isset($_SESSION['logged_hours'])) {
    $all_hours = array_merge($all_hours, $_SESSION['logged_hours']);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<link rel="stylesheet" href="table.css">
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welkom, <?= htmlspecialchars($username) ?>!</h2>
    
    <?php if ($role === 'medewerker'): ?>
        <p>Je kunt hier je gewerkte uren registreren:</p>
        <form method="post">
            <label>Datum: <input type="date" name="date" required></label><br><br>
            <label>Uren: <input type="number" name="hours" required min="1" max="24"></label><br><br>
            <label>Beschrijving:<br>
                <textarea name="description" required rows="3" cols="40"></textarea>
            </label><br><br>
            <button type="submit">Uren opslaan</button>
        </form>
    <?php endif; ?>

    <h3>Gewerkte uren</h3>
    <table>
        <tr>
            <th>Gebruiker</th>
            <th>Datum</th>
            <th>Uren</th>
            <th>Beschrijving</th>
        </tr>
        <?php foreach ($all_hours as $entry): ?>
            <?php if ($role === 'afdelingshoofd' || $entry['user'] === $username): ?>
                <tr>
                    <td><?= htmlspecialchars($entry['user']) ?></td>
                    <td><?= htmlspecialchars($entry['date']) ?></td>
                    <td><?= htmlspecialchars($entry['hours']) ?></td>
                    <td><?= htmlspecialchars($entry['description']) ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

</body>
</html>