<?php
    session_start();
    require_once "vendor/connect.php";

    //New books output
    $books = "SELECT
        b.bookID
        , b.title
        , b.author
        , b.image
        , (Case When SUM(r.rateIndex)/cout.cout then SUM(r.rateIndex)/cout.cout ELSE 0 END) as total
        , b.date
    FROM books AS b
    LEFT JOIN ratingsystem AS r
        ON b.bookID = r.FK_bookID
    LEFT JOIN (SELECT FK_bookID AS 'book_ID', COUNT(rateIndex) AS 'cout' FROM ratingsystem GROUP BY FK_bookID) AS cout
        ON r.FK_bookID = cout.book_ID
    GROUP BY cout.book_ID, b.bookID, cout.cout
    ORDER BY b.date desc
    LIMIT 7";
    $books_result = mysqli_query($conn, $books) or die("Connection failed");

    for ($newbookdata = []; $row = mysqli_fetch_assoc($books_result); $newbookdata[] = $row);

    //High rated books output
        $books = "SELECT
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
        GROUP BY cout.book_ID, b.bookID, cout.cout
        HAVING total >= '4'
        ORDER BY total DESC
        LIMIT 7;";
    
    $books_result = mysqli_query($conn, $books) or die("Connection failed");

    for ($ratedbookdata = []; $row = mysqli_fetch_assoc($books_result); $ratedbookdata[] = $row);

    //Popular books output
    $books = "SELECT
        b.bookID
        , b.title
        , b.author
        , b.image
        , (Case When SUM(r.rateIndex)/cout.cout then SUM(r.rateIndex)/cout.cout ELSE 0 END) as total
        , b.clicks
    FROM books AS b
    LEFT JOIN ratingsystem AS r
        ON b.bookID = r.FK_bookID
    LEFT JOIN (SELECT FK_bookID AS 'book_ID', COUNT(rateIndex) AS 'cout' FROM ratingsystem GROUP BY FK_bookID) AS cout
        ON r.FK_bookID = cout.book_ID
    GROUP BY cout.book_ID, b.bookID, cout.cout
    HAVING clicks > 0
    ORDER BY b.clicks DESC
    LIMIT 7";
    $books_result = mysqli_query($conn, $books) or die("Connection failed");

    for ($popbookdata = []; $row = mysqli_fetch_assoc($books_result); $popbookdata[] = $row);

    //Category output
    $category = "SELECT * FROM `category`";

    $category_result = mysqli_query($conn, $category);

    for ($catdata = []; $row = mysqli_fetch_assoc($category_result); $catdata[] = $row);


    //Search bar
    if (isset($_POST["submit"])) {
        $str = $_POST["search"];
        $categ = $_POST["category"];
        print_r($categ);

        if(!($categ === "Kategorijas")) {
            header("Location: search.php?category=$categ");
        }
        
        if(!($str === "")){
            header("Location: search.php?title=$str");
        }
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
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <title>Musical bot</title>
</head>
<body>

    <div class="wrapper">
        
        <?php include 'assets/views/nav-bar.php';?>
        
        <div class="main">

            <div class="search-area">
                <form method = "POST">
                    <div class="search-search-area">
                        <div class="search-bar">
                            <input type="text" name="search" placeholder="Meklēt...">
                            <button type="submit" name="submit">Mēklēt</button>
                        </div>
                        <div class="category-bar">
                            <select name="category" id="category" onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <option value="category" disabled selected>Mūzikas žanri</option>
                                <?php foreach ($catdata as $cat) { ?>
                                    <option name="category"><?= $cat['CategName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <hr color="#34344A">
            <div class="slider swiper">
                <div class="new-books">
                    <h1>Jaunākās</h1>
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($newbookdata as $book) { ?>
                                <div class="swiper-slide">
                                    <div class="book-cover mySwiper">
                                        <span class="link">
                                            <a href="book-page.php?bookID=<?= $book['bookID']; ?>" method="POST" name="clicks">
                                                <div class="book-img slide">
                                                    <img src="<?= $book['image']?>" alt="" width="170px" height="170px">
                                                </div>
                                            </a>
                                            <div class="book-title">
                                                <p class="book-name"><?= $book['title'] ?></p>
                                                <p class="author"><?= $book['author'] ?></p>
                                                <div class="rating" data-total-value="<?php echo round($book['total'], 0) ?>">
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
                            <?php }?>
                        </div>
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            </div>
            <hr color="#34344A">
            <div class="slider swiper">
                <div class="new-books">
                    <h1>Rep mūzika</h1>
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                        <?php foreach ($ratedbookdata as $book) { ?>
                                <div class="swiper-slide">
                                    <div class="book-cover mySwiper">
                                        <span class="link">
                                            <a href="book-page.php?bookID=<?=$book['bookID'];?>" name="clicks">
                                                <div class="book-img slide">
                                                    <img src="<?= $book['image']?>" alt="" width="170px" height="170px">
                                                </div>
                                            </a>
                                            <div class="book-title">
                                                <p class="book-name"><?= $book['title'] ?></p>
                                                <p class="author"><?= $book['author'] ?></p>
                                                <div class="rating" data-total-value="<?php echo round($book['total'], 0) ?>">
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
                            <?php }?>
                        </div>
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            </div>
            <hr color="#34344A">
            <div class="slider swiper">
                <div class="new-books">
                    <h1>Pop mūzika</h1>
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                        <?php foreach ($popbookdata as $book) { ?>
                                <div class="swiper-slide">
                                    <div class="book-cover mySwiper">
                                        <span class="link">
                                            <a href="book-page.php?bookID=<?=$book['bookID'];?>" name="clicks">
                                                <div class="book-img slide">
                                                    <img src="<?= $book['image']?>" alt="" width="170px" height="170px">
                                                </div>
                                            </a>
                                            <div class="book-title">
                                                <p class="book-name"><?= $book['title'] ?></p>
                                                <p class="author"><?= $book['author'] ?></p>
                                                <div class="rating" data-total-value="<?php echo round($book['total'], 0) ?>">
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
                            <?php }?>
                        </div>
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include './assets/views/footer.html';?>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="./assets/js/jquery.js"></script>
    

</body>
</html>