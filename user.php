<?php
    session_start();
    require_once "vendor/connect.php";
    
    //Session check
    if (!$_SESSION['user']) {
        header('Location: index.php');
    }

    //User check
    if (isset($_SESSION['user'])) {
        $admin = $_SESSION['user']['admin'];
        //print_r($admin);

        if ($admin <> 0)
        {
            header('Location: ./admin.php');
        }
    }

    //Favourite books output
    $user_id = $_SESSION['user']['userID'];

    $favoruites = "SELECT * 
    FROM `favourites` AS f
    INNER JOIN `books` AS b
        ON f.FK_booksID = b.bookID
    INNER JOIN `users` AS u
        ON f.FK_userID = u.userID
    WHERE f.FK_userID = '$user_id'
    ORDER BY b.title ASC";
    
    $favoruites_result = mysqli_query($conn, $favoruites) or die("Connection failed");
    
    for ($favoruitedata = []; $row = mysqli_fetch_assoc($favoruites_result); $favoruitedata[] = $row);

    //Book delete from favourites
    if (isset($_GET['delfav'])) {
        $favourite_id = $_GET['delfav'];

        $books_del = "DELETE FROM `favourites` WHERE `favouritesID` = $favourite_id";
        //echo $books_del;
        mysqli_query($conn, $books_del) or die(mysqli_error($conn));
        header('Location: ./admin.php');
    }

    //Favourite book search
    if(isset($_POST['search-book'])) {
        $bookstr = $_POST['title'];
        if(($bookstr === "")) {
            $books = "SELECT * 
            FROM `favourites` AS f
            INNER JOIN `books` AS b
                ON f.FK_booksID = b.bookID
            INNER JOIN `users` AS u
                ON f.FK_userID = u.userID
            WHERE f.FK_userID = '$user_id'";
            $books_result = mysqli_query($conn, $books) or die("Connection failed");
            
            for ($favoruitedata = []; $row = mysqli_fetch_assoc($books_result); $favoruitedata[] = $row);
        } else {
            $sth = "SELECT * 
            FROM `favourites` AS f
            INNER JOIN `books` AS b
                ON f.FK_booksID = b.bookID
            INNER JOIN `users` AS u
                ON f.FK_userID = u.userID
            WHERE f.FK_userID = '$user_id' AND b.`title` LIKE '%$bookstr%'";
            
            $sth_result = mysqli_query($conn, $sth);
            for ($favoruitedata = []; $row = mysqli_fetch_assoc($sth_result); $favoruitedata[] = $row);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="./assets/css/nav-bar.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <title>Username</title>
</head>
<body>

    <div class="wrapper">
        <?php include 'assets/views/nav-bar.php';?>

        <div class="main">
            <div>
                <div class="container vl">
                    <!-- <a href="#"> -->
                        <div class="title hl">
                            <h1>Music bot</h1>
                        </div>
                    <!-- </a> -->
                    <a href="#">
                        <div class="books hl"> 
                            <h2>Izveidotā mūzika</h2>
                        </div>
                    </a>
                </div>
                <div class="information-container">
                    <form method="POST">
                        <div class="search-area">
                            <div class="search-bar">
                                <input type="text" name="title" placeholder="Meklēt...">
                                <button type="submit" name="search-book">Meklēt</button>
                            </div>
                        
                    </form>
                            <a class="leave-button" href="vendor/sign/logout.php">Iziet</a>
                        </div>

                    <div class="books-table scroll">

                        <div class="fav-book-container">
                            <?php foreach ($favoruitedata as $favoruite) { ?>
                                <div class="fav-book">
                                    <div>
                                        <h2><?= $favoruite['title'] ?></h2>
                                    </div>
                                    <div class="object-to-right">
                                        <a href="book-page.php?bookID=<?= $favoruite['bookID']; ?>" class="read-button">Klausīties</a> 
                                        <a href="?delfav=<?=$favoruite['favouritesID'];?>"><button class="delete-button">Dzēst</button></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                    
            </div>
        </div>

        <?php include 'assets/views/footer.html';?>

    </div>

    
    <script src="jquery.js"></script>
</body>
</html>