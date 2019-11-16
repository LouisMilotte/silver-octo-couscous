<?php

require ("/etc/rover/neoGenesis.php");
require ("/etc/rover/neoTable.php");
phpWarning();
$today = date("Y-m-d H:i:s");

$searchQuery = $_GET["search"];

//Build mySQL connection and create the people search array
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

$sql = "SELECT uniqueID, first_name, last_name FROM people;";
$res = mysqli_query($link, $sql);
$peopleArr = array();
while ($foo = mysqli_fetch_assoc($res)) {
    $peopleArr[$foo["uniqueID"]] = $foo["first_name"] . " " . $foo["last_name"];
}

// API request variables
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';
$version = '1.13.0';
$appid = 'TomPalme-pretain-PRD-83882c1d0-98d8da0e';
$globalid = 'EBAY-GB';
$query = $searchQuery;
$safequery = urlencode($query);

// Construct the findItemsByKeywords HTTP GET call
$apicall = "$endpoint?";
$apicall .= "OPERATION-NAME=findItemsByKeywords";
$apicall .= "&SERVICE-VERSION=$version";
$apicall .= "&SECURITY-APPNAME=$appid";
$apicall .= "&GLOBAL-ID=$globalid";
$apicall .= "&keywords=$safequery";
$apicall .= "&paginationInput.entriesPerPage=6";

//Fuck nodeJS amirite?
$xml   = simplexml_load_file($apicall, 'SimpleXMLElement', LIBXML_NOCDATA);
$array = json_decode(json_encode((array)$xml), TRUE);

// Check to see if the request was successful
if ($array["ack"] == "Success") {
  $cardz = '<div class="card-columns">';
  // If the response was loaded, parse it and build links
  foreach($array["searchResult"]["item"] as $item) {
    
    $itemID = $item["itemId"];

    $itemArr[$itemID] = array();
    $itemArr[$itemID]["id"] = $itemID;
    $itemArr[$itemID]["title"] = $item["title"];
    $itemArr[$itemID]["price"] = $item["sellingStatus"]["currentPrice"];
    $itemArr[$itemID]["link"] = $item["viewItemURL"];
    $itemArr[$itemID]["photo"] = $item["galleryURL"];
    $itemArr[$itemID]["category"] = $item["primaryCategory"]["categoryName"];
  }

  file_put_contents("/home/pi/shared/ebayController.log", "$today\n\n" . print_r($itemArr, true), FILE_APPEND);
}

//Its not broken, it just doesn't work
else {
  $cardz  = "<h3>uWu I did a fucky</h3>";
}

//Looks familiar...
$tableArr = array(
  array(" ", "Name", "Price", "Link", "Add to List")
);

foreach($itemArr as $row) {

  $ebayItemID = $row["id"];
  $ebayItemName = $row["title"];
  $ebayItemPrice = $row["price"];
  $ebayItemURL = $row["link"];

  $img = '<img src="' . $row["photo"] . '" alt="picture" style="height:100px;width:100px;">';
  $itemTitle = '<h4>' . $row["title"] . '</h4>';
  
  $eBayLink = '<a href="' . $row["link"] . '" target="_blank">View on eBay</a>';



  $addItemToWishlistModal = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Add to List</button>';
  $addItemToWishlistModal .= '<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">';
  $addItemToWishlistModal .= '<div class="modal-dialog modal-dialog-centered" role="document">';
  $addItemToWishlistModal .= '<div class="modal-content"> <div class="modal-header">';
  $addItemToWishlistModal .= '<h5 class="modal-title" id="exampleModalCenterTitle">Add to Wishlist</h5>';
  $addItemToWishlistModal .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
  $addItemToWishlistModal .= '<span aria-hidden="true">&times;</span></button></div>';
  $addItemToWishlistModal .= '<div class="modal-body">';

  //THE FORM IS HERE THOMAS
  $addItemToWishlistModal .= '<form id="addToWishlist" action="#" method="POST">';
  $addItemToWishlistModal .= '<img src="' . $row["photo"] . '">';
  $addItemToWishlistModal .= '<h1 id="theraininspain">' . $row["title"] . '</h1>';
  $addItemToWishlistModal .= '<h3 id="' . $ebayItemPrice . '">' . $ebayItemPrice . '</h3>';
  $addItemToWishlistModal .= '<select class="form-control" id="selectWishlist">';

  foreach($peopleArr as $key => $value){
    $addItemToWishlistModal .= "<option>$value</option>";
  }

  $addItemToWishlistModal .= '</select>';
  $addItemToWishlistModal .= '<button type="submit" class="btn btn-primary" id="wishlistSelect">Add</button>';
  $addItemToWishlistModal .= '</form></div>';
  $addItemToWishlistModal .= '<div class="modal-footer">';
  $addItemToWishlistModal .= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
  $addItemToWishlistModal .= '<button type="button" class="btn btn-primary">Save changes</button>';
  $addItemToWishlistModal .= '</div></div></div></div>';  

  $tableArr[] = array(
      $img,
      $row["title"],
      "£" . $row["price"],
      $eBayLink,
      $addItemToWishlistModal
  );
}

$table = new neoTable($tableArr);
echo $table->getTable();

?>

<script>
$(document).ready(function(){
    //OLD FUNCTION
    //$('#addToWishlist').on('submit', function(e){
        //Stop the form from submitting itself to the server.
        //e.preventDefault();
        //var search = $('#selectWishlist').val();
        //console.log( $( this )) );
        /*$.ajax({
            type: "GET", 
            url: './api/addToList.php', 
            data: {personID: search}, 
            success: function(data){
                $('.modal-body').html(data);
                $('#empModal').modal('show');
            }*/
        //});
  //NEW FUNCTION THAT WILL IS GONNA WRITE LOL
  $('#addToWishlist').on('submit', function(e){
    e.preventDefault();
    console.log("!!!ITS HERE!!!")
    console.log( $( this ));
    var data = $('#addToWishlist');
    $.ajax({
      type: "POST",
      url: "../api/addToList.php",
      data: {
        formData: data
      }, 
      success: function(data){
        console.log(data);
      }
    })
  });

});