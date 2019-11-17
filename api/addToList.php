<?php
require ("/etc/rover/neoGenesis.php");
require ("/etc/rover/neoTable.php");
phpWarning();
$today = date("Y-m-d H:i:s");
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

$ebayItemID = $_POST['ebayItemID'];
$ebayItemTitle = $_POST['ebayItemTitle'];
$ebayItemPrice = $_POST['ebayItemPrice'];
$ebayItemLink = $_POST['ebayItemLink'];
$wishlistRecipient = $_POST['wishlistRecipient'];

//print_r($_POST);

file_put_contents("/home/pi/shared/donthugmeimscared.log", "$today\n\n" . "=====POST=====\n\n" . print_r($_POST, true), FILE_APPEND);
file_put_contents("/home/pi/shared/donthugmeimscared.log", "-----------------------------------------------------\n\n", FILE_APPEND);
file_put_contents("/home/pi/shared/donthugmeimscared.log", "$today\n\n" . "=====GET=====\n\n" . print_r($_GET, true), FILE_APPEND);


$sql = "INSERT INTO boxx.giftList (uniqueID, item_id, item_name, item_price, item_link, purchased) VALUES ('{$wishlistRecipient}', '{$ebayItemID}', '{$ebayItemTitle}', '{$ebayItemPrice}', '{$ebayItemLink}', '0');";


if (mysqli_query($link, $sql)) {
    echo "<h2>New record created successfully</h2>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}


?>