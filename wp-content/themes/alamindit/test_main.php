<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script>
//alert('egogog');
$.ajax({
    type: "POST",
    url: "/taichi/wp-content/themes/alamindit/main.php",
    //dataType: "json", // Set the data type so jQuery can parse it for you
    success: function (data) {
//alert('wdshfkjsd');
       

var abs = JSON.parse(data)
alert(abs.aaData[1][1]); 
var size = abs.aaData.length;
alert(size);
for(var i=0 ; i<abs.aaData.length;i++)
{
for(var j=0 ; j<abs.aaData[0].length; j++)
{
alert(abs.aaData[i][j]);
}

}
	//document.getElementById("name").innerHTML = data[0];
        //document.getElementById("age").innerHTML = data[1];
        //document.getElementById("location").innerHTML = data[2];
    }
});

</script>
