<?php
    require_once('connection.php');

    $counter = 0;
    $index = 0;

    $keyword = $_GET["q"];
    $flag = $_GET["x"];
    $isbn = $_GET["isbn"];
    $edit = $_GET["ebook"];

    $id = $_GET["id"];
    $n_isbn = $_GET["newisbn"];
    $n_publisher = $_GET["newpublisher"];
    $n_book = $_GET["newbook"];
    $bookImage = $_GET["img"];


    if($_FILES["cover"]["name"] != '') {
        $coverImg = $_FILES["cover"]["name"];
        $cover_temp = $_FILES['cover']['tmp_name'];
        move_uploaded_file($cover_temp, 'images/'. $coverImg);
    }
    if(strlen($n_isbn) > 0){
        echo $coverImg;
        $update_query = "UPDATE books SET ISBN='".$n_isbn."',Book_Name='".$n_book."',Publisher='".$n_publisher."',Cover_Image='".$bookImage."' WHERE ID=".$id;
        if ($conn->query($update_query) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }


    if(strlen($edit)>0){
        $book = 'SELECT ID, Book_Name, Cover_Image, Publisher, ISBN FROM books WHERE ISBN="'.$edit.'"';
        $record = $conn->query($book);
        $row = $record->fetch_assoc();
            echo "<div id='myModal' class='modal' style='display: block;'><div class='modal-content' style='width: 80%; height: 70%;
'><span class='close' onclick='closefunc()'>&times;</span><p><div class='bookMain'
               style='display: inline-block; text-align: center;'><div style='float: left; height: 100%; display: inline-block'><img id= 'bookCover' alt='hp' height=385 src='images/"
               .$row["Cover_Image"]."'alt='hp' width='300'></div><div class='inside' style='clear: top; height: 100%; width: 60%; display: inline-block; text-align: center;
               align-items: center;'><div style='text-align: right'><p class='id' style='display: none'>".$row["ID"]."</p>Book Name&emsp;<input style='height:40px; width:70%' type='text' class='bookname' value='".$row["Book_Name"]."'>
               <br><br>Publisher&emsp;<input style='height:40px; width:70%' type= 'text' class='publisher' value='".$row["Publisher"]."'>
               <br><br>ISBN&emsp;<input style='height:40px; width:70%' type='text' class='isbn' value='".$row["ISBN"]."'><br><br>Cover Image&emsp;<input type='file' name='cover' id='file' required><br><br></div>
               <div class='btn_container' style='height:30%;padding: 30px; clear: both;'><table class='buttons'><tr><td style='height: 30px;'><button type='submit' style=' border-radius:50px; height: 40px; width: 80%;' class='save_btn btn btn-primary' value='".$index."' onclick='saveFunc()'>Save</button></td><td style='height: 30px;'>
               <button style='border-radius:50px; height: 40px; width: 80%;' class='cancel_btn btn btn-danger' value='".$index."' onclick='cancelFunc()'>Cancel</button></td></tr></table></div></div></div>";

    }

    if(strlen($isbn) > 0){
        $del_query = "DELETE FROM books WHERE ISBN = '".$isbn."'";
        $conn->query($del_query);
    }

    if(strlen($keyword) > 0){
        $hint = "";
        $book = 'SELECT ID, Book_Name, Cover_Image, Publisher, ISBN FROM books WHERE (
                        ISBN LIKE ("'.$keyword.'%") OR
                        Book_Name LIKE ("'.$keyword.'%") OR
                        Publisher LIKE ("'.$keyword.'%") OR
                        Cover_Image LIKE ("'.$keyword.'%"))';
        $record = $conn->query($book);
        if($record === TRUE){}
        else{ echo $conn->error;}
        if($record->num_rows > 0){
            while($row = $record->fetch_assoc()){
                if($flag == 1){
                    echo "<div class='eachBook' style='display: inline-block; text-align: center;'><div style='float: left; height: 100%; display: inline-block'><img alt='hp' height=185 src='images/".$row["Cover_Image"]."'alt='hp' width='135'>
                          </div> 
                          <div class='inside' style='clear: top; height: 100%; width: 50%; display: inline-block; text-align: center; align-items: center;'><div><p id='bookname'>".$row["Book_Name"]."</p><p id='publisher'>
                          By: ".$row["Publisher"]."</p><p class='isbn".$index."'>".$row["ISBN"]."</p></div>
                          <div class='btn_container' style='height:30%;padding: 5px; clear: both;'><table class='buttons'><tr><td><button class='del_btn btn btn-danger' value='".$index."'>Delete</button></td><td><button class='edit_btn btn btn-warning' value='".$index."'>Edit</button></td></tr></table></div></div></div>";
                            $index++;
                }
                else{
                    if($counter == 0){
                        echo "<div style='overflow: auto; margin-left: 10px; margin-top: 10px; text-align: center;'><div style='display: inline-block; float: left'><img style='float:left;' 
                            src='images/".$row["Cover_Image"]."' alt='image' width='100' height='120'></div>".'<div style="padding: 30px 0; text-align: center; display: inline-block"><p>'.
                            $row["Book_Name"].'</p></div></div>';
                        $counter++;
                    }
                    else{
                        echo "<hr><div style='overflow: auto; margin-left: 10px; margin-top: 10px; text-align: center;'><div style='display: inline-block; float: left'><img style='float:left;' 
                            src='images/".$row["Cover_Image"]."' alt='image' width='100' height='120'></div>".'<div style="padding: 30px 0; text-align: center; display: inline-block"><p>'.
                            $row["Book_Name"].'</p></div></div>';}
                }
                }

            echo "<br>";
        }
        else{
            echo "0 records found";
        }
    }

?>

<script>

    $('#file').change(function (){
        testImage(this);
    });
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
    });
    $(".del_btn").click(function (){
        var val = $(this).val();
        var isbn = $('.isbn'+val).text();
        var del_confirmation = confirm('Do you really want to delete the record?');
        if(del_confirmation){
            if (isbn != '') {
                $(this).parent().parent().parent().parent().parent().parent().parent().remove();

                $.ajax({
                    url: "main.php?isbn=" + isbn,
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

    $(".edit_btn").click(function (){
        //document.getElementById("#myModal").style.display = "block";
        $('.xyz').html("");
        var val = $(this).val();
        var isbn = $('.isbn'+val).text();

        if(isbn != ''){
            $.ajax({
                url: "main.php?ebook=" + isbn,
                method: "get",
                data: {search: isbn},
                dataType: "text",
                success: function (data) {
                    $('.xyz').html(data);
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
                url: 'main.php',
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
                            url: "main.php?id=" + id + "&newisbn=" + isbn + "&newbook=" + bookName + "&newpublisher=" + publisher+"&img="+image_name,
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
