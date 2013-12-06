<?php
try {
    $dbh = new PDO("mysql:host=localhost;dbname=cms", "root", "");
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}

$query = "SELECT * FROM `users` WHERE LOWER(`username`) = :username";
$stmt = $dbh->prepare($query);
$stmt->bindValue(':username', strtolower($_POST['username']));
$stmt->execute();

if ($stmt->rowCount() == 1) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    require('blowfish.class.php');
    $bcrypt = new Bcrypt(4);
    if ($bcrypt->verify($_POST['password'], $row['password'])) {
        echo "Logged in";
    }
}
