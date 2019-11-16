<?php
require ("/etc/rover/neoGenesis.php");
require ("/etc/rover/neoTable.php");
phpWarning();
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

$itemTitle = $_POST['formData'];


var_dump($itemTitle);



/*$sql = "INSERT INTO boxx.giftList (uniqueID, item_id, item_name, item_price, item_link, purchased) VALUES ('{$wishlistID}', '{$ebayItemID}', '{$ebayItemName}', '{$ebayItemPrice}', '{$ebayItemURL}', '0');";


if (mysqli_query($link, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

*/
?>