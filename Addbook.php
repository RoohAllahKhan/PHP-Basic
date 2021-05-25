<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Add</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mystyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">

</head>
<body>
<?php
    require_once ('connection.php');

    $bookname = $publisher = $isbn = $cover = $coverImg = "";
    $bookErr = $publisherErr = $isbnErr = $coverErr = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST["bookName"])){
            $bookErr = "Book Name is required";
        }
        else{
            $bookname = testInput($_POST["bookName"]);
        }
        if(empty($_POST["publisher"])){
            $publisherErr = "Publisher is required";
        }
        else{
            $publisher = testInput($_POST["publisher"]);
        }
        if(empty($_POST["isbn"])){
            $isbnErr = "ISBN is required";
        }
        else{
            $isbn = testInput($_POST["isbn"]);
        }
        if(isset($_FILES['cover'])){
            $coverImg = $_FILES['cover']['name'];
            $cover_temp = $_FILES['cover']['tmp_name'];
           if(move_uploaded_file($cover_temp, "images/".$coverImg)){
                $msg = "Image uploaded successfully";
            }
            else{
                $msg = "Error in uploading of file";
            }
        }
        if($bookname != "" && $publisher != "" && $isbn != ""){

            $db_query = "CREATE DATABASE IF NOT EXISTS bookDb";
            $conn->query($db_query);
            $conn->select_db('bookDb');

            $tableExist = $conn->query("SELECT 1 FROM books");
            if($tableExist !== FALSE){
                $tableIns = "INSERT INTO books(ISBN, Book_Name, Publisher, Cover_Image) VALUES(".'"'.$isbn.'"'.','.'"'.$bookname.'"'.','.'"'.$publisher.'"'.','.'"'.$coverImg.'"'.')';
                $conn->query($tableIns);
            }
            else{
            $tableCreate = "CREATE TABLE books (
                                ID INT AUTO_INCREMENT PRIMARY KEY,
                                ISBN VARCHAR(255) NOT NULL,
                                Book_Name VARCHAR(255) NOT NULL,
                                Publisher VARCHAR(255) NOT NULL,
                                Cover_Image VARCHAR(255) NOT NULL, 
                                FULLTEXT KEY (ISBN, Book_Name, Publisher, Cover_Image))";

            $tableIns = "INSERT INTO books(ISBN, Book_Name, Publisher, Cover_Image) VALUES(".'"'.$isbn.'"'.','.'"'.$bookname.'"'.','.'"'.$publisher.'"'.','.'"'.$coverImg.'"'.')';
            $conn->query($tableIns);
            }
        }

    }

    function testInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

    <div class="add_container">
        <div class="collection-navbar" style="width: 100%">
            <ul id="coll-nav_items" style="text-align: left; padding-left: 50px">
                <li><a href="home.php">Home</a></li>
                <li><a href="Addbook.php">Add book</a></li>
                <li><a href="collection.php">Collection</a></li>
            </ul>
        </div>
        <div class="inner">
            <br><br><h1 style="color: #fefefe; font-family: 'Montserrat'">Book Admin</h1>
            <span class="error">* required fields</span><br><br>
            <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                <input type="text" name="bookName" placeholder="Book Name" style="border-radius: 50px; padding: 10px; width: 60%" />
                <span class="error">*<?php echo "$bookErr"?></span><br><br>
                <input type="text" name="publisher" placeholder="Publisher" style="border-radius: 50px; padding: 10px; width: 60%" />
                <span class="error">*<?php echo "$publisherErr"?></span><br><br>
                <input type="text" name="isbn" placeholder="ISBN" style="border-radius: 50px; padding: 10px; width: 60%" />
                <span class="error">*<?php echo "$isbnErr"?></span><br><br>
<!--                <input type="text" name="cover" placeholder="Cover Image" />-->
<!--                <span class="error">*--><?php //echo "$coverErr"?><!--</span><br><br>-->
                <input type="file" name="cover" required style="color: #fefefe; width: 45%"><br><br>
                <button type="submit" class="btn btn-primary" style="height: 50px;border-radius: 50px;width: 60%">Add Book</button>
            </form>
        </div>
    </div>
</body>
</html>