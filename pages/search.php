<?php

ini_set('html_errors', true);
ini_set('display_errors', true);
error_reporting(E_ALL);

include ("../funcs/autoload.php");
new cc_builder("Gifticality | Search", "Lets add some new gifts!");
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

$sql = "SELECT * FROM boxx.giftList;";
$res = mysqli_query($link, $sql);

?>

<form id="searchEbay">
  <div class="input-group"><input type="text" class="form-control" placeholder="Search eBay..." id="search">
  <div class="input-group-append"><button class="btn btn-primary" type="submit">Search!</button>
  </div></div>
</form>

<div id="empty">



<script>
  $(document).ready(function(){
    $('#searchEbay').on('submit', function(e){
      //Stop the form from submitting itself to the server.
      e.preventDefault();
      var search = $('#search').val();
      $.ajax({type: "GET", url: '../api/ebayControllerALT.php', data: {search: search}, success: function(data){$("#empty").html(data);}});
    });
  });
</script>