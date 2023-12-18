<?php
    session_start();
    require_once "vendor/connect.php";

    //Session check
    if (!$_SESSION['user']) {
        $admin = $_SESSION['user']['admin'];
        //print_r($admin);
        
        if ($admin <> 1)
        {
            header('Location: ./index.php');
        }
    }

    //Admin check
    if (isset($_SESSION['user'])) {
        $admin = $_SESSION['user']['admin'];
        //print_r($admin);
        
        if ($admin <> 1)
        {
            header('Location: ./user.php');
        }
    }

    //Books delete
    if (isset($_GET['delbook'])) {
        $book_id = $_GET['delbook'];
        $books_del = "DELETE FROM `ratingsystem` WHERE `FK_bookID` = $book_id";
        mysqli_query($conn, $books_del) or die(mysqli_error($conn));

        $books_del = "DELETE FROM `favourites` WHERE `FK_booksID` = $book_id";
        mysqli_query($conn, $books_del) or die(mysqli_error($conn));

        $books_del = "DELETE FROM `books` WHERE `bookID` = $book_id";
        //echo $books_del;
        mysqli_query($conn, $books_del) or die(mysqli_error($conn));
        header('Location: ./admin.php');
    }

    //Books add
    if (isset($_POST['add-book'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $image = $_FILES['image'];
        $category = $_POST['category'];
        $date = $_POST['date'];
        
        $path = 'uploads/' . time() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], './' . $path);

        $books_add = "INSERT INTO `books` (`title`, `author`, `description`, `image`, `category`, `date`) VALUES ('$title', '$author', '$description', '$path', '$category', '$date')";
        mysqli_query($conn, $books_add) or die(mysqli_error($conn));
        header('Location: ./admin.php');
    } 

    //Books output
    $books = "SELECT * FROM `books` ORDER BY title ASC";
    $books_result = mysqli_query($conn, $books) or die("Connection failed");
        
    for ($bookdata = []; $row = mysqli_fetch_assoc($books_result); $bookdata[] = $row);

    //Users output
    $users = "SELECT * FROM `users`";
    $users_result = mysqli_query($conn, $users) or die("Connection failed");
 
    for ($userdata = []; $row = mysqli_fetch_assoc($users_result); $userdata[] = $row);

    //User delete
    if (isset($_GET['deluser'])) {
        $user_id = $_GET['deluser'];

        $users_del = "DELETE FROM `users` WHERE userID = $user_id";
        //echo $books_del;
        mysqli_query($conn, $users_del) or die(mysqli_error($conn));
        
        header('Location: ./admin.php');
    }

    //Category output
    $category = "SELECT * FROM `category`";
    $category_result = mysqli_query($conn, $category);

    for ($catdata = []; $row = mysqli_fetch_assoc($category_result); $catdata[] = $row);

    //Search for book
    if(isset($_POST['search-book'])) {
        $bookstr = $_POST['title'];
        if(($bookstr === "")) {
            $books = "SELECT * FROM `books`";
            $books_result = mysqli_query($conn, $books) or die("Connection failed");
                
            for ($bookdata = []; $row = mysqli_fetch_assoc($books_result); $bookdata[] = $row);
        } else {
            $sth = "SELECT * FROM `books` WHERE `title` LIKE '%$bookstr%'";
            
            $sth_result = mysqli_query($conn, $sth);
            for ($bookdata = []; $row = mysqli_fetch_assoc($sth_result); $bookdata[] = $row);
        }
    }

    //Search for user
    if(isset($_POST['search-user'])) {
        $userstr = $_POST['username'];

        if(($userstr === "")) {
            $users = "SELECT * FROM `users`";
            $users_result = mysqli_query($conn, $users) or die("Connection failed");

            for ($userdata = []; $row = mysqli_fetch_assoc($users_result); $userdata[] = $row);
        } else {
            $sth = "SELECT * FROM `users` WHERE `username` LIKE '%$userstr%'";

            $sth_result = mysqli_query($conn, $sth);
            for ($userdata = []; $row = mysqli_fetch_assoc($sth_result); $userdata[] = $row);
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
    <link rel="stylesheet" href="./assets/css/admin.css">
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <title>Admin panel</title>
</head>
<body>    

    <div class="wrapper">

        <?php include 'assets/views/nav-bar.php';?>

        <div class="main">
            <div>
                <div class="container vl">
                    <!-- <a href="#"> -->
                        <div class="title hl">
                            <h1>Musical bot</span></h1>
                        </div>
                    <!-- </a> -->
                    <a href="#" onclick="books()">
                        <div class="books hl"> 
                            <h2>Izveidotā mūzika</h2>
                        </div>
                    </a>

                    <a href="#" onclick="users()">
                        <div class="users hl">
                            <h2>Lietotāji</h2>
                        </div>
                    </a>
                </div>
                <div class="information-container">
                    <div id="books">
                    <form method="POST">
                        <div class="search-area">
                                <div class="search-bar">
                                    <input type="text" name="title" placeholder="Meklēt pēc nosaukuma">
                                    <button type="submit" name="search-book">Meklēt</button>
                                </div>
                    </form>

                            <a href="vendor/sign/logout.php" class="leave-button">Iziet</a>
                            
                        </div>

                        <div class="books-table scroll">
                            <div class="fav-book-container">
                                <?php foreach ($bookdata as $book) {?>
                                    <div class="fav-book">
                                        <div>
                                            <h2><?= $book['title'] ?></h2>
                                        </div>
                                        <div class="object-to-right">
                                            <a href="book-page.php?bookID=<?=$book['bookID'];?>"><button class="read-button" >Klausīties</button></a>
                                            <button class="edit-button" name="edit-book">Redigēt</button>
                                            <a href="?delbook=<?=$book['bookID'];?>">
                                                <button class="delete-button">Dzēst</button>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div id="users" style="display:none;">
                        <form method="POST">
                            <div class="search-area">
                                <div class="search-bar">
                                    <input type="text" name="username" placeholder="Meklēt pēc nosaukuma">
                                    <button type="submit" name="search-user">Meklēt</button>
                                </div>
                        </form>

                        <a href="vendor/sign/logout.php" class="leave-button">Iziet</a>
                        
                            </div>
                        
                        <div class="books-table scroll">
                            <div class="fav-book-container">
                                <?php foreach ($userdata as $user) { ?>
                                    <div class="fav-book">
                                        <div>
                                            <h2><?= $user['username'] ?></h2>
                                        </div>
                                        <div class="object-to-right-users">
                                            <button class="edit-button">Redigēt</button>
                                            <a href="?deluser=<?=$user['userID'];?>"><button class="delete-button">Dzēst</button></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <button class="add-button" id="add-button" onclick="addBook()">Pievienot</button>
                    
                    <!-- <div class="editPopup" id="editPopup" style="display:none;">
                        <div class="add-menu popUpWrapper">
                        <a onclick="closePopup()"><button class="closePopup" id="closePopup">X</button></a>
                            <form action="updatebook.php" method="POST" enctype="multipart/form-data"> 
                                <div class="popUpInputs">
                                    <p>Update</p>
                                    <input type="text" name="BooksID" value="<?= $book['bookID']; ?>">
                                    <p>Nosaukums</p>
                                    <input type="text" class="Title" id="Title" name="Title" value="<?= $book['title']; ?>">
                                    <p>Bilde</p>
                                    <input type="file" class="Image" id="Image" name="image" value="<?= $book['image']; ?>">
                                    <p>Rating</p>
                                    <input type="number" class="Title" id="Title" name="Rating" value="<?= $book['rating']; ?>">
                                    <button class="update-book" name="update-book">Atjaunot grāmatu</button>
                                </div>
                            </form>   
                        </div>  
                    </div> -->

                    <div class="addPopup" id="addPopup" style="display:none;">
                        <form class="add-menu popUpWrapper" method="POST" enctype="multipart/form-data">
                            <a onclick="closePopup()"><button class="closePopup" id="closePopup">X</button></a>
                            <div class="popUpInputs">
                                <label>Nosaukums</label>
                                <input type="text"  name="title" placeholder="Nosaukums" required>
                                <label>Autors</label>
                                <input type="text"  name="author" placeholder="Autors" required>
                                <label>Apraksts</label>
                                <input type="text"  name="description" placeholder="Apraksts" required>
                                <label>Bilde</label>
                                <input type="file"  name="image" placeholder="Image" required>
                                <label>Kategorija</label>
                                <div style = "margin-top: 10px; margin-bottom: 30px">
                                    <select id="category" name="category" style = "z-index: 1; position: absolute; width: 300px" onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                        <option value="category" disabled selected>Kategorijas</option>
                                        <?php foreach ($catdata as $cat) { ?>
                                            <option name="category" required><?= $cat['CategName'] ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <label>Datums</label>
                                <input type="date"  name="date" placeholder="Datums" required>
                                
                                <button type="sumbit" class="add-book" name="add-book">Pievienot mūziku</button>
                            </div>
                        </form>      
                    </div>
                </div>
            </div>
        </div>

        <?php include 'assets/views/footer.html';?>

    </div>

    <script src="./assets/js/jquery.js"></script>
</body>
</html>