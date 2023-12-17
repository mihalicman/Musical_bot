<?php
    session_start();
    require_once "vendor/connect.php";

    //Exact book output
    $book_id = $_GET['bookID'];
    $book = "SELECT * FROM `books` WHERE `bookID` = '$book_id'";
    $book_result = mysqli_query($conn, $book) or die("Connection failed");
    $book_result = mysqli_fetch_assoc($book_result);

    //Rating output
    $sql = $conn->query("SELECT * FROM `ratingsystem` WHERE `FK_bookID` = '$book_id'");
    $numR = $sql->num_rows;

    $sql = $conn->query("SELECT SUM(rateIndex) AS total FROM ratingsystem WHERE `FK_bookID` = '$book_id'");
    $rData = $sql->fetch_array();
    $total = $rData['total'];

    if($total < 1 or $numR < 1) {
        $avg = 0;
    } else {
        $avg = $total / $numR;
    }

    //Books click
    if (isset($book_id)) {
        $sql = "SELECT clicks FROM `books` WHERE bookID = '$book_id'";
        $sql_result = mysqli_query($conn, $sql);
        $sql_result = mysqli_fetch_assoc($sql_result);
        $click = $sql_result['clicks'];
        $click++;

        $sql = "UPDATE `books` SET `clicks` = '$click' WHERE bookID = '$book_id'";
        $sql_result = mysqli_query($conn, $sql);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/nav-bar.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/book-page.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <title><?= $book_result['title']; ?></title>
</head>

<body>

    <?php include 'assets/views/nav-bar.php';?>

    <div class="wrapper">

        <div class="main">
            <div class="book-view">

            <div class="book-cover">
                <div class="book-img">
                    <img src="<?= $book_result['image']; ?>" alt="" width="250" height="250px">
                </div>
            </div>
                    <div class="book-content">
                    <h1 class = "title"><?= $book_result['title']; ?></h1>
                    <h2><?= $book_result['author']; ?></h2>
                    Vērtējums: 
                    <div class="rating" data-total-value="<?php echo round($avg, 0) ?>">
                        <div class="rating-item" data-item-value="5">★</div>
                        <div class="rating-item" data-item-value="4">★</div>
                        <div class="rating-item" data-item-value="3">★</div>
                        <div class="rating-item" data-item-value="2">★</div>
                        <div class="rating-item" data-item-value="1">★</div>
                    </div>
                    
                    <div class="button-read">
                    
                        <?php
                            //Session check for download
                            if (isset($_SESSION['user'])) {
                                echo '<a href="" download="' . $book_result["title"] . ".pdf" . '">Klausīties</a>';
                            } else{ 
                                echo '<a>Lasīt</a>';
                            }
                        ?>
                        <a href="vendor/addfavourites.php?bookID=<?=$book_id;?>">Pievienot favorītiem</a>
                        <?php 
                            if (isset($_SESSION['message'])) {
                            echo '<p class="msg"> ' . $_SESSION['message'] .'</p>';
                            }
                            unset($_SESSION['message']);
                        ?>
                    </div>
                </div>
            </div>

            <div class="book-description">
                <h1>Apraksts</h1>
                <span class="description"><?= $book_result['description']; ?></span>
            </div>
        </div>

        <?php include 'assets/views/footer.html';?>

    </div>
    
    <script src="./jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        const ratingItemsList = document.querySelectorAll('.rating-item');
        const ratingItemsArray = Array.prototype.slice.call(ratingItemsList);
        ratingItemsArray.forEach(item => 
            item.addEventListener('click', () => {
                const userID = <?php echo $_SESSION['user']['userID'] ?>;
                const bookID = <?php echo $_GET['bookID'] ?>;
                const { itemValue } = item.dataset;
                item.parentNode.dataset.totalValue = itemValue;

                $.ajax({
                    url: "vendor/rating.php",
                    type: 'POST',
                    data: {
                        userID: userID,
                        bookID: bookID,
                        itemValue: itemValue
                    },
                    beforeSend: ()=>{},
                    success: (data)=>{
                        console.log(data);
                    },
                    error: (xhr)=>{
                        console.log(xhr);
                    },
                    complete: ()=>{
                    }
                });
            })
        );
    </script>
</body>
</html>