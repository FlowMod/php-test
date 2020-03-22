<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=web', 'root', 'topsecret');
 
if(isset($_GET['login'])) {
    $name = $_POST['user'];
    $password = $_POST['password'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE user = :user");
    $result = $statement->execute(array('user' => $name));
    $user = $statement->fetch();
	
    if ($user !== false && password_verify($password, $user['password'])) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="dashboard.php">internen Bereich</a>');
    } else {
        $errorMessage = "Benutzername oder Passwort war ungültig<br>";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<?php 
    if(isset($errorMessage)) {
        echo $errorMessage;
    }
    ?>
 
    <form action="?login=1" method="post">
        <p>Benutzername:</p>
        <input type="text" name="user"><br><br>
 
        <p>Passwort:</p>
        <input type="password" name="password"><br>
 
        <input type="submit">
    </form>
</body>
</html>