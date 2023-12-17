<?php
include "connect.php";

//Book update
$user_id = $_POST['userID'];
$email = $_POST['email'];
$username = $_POST['username'];
$admin = $_POST['admin'];

mysqli_query($conn, "UPDATE `users` SET `email` = '$email', `username` = '$username', `admin` = '$admin' WHERE `userID` = '$user_id';");

header('Location: /Re-Books/admin.php');
?>