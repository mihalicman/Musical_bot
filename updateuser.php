<?php
    include "vendor/connect.php";

    $user_id = $_GET['userID'];
    //print_r($book_id);
    $user = mysqli_query($conn, "SELECT * FROM `users` WHERE userID = '$user_id'");
    $user = mysqli_fetch_assoc($user);
    //print_r($book);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/nav-bar.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/update.css">
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Udpate user</title>
</head>
<body>
    <div class='main'>
    <div class="add-menu popUpWrapper">
        <!-- <a onclick="closePopup()"><button class="closePopup" id="closePopup">X</button></a> -->
        <form action="vendor/updateuser.php" method="POST" enctype="multipart/form-data"> 
            <div class="popUpInputs">
                <h1>Atjaunot</h1>
                <input type="hidden" name="userID" value="<?=$user['userID'];?>">
                <p>Email</p>
                <input type="text" name="email" value="<?=$user['email'];?>">
                <p>Lietotājvārds</p>
                <input type="text" name="username" value="<?=$user['username'];?>">
                <p>Admin</p>
                <input type="text" name="admin" value="<?=$user['admin'];?>">
                <div style="margin-top: 20px;">
                    <button type="submit" class="update-book" name="update-book">Atjaunot lietotāju</button>
                <div>
            </div>
        </form>   
    </div>  
    </div>
</body>
</html>

