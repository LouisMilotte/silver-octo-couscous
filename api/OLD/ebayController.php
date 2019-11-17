<?php

require ("/etc/rover/neoGenesis.php");
phpWarning();

$searchQuery = $_GET["search"];

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
$resp = simplexml_load_file($apicall);
//var_dump($resp);

// Check to see if the request was successful
if ($resp->ack == "Success") {
  $cardz = '<div class="card-columns">';
  // If the response was loaded, parse it and build links
  foreach($resp->searchResult->item as $item) {
    $pic   = $item->galleryURL;
    $link  = $item->viewItemURL;
    $title = $item->title;
    $price = $item->sellingStatus->currentPrice;
    $categoryName = $item->primaryCategory->categoryName;

    // For each SearchResultItem node, build a link and append it to $cardz
    $cardz .= "

    <div class=\"card\" style=\"width: 18rem;\">
    <img src=\"$pic\" class=\"card-img\" alt=\"$title\" style=\"height:200px;width:200px;\">
    <div class=\"card-body\">
    <h5 class=\"card-title\">$title</h5>
    <p class=\"card-text\">$categoryName</p>
    <h6 class=\"card-subtitle mb-2 text-muted\">£$price</h6>
    <i  id=\"add_circle\" class=\"material-icons\" style=\"float:left;\">add_circle</i>
    </div>
    </div>
    
    ";
  }

  $cardz .= "</div>";
}

//Its not broken, it just doesn't work
else {
  $cardz  = "<h3>uWu I did a fucky</h3>";
}

echo $cardz;

?>
