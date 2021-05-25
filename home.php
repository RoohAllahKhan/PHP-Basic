<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="work.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-container">
        <div class="hero">
            <!--        <form id="searchBox" action="display.php">-->
            <div class="navbar">
                <ul id="nav_items" style="text-align: left">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="Addbook.php">Add book</a></li>
                    <li><a href="collection.php">Collection</a></li>
                </ul>
            </div>
            <div class="hero-inner">
            </div>
                <h1 style="text-align: center;font-family: 'Montserrat', sans-serif; color: white; font-size: 50px">Which Book Are you Looking For?</h1>
                <div class="wrapper">
                    <div class="inner_wrapper">
                        <input type="text" class="searchTxt" size="30" onkeyup="bookSearch(this.value)" />
                        <button class="searchBtn">Search</button>
                        <div id="searchList" style="position: absolute; width: 100%"></div>
                    </div>

            </div>

            <!--        </form>-->

        </div>
        <br><br>
        <div class='itemsContainer'></div>
        <div class="xyz"></div>


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
                        $('.itemsContainer').css("background-color", "gray");
                        $('.itemsContainer').html(data);
                        //$('.searchTxt').val('');
                        //$('#searchList').hide();
                    }
                });
                $('.searchTxt').val('');
                document.getElementById("searchList").style.display = "none";
            } else {
                $('.itemsContainer').css("border", "none");
                $('.itemsContainer').html("");
            }
        });
    });
</script>

