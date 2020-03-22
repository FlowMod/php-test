<?php
session_start();
if(isset($_SESSION['userid'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
</body>
</html>

<?php
} else {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}
?>