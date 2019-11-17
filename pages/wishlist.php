<?php

//Enable debugging
ini_set('html_errors', true);
ini_set('display_errors', true);
error_reporting(E_ALL);

//Include the library and setup the page
include ("../funcs/autoload.php");
new cc_builder("Gifticality | Wishlist", "Create a new wishlist or add some new items!");

//Setup the people-searchey thing
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

$sql = "SELECT uniqueID, first_name, last_name FROM people;";
$res = mysqli_query($link, $sql);
$peopleArr = array("all" => "All");
while ($foo = mysqli_fetch_assoc($res)) {
    $peopleArr[$foo["uniqueID"]] = $foo["first_name"] . " " . $foo["last_name"];
}

//Build cards
$cardNav = '<div class="card text-center">';
$cardNav .= '<div class="card-header">';
$cardNav .= '<ul class="nav nav-tabs card-header-tabs">';
$cardNav .= '<li class="nav-item">';

$count = 0;

foreach($peopleArr as $key=> $value){
  $count++;
  $cardNav .= "<button class=\"btn btn-info foobar$count\" id=\"$key\" style=\"margin-right:12px;\">$value</button>";
  $cardNav .= "</li>";
}

$cardNav .= '</ul>';
$cardNav .= '</div>';
$cardNav .= '<div class="card-body">';
$cardNav .= '<h5>Please select a person from the list</h5>';
$cardNav .= '</div>';
$cardNav .= '</div>';

echo $cardNav;



?>

<script>
$(document).ready(function(){
  $('.foobar1').on('click', function(e){
    console.log("ALL")
    //Stop the form from submitting itself to the server.
    e.preventDefault();
    var search = $('.foobar1').attr('id');
    console.log(search);
    $.ajax({
      type: "GET", 
      url: '../api/wishlistController.php', 
      data: {personID: search}, 
      success: function(data){
        console.log(data);
        $(".card-body").html(data);
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
        $(".card-body").html("<h3 style=\"float:left;\">Will Jones</h3>");
        $(".card-body").append(data);
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
        console.log(data);
        $(".card-body").html("<h3 style=\"float:left;\">Tom Boyd</h3>");
        $(".card-body").append(data);
      }
    });
  });

  $('.foobar4').on('click', function(e){
    console.log("Steve")
    //Stop the form from submitting itself to the server.
    e.preventDefault();
    var search = $('.foobar4').attr('id');
    console.log(search);
    $.ajax({
      type: "GET", 
      url: '../api/wishlistController.php', 
      data: {personID: search}, 
      success: function(data){
        $(".card-body").html("<h3 style=\"float:left;\">Steve Palmer</h3>");
        $(".card-body").append(data);
      }
    });
  });
////END JQUERY
});
</script>