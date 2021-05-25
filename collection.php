<?php
    require_once ('connection.php');

    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }
    $num_per_page = 10;
    $start_from = ($page-1)*10;
    $book = 'SELECT * FROM books LIMIT '.$start_from.','.$num_per_page;
    $record = $conn->query($book);
    if($record === TRUE){}
    else{ echo $conn->error;}

    $isbn = $_GET["isbn"];
    $edit = $_GET["ebook"];
    $id = $_GET["id"];
    $n_isbn = $_GET["newisbn"];
    $n_publisher = $_GET["newpublisher"];
    $n_book = $_GET["newbook"];
    $bookImage = $_GET["img"];
    $modalFlag = $_GET["modalFlag"];


    if($_FILES["cover"]["name"] != '') {
        $coverImg = $_FILES["cover"]["name"];
        $cover_temp = $_FILES['cover']['tmp_name'];
        move_uploaded_file($cover_temp, 'images/'. $coverImg);
    }

    if(strlen($n_isbn) > 0){
       // echo $coverImg;
        $update_query = "UPDATE books SET ISBN='".$n_isbn."',Book_Name='".$n_book."',Publisher='".$n_publisher."',Cover_Image='".$bookImage."' WHERE ID=".$id;
        if ($conn->query($update_query) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if(strlen($isbn) > 0){
        $del_query = "DELETE FROM books WHERE ISBN = '".$isbn."'";
        $conn->query($del_query);
    }
    if(strlen($edit)>0){
        $book = 'SELECT ID, Book_Name, Cover_Image, Publisher, ISBN FROM books WHERE ISBN="'.$edit.'"';
        $record = $conn->query($book);
        $row = $record->fetch_assoc();
        echo "<div id='myModal' class='modal' style='display: block'><div class='modal-content' style='width: 80%; height: 70%'><span class='close' onclick='closefunc()' style='text-align: right'>&times;</span><p><div class='bookMain'
                   style='display: inline-block; text-align: center;'><div style='float: left; height: 100%; display: inline-block'><img id= 'bookCover' alt='hp' height=385 src='images/"
                   .$row["Cover_Image"]."'alt='hp' width='300'></div><div class='inside' style='clear: top; height: 100%; width: 60%; display: inline-block; text-align: center;
                   align-items: center;'><div style='text-align: right'><p class='id' style='display: none'>".$row["ID"]."</p>Book Name&emsp;<input style='height:40px; width:70%' type='text' class='bookname' value='".$row["Book_Name"]."'>
                   <br><br>Publisher&emsp;<input style='height:40px; width:70%' type= 'text' class='publisher' value='".$row["Publisher"]."'>
                   <br><br>ISBN&emsp;<input style='height:40px; width:70%' type='text' class='isbn' value='".$row["ISBN"]."'><br><br>Cover Image&emsp;<input type='file' name='cover' id='file' required><br><br></div>
                   <div class='btn_container' style='height:30%;padding: 30px; clear: both;'><table class='buttons'><tr><td style='height: 30px;'><button type='submit' style=' border-radius:50px; height: 40px; width: 80%;' class='save_btn btn btn-primary' value='".$index."' onclick='saveFunc()'>Save</button></td><td style='height: 30px;'>
                   <button style='border-radius:50px; height: 40px; width: 80%;' class='cancel_btn btn btn-danger' value='".$index."' onclick='cancelFunc()'>Cancel</button></td></tr></table></div></div></div>";

    }

?>
<?php
if($modalFlag != 1){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Collection</title>
    <link href="mystyle.css" rel="stylesheet">
    <script src="work.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>

</head>
<body>

<div class="main-container">
    <div class="collection-navbar">
        <ul id="coll-nav_items" style="text-align: left;">
            <li><a href="home.php">Home</a></li>
            <li><a href="Addbook.php">Add Book</a></li>
            <li><a href="collection.php">Collection</a></li>
        </ul>
    </div>
    <div class="outerContainer">

        <div class='itemsContainer'>
            <?php if($record->num_rows > 0) {
                $index = 0;
            while ($row = $record->fetch_assoc()) {
            echo "<div class='eachBook' style='display: inline-block; text-align: center;'><div style='float: left; height: 100%; display: inline-block'><img alt='hp' height=185 src='images/" . $row["Cover_Image"] . "'alt='hp' width='135'>
                </div><div class='inside' style='clear: top; height: 100%; width: 50%; display: inline-block; text-align: center; align-items: center;'><div>
                        <p id='bookname'>" . $row["Book_Name"] . "</p><p id='publisher'>By: " . $row["Publisher"] . "</p>
                        <p class='isbn" . $index . "'>" . $row["ISBN"] . "</p></div>
                    <div class='btn_container' style='height:30%;padding: 5px; clear: both;'><table class='buttons'><tr><td>
                    <button class='del_btn btn btn-danger' value='" . $index . "'>Delete</button></td><td><button class='edit_btn btn btn-warning' value='" . $index . "'>Edit</button></td></tr></table></div></div></div>";
            $index++;
            }
            ?>
            <div style="text-align: center;width: 100%">
            <?php
                $allBooks = "SELECT * FROM books";
                $result = $conn->query($allBooks);
                $total_record = $result->num_rows;
                $total_page = ceil($total_record/$num_per_page);

                for($i = 1; $i <= $total_page; $i++){
                    echo "<a id='paging' style='color:black; padding:5px; font-size:25px;' href='collection.php?page=".$i."'>".$i."</a>";
                }
                echo "<br><br><br><br>";
                ?>
            </div>
            <?php
            }
            else{
            echo "0 Records found";
            }
            ?>
            <div class="xyz"></div>
    </div>
<!--    <div style="text-align: center">-->
<!--        -->
<!--    </div>-->
</div>

</body>
</html>
<?php
}
?>

<script>

    $('#file').change(function (){
        testImage(this);
    })
    function testImage(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e){
                $('#bookCover').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).ready(function (){
        $(".del_btn").click(function (){
            var val = $(this).val();
            var isbn = $('.isbn'+val).text();
            var del_confirmation = confirm('Do you really want to delete the record?');
            if(del_confirmation){
                if (isbn != '') {
                    $(this).parent().parent().parent().parent().parent().parent().parent().remove();

                    $.ajax({
                        url: "collection.php?isbn=" + isbn,
                        method: "get",
                        data: {search: isbn},
                        dataType: "text",
                        success: function () {
                            $(this).parent('div.eachBook').remove();

                        }
                    });

                }
            }
              });
    });

    $(".edit_btn").click(function (){
        //document.getElementById("#myModal").style.display = "block";
        $('.xyz').html("");
        var val = $(this).val();
        var isbn = $('.isbn'+val).text();
        var modalFlag = 1;
        if(isbn != ''){
            $.ajax({
                url: "collection.php?ebook=" + isbn + "&modalFlag=" + modalFlag,
                method: "get",
                data: {search: isbn},
                dataType: "text",
                success: function (data) {
                    $('.xyz').html(data);
                    isbn = "";
                    //$('.itemsContainer').html(data);
                    //$('.searchTxt').val('');
                    //$('#searchList').hide();
                }
            });
        }
    })

    function closefunc(){
        document.getElementById("myModal").style.display = "none";

    }

    function saveFunc(){
        var id = $('.id').text();
        var isbn = $('.isbn').val();
        var bookName = $('.bookname').val();
        var publisher = $('.publisher').val();
        try {
            var property = document.getElementById("file").files[0];
            var image_name = property.name;
            var form_data = new FormData();
            form_data.append('cover', property);
            $.ajax({
                url: 'collection.php',
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    //$(".xyz").html(data);
                    // $("#bookCover").attr('src', 'images/'+image_name);
                    if(isbn != '' && bookName != '' && publisher != ''){
                        $.ajax({
                            url: "collection.php?id=" + id + "&newisbn=" + isbn + "&newbook=" + bookName + "&newpublisher=" + publisher+"&img="+image_name,
                            method: "get",
                            success: function () {
                                $('.modal').hide();
                                window.location.reload();
                            }
                        });

                    }
                }
            });

        }catch (e) {
            alert(e + "\nPlease select a file");
        }
    }

    function cancelFunc(){
        $('.modal').hide();
    }

</script>
