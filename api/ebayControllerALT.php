<?php

require ("/etc/rover/neoGenesis.php");
require ("/etc/rover/neoTable.php");
phpWarning();
$today = date("Y-m-d H:i:s");
require ("/var/www/pretain/html/include/serialize.js");

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
    $itemArr[$itemID]["img"] = $item["galleryURL"];
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

$count = 0;

foreach($itemArr as $row) {
  $count++;

  $ebayItemID = $row["id"];
  $ebayItemName = $row["title"];
  $ebayItemPrice = $row["price"];
  $ebayItemURL = $row["link"];

  $img = '<img src="' . $row["img"] . '" alt="picture" style="height:100px;width:100px;">';
  $itemTitle = '<h4>' . $row["title"] . '</h4>';
  
  $eBayLink = '<a href="' . $row["link"] . '" target="_blank">View on eBay</a>';



  $addItemToWishlistModal = "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#exampleModalCenter$count\">Add to List</button>";
  $addItemToWishlistModal .= "<div class=\"modal fade\" id=\"exampleModalCenter$count\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalCenterTitle$count\" aria-hidden=\"true\">";
  $addItemToWishlistModal .= '<div class="modal-dialog modal-dialog-centered" role="document">';
  $addItemToWishlistModal .= '<div class="modal-content"> <div class="modal-header">';
  $addItemToWishlistModal .= '<h5 class="modal-title" id="exampleModalCenterTitle">Add to Wishlist</h5>';
  $addItemToWishlistModal .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
  $addItemToWishlistModal .= '<span aria-hidden="true">&times;</span></button></div>';
  $addItemToWishlistModal .= '<div class="modal-body">';

/* ---------------------------- Begin modal form ---------------------------- */
  $addItemToWishlistModal .= '<form id="addToWishlist" name="formName" class="addtowishlistform">';

  $addItemToWishlistModal .= '<img src="' . $row["img"] .  '" alt="img" style="height:100px;width:100px;"></img>';
  $addItemToWishlistModal .= '<input type="hidden" name="ebayItemID" value="' . $row["id"] . '"></input>';

  $addItemToWishlistModal .= '<h4 name="formTitle">' . $row["title"] . '</h4>';
  $addItemToWishlistModal .= '<input type="hidden" name="ebayItemTitle" value="' . $row["title"] . '"></input>';

  $addItemToWishlistModal .= '<h5 name="formPrice">£' . $row["price"] . '</h4>';
  $addItemToWishlistModal .= '<input type="hidden" name="ebayItemPrice" value="' . $row["price"] . '"></input>';

  $addItemToWishlistModal .= '<a href="' . $row["link"] . '">View on eBay</a>';
  $addItemToWishlistModal .= '<input type="hidden" name="ebayItemLink" value="' . $row["link"] . '"></input>';
  
  
  $addItemToWishlistModal .= '<select class="form-control" name="wishlistRecipient">';
  
  foreach($peopleArr as $key => $value){
    $addItemToWishlistModal .= "<option value=\"$key\">$value</option>";
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

foreach($tableArr as $x){
  echo count($x);
}

?>

<script>
$(document).ready(function(){
  console.log("!!!JQUERY RUNNING NOW!!!");
  //Credit to Will Jones :)
  $('#addToWishlist').on('submit', function(e){
    console.log("!!!ITS HERE!!!");
    e.preventDefault();
    var data = $('.addtowishlistform').serialize()
    $.ajax({
      type: "POST",
      url: "../api/addToList.php",
      data: data, 
      success: function(data){
        console.log("Success");
        $(".modal-body").append(data);
      },
      error:function(data){
        console.log("fucked it mate.")
      }
    })
  });
});
