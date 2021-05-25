
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="mystyle.css" rel="stylesheet">
    <script src="work.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>

</head>
<body>
<!--style='display: inline-block; float: left; padding: 5px'-->
<!--style='display: inline-block; text-align: center; padding: 20% 0; margin-bottom: 5px;'-->
<div class="container">
    <div class="outerContainer">
        <div class="inn_wrapper" style="width: 80%; position: relative; text-align: center">
            <input class="searchTxt" onkeyup="bookSearch(this.value)" size="30" style="height: 50px;" type="text"/>
            <button class="searchBtn">Search</button>
            <div id="searchList" style="position: absolute; width: 100%"></div>
        </div>
        <div class='itemsContainer'></div>
<!--        <div id="myModal" class="modal"></div>-->
        <div class="xyz"></div>
    </div>
</div>
</body>
</html>


<script>
    $(document).ready(function () {
        $(".searchBtn").click(function () {
            var keyword = $(".searchTxt").val();
            if (keyword != '') {
                $.ajax({
                    url: "main.php?q=" + keyword + "&x=1",
                    method: "get",
                    data: {search: keyword},
                    dataType: "text",
                    success: function (data) {
                        alert(data);
                        $('.itemsContainer').html(data);
                        //$('.searchTxt').val('');
                        //$('#searchList').hide();
                    }
                });
                $('.searchTxt').val('');
                document.getElementById("searchList").style.display = "none";
            } else {
                $('.itemsContainer').html(data);
            }
        });
    });
</script>