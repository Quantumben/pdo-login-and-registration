<?php
define('BASEPATH', true); //access connection script if you omit this line file will be blank
require './db.php'; //require connection script

if (isset($_POST['submit'])) {
    try {
        $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));

        //Check if username exists
        $sql = "SELECT COUNT(username) AS num FROM register WHERE username =      :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':username', $user);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['num'] > 0) {
            echo '<script>alert("Username already exists")</script>';
        } else {

            $stmt = $dsn->prepare("INSERT INTO register (username, email, password) 
    VALUES (:username,:email, :password)");
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $pass);



            if ($stmt->execute()) {
                echo '<script>alert("New account created.")</script>';
                //redirect to another page
                echo '<script>window.location.replace("index.php")</script>';
            } else {
                echo '<script>alert("An error occurred")</script>';
            }
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        echo '<script type="text/javascript">alert("' . $error . '");</script>';
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>

<body>

    <form action="register.php" method="post">
        <input type="text" required="required" name="username" placeholder="Username">
        <input required="required" type="email" name="email" placeholder="Email">
        <input required="required" type="password" name="password" placeholder="Password">
        <button name="submit" type="submit">register</button>
    </form>
</body>

</html>