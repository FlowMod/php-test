<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=web', 'root', 'topsecret');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrieren</title>
</head>
<body>
    <?php
    $form = true;
 
    if(isset($_GET['register'])) {
        $error = false;
        $name = $_POST['user'];
        $email = $_POST['email'];
        $pw = $_POST['pw'];
        $pw2 = $_POST['pw2'];

        if($pw != $pw2) {
            echo 'Die Passwörter müssen übereinstimmen<br>';
            $error = true;
        }

        if(!$error) { 
            $statement = $pdo->prepare("SELECT * FROM users WHERE user = :user");
            $result = $statement->execute(array('user' => $name));
            $user = $statement->fetch();
            
            if($user !== false) {
                echo 'Dieser Benutzername ist bereits vergeben<br>';
                $error = true;
            }    
        }

        if(!$error) { 
            $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $result = $statement->execute(array('email' => $email));
            $user = $statement->fetch();
            
            if($user !== false) {
                echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
                $error = true;
            }    
        }
        
        if(!$error) {    
            $passwort_hash = password_hash($pw, PASSWORD_DEFAULT);
            
            $statement = $pdo->prepare("INSERT INTO users (user, email, password) VALUES (:user, :email, :password)");
            $result = $statement->execute(array('user' => $name, 'email' => $email, 'password' => $passwort_hash));

            if($result) {        
                echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
                $form = false;
            } else {
                echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
            }
        } 
    }

    if($form) {
    ?>

    <form action="?register=1" method="POST">
        <p>Benutzername:</p>
        <input type="text" name="user">

        <p>E-Mail:</p>
        <input type="text" name="email">

        <p>Passwort:</p>
        <input type="password" name="pw">

        <p>Passwort bestätigen:</p>
        <input type="password" name="pw2">

        <input type="submit">
    </form>

    <?php
    }
    ?>
</body>
</html>