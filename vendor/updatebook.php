<?php
include "connect.php";

//Book update
$book_id = $_POST['Book_ID'];
$title = $_POST['Title'];
$author = $_POST['Author'];
$descirption = $_POST['Description'];
$image = $_FILES['image'];
$date = $_POST['Date'];

if (isset($_POST['Category'])) {
    $category = $_POST['Category'];
}else {
    $query = "SELECT category FROM `books` WHERE `bookID` = '$book_id'";
    $category = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($category);
    $category = implode($category);
}



if ($image['name'] === "") {
    $query = "SELECT image FROM `books` WHERE `bookID` = '$book_id'";
    $image = mysqli_query($conn, $query);
    $path = mysqli_fetch_assoc($image);
    $path = implode($path);

} else {
    $path = 'uploads/' . time() . $_FILES['image']['name'];
    echo $path;
    move_uploaded_file($_FILES['image']['tmp_name'], '../' . $path);
}

mysqli_query($conn, "UPDATE `books` SET `title` = '$title', `author` = '$author', `description` = '$descirption', `image` = '$path', `category` = '$category', `date` = '$date' WHERE `books`.`bookID` = '$book_id';");

header('Location: /Re-Books/admin.php');
?>