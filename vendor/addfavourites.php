<?php
    session_start();
    require_once 'connect.php';

    $fav_id = $_GET['bookID'];
    
    //Session check for books add
    if(!$_SESSION['user']) {
        $_SESSION['message'] = 'Jūms jāpierēģistrējas!';
        header("Location: ../book-page.php?bookID=$fav_id");
    }

    //Fav Book add
    if (isset($fav_id)) {
        $user_id = $_SESSION['user']['userID'];
        $fav = "SELECT * FROM `favourites` WHERE `FK_userID`= '$user_id' and FK_booksID = '$fav_id'";
        $fav = mysqli_query($conn, $fav);

        if (mysqli_num_rows($fav) > 0) {
            
            header("Location: ../book-page.php?bookID=$fav_id");
            
        } else {
            $books_add = "INSERT INTO `favourites` (`FK_booksID`, `FK_userID`) VALUES ('$fav_id', '$user_id');";
            mysqli_query($conn, $books_add) or die(mysqli_error($conn));

            header("Location: ../book-page.php?bookID=$fav_id");
        }
    }
?>