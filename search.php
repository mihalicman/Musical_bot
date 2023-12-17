<?php 
    session_start();
    require_once "vendor/connect.php";
    
    //Search by title
    if(isset($_GET['title'])) {
        $str = $_GET['title'];
        $sth = "SELECT
                b.bookID
                , b.title
                , b.author
                , b.image
                , (Case When SUM(r.rateIndex)/cout.cout then SUM(r.rateIndex)/cout.cout ELSE 0 END) as total
            FROM books AS b
            LEFT JOIN ratingsystem AS r
                ON b.bookID = r.FK_bookID
            LEFT JOIN (SELECT FK_bookID AS 'book_ID', COUNT(rateIndex) AS 'cout' FROM ratingsystem GROUP BY FK_bookID) AS cout
                ON r.FK_bookID = cout.book_ID
            WHERE b.`title` LIKE '%$str%'
            GROUP BY cout.book_ID, b.bookID, cout.cout";
        
        $sth_result = mysqli_query($conn, $sth);
        for ($sthdata = []; $row = mysqli_fetch_assoc($sth_result); $sthdata[] = $row);
    }

    //Search by category
    if(isset($_GET['category'])) {
        $str = $_GET['category'];
        if ($str === "") {
            header("Location: index.php");
        }
        $sth = "SELECT
                b.bookID
                , b.title
                , b.author
                , b.image
                , (Case When SUM(r.rateIndex)/cout.cout then SUM(r.rateIndex)/cout.cout ELSE 0 END) as total
            FROM books AS b
            LEFT JOIN ratingsystem AS r
                ON b.bookID = r.FK_bookID
            LEFT JOIN (SELECT FK_bookID AS 'book_ID', COUNT(rateIndex) AS 'cout' FROM ratingsystem GROUP BY FK_bookID) AS cout
                ON r.FK_bookID = cout.book_ID
            WHERE b.`category` LIKE '%$str%'
            GROUP BY cout.book_ID, b.bookID, cout.cout";

        $sth_result = mysqli_query($conn, $sth);
        for ($sthdata = []; $row = mysqli_fetch_assoc($sth_result); $sthdata[] = $row);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/nav-bar.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/book.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/search.css">
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
    <title>Mēklēt pēc vārda <?php echo $str?></title>
</head>
<body>
    <div class="wrapper">

        <?php include 'assets/views/nav-bar.php';?>
            
            <div class="main">
                <h1 class="title">Meklēšanas rezultāti "<?php echo $str?>"</h1>
                <div class="main-book-row">
                <?php if($sthdata) {
                    foreach ($sthdata as $row) {?>
                    <div class="book-row">
                        <div class="swiper-slide">
                        <div class="book-cover mySwiper">
                            <span class="link">
                                <a href="book-page.php?bookID=<?=$row['bookID'];?>">
                                    <div class="book-img slide">
                                        <img src="<?= $row['image']?>" alt="" width="170px" height="220px">
                                    </div>
                                </a>
                                <div class="book-title">
                                    <p class="book-name"><?= $row['title'] ?></p>
                                    <p class="author"><?= $row['author'] ?></p>
                                    <div class="rating" data-total-value="<?php echo round($row['total']) ?>">
                                        <div class="rating-item" data-item-value="5">★</div>
                                        <div class="rating-item" data-item-value="4">★</div>
                                        <div class="rating-item" data-item-value="3">★</div>
                                        <div class="rating-item" data-item-value="2">★</div>
                                        <div class="rating-item" data-item-value="1">★</div>
                                    </div>
                                </div>
                            </span>
                        </div>
                        </div>
                    </div>
                <?php }
                } else {
                    echo "Pēc Jūsu pieprasījuma nekas nebija atrasts";
                }?>
                </div>
            </div>

        <?php include './assets/views/footer.html';?>
    </div>
</body>
</html>