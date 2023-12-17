<?php
    session_start();
    require_once 'connect.php';

    //Rating add
    if(isset($_SESSION['user'])) {
        $userID = $_POST['userID'];
        $bookID = $_POST['bookID'];
        $itemValue = $_POST['itemValue'];

        $query = mysqli_query($conn, "SELECT * FROM `ratingsystem` WHERE FK_bookID = '$bookID' AND FK_userID = '$userID'");
        if(mysqli_num_rows($query) > 0) {
            $query = "UPDATE `ratingsystem` SET `rateIndex` = '$itemValue' WHERE FK_bookID = '$bookID' AND FK_userID = '$userID'";
            mysqli_query($conn, $query);
        } else {
            $query = "INSERT INTO `ratingsystem` (`rateIndex`, `FK_userID`, `FK_bookID`) VALUES ('$itemValue', '$userID', '$bookID')";
            mysqli_query($conn, $query) or die(mysqli_error($conn));
        }
    } else {
        echo 'register';
    }
?>