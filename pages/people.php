<?php

ini_set('html_errors', true);
ini_set('display_errors', true);
error_reporting(E_ALL);

include ("../funcs/autoload.php");
new cc_builder("Gifticality | People", "Update your relationships, or add some new ones");
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

$sql = "SELECT * FROM boxx.people;";
$res = mysqli_query($link, $sql);

$headers = array("First Name", "Last Name", "Birthday", "WishList");

if ($res->num_rows > 0) {
    $tableArr = array(
		array("First Name", "Last Name", "Birthday", "WishList")
	);

    while ($row = mysqli_fetch_assoc($res)) { 
        $rows[] = $row; 
    }

    $count = 0;

    foreach($rows as $row) {
        $count++;

        $personID = $row["uniqueID"];
        $wishListLink = "http://" . $_SERVER["HTTP_HOST"] . "/api/wishlistController.php?personID=" . $personID;
        $button = "<button type=\"button\" class=\"btn btn-info foobar$count\" id=\"$personID\">Click here</button>";

        $tableArr[] = array(
            $row["first_name"],
            $row["last_name"],
            $row["birthday"],
            $button
        );
    }

    $table = new neoTable($tableArr);
    echo $table->getTable();
}else{
    neoStatement("No data returned");
}



?>

<!-- Modal -->
<div class="modal fade" id="empModal" role="dialog">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
<div class="modal-content modal-lg">
<div class="modal-header">
<h4 class="modal-title">Wishlist</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div><div class="modal-body"></div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
</div></div></div>

<script>
$(document).ready(function(){
    $('.foobar1').on('click', function(e){
        //Stop the form from submitting itself to the server.
        e.preventDefault();
        var search = $('.foobar1').attr('id');
        console.log(search);
        $.ajax({
            type: "GET", 
            url: '../api/wishlistController.php', 
            data: {personID: search}, 
            success: function(data){
                $('.modal-body').html(data);
                $('#empModal').modal('show');
            }
        });
    });

    $('.foobar2').on('click', function(e){
        //Stop the form from submitting itself to the server.
        e.preventDefault();
        var search = $('.foobar2').attr('id');
        console.log(search);
        $.ajax({
            type: "GET", 
            url: '../api/wishlistController.php', 
            data: {personID: search}, 
            success: function(data){
                $('.modal-body').html(data);
                $('#empModal').modal('show');
            }
        });
    });

    $('.foobar3').on('click', function(e){
        //Stop the form from submitting itself to the server.
        e.preventDefault();
        var search = $('.foobar3').attr('id');
        console.log(search);
        $.ajax({
            type: "GET", 
            url: '../api/wishlistController.php', 
            data: {personID: search}, 
            success: function(data){
                $('.modal-body').html(data);
                $('#empModal').modal('show');
            }
        });
    });


});
</script>