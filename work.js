
function bookSearch(str){
    document.getElementById("searchList").style.display = "block";
    if(str.length == 0){
        document.getElementById("searchList").innerHTML = "";
        document.getElementById("searchList").style.border = "0px";
        return;
    }
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("searchList").innerHTML = this.responseText;
            document.getElementById("searchList").style.border = "1px solid #A5ACB2";
            document.getElementById("searchList").style.overflow = 'auto';

        }
    }
    xmlHttp.open("GET", "main.php?q=" + str+"&x=0", true);
    xmlHttp.send();
}




