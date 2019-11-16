<?php
require ("/etc/rover/neoGenesis.php");
require ("/etc/rover/neoTable.php");
phpWarning();

$someone = $_GET["personID"];

//Connect to mySQL and grab teh data
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

if ($someone == "all"){
    $sql = "SELECT item_name, item_price, item_link FROM giftList;";
}else{
    $sql = "SELECT item_name, item_price, item_link FROM giftList WHERE uniqueID = '$someone';";
}

$res = mysqli_query($link, $sql);

if ($res->num_rows > 0) {
    $tableArr = array(
		array("Name", "Price", "Link")
	);

    while ($row = mysqli_fetch_assoc($res)) { 
        $rows[] = $row; 
    }

    $count = 0;

    foreach($rows as $row) {
        $count++;

        $tableArr[] = array(
            $row["item_name"],
            $row["item_price"],
            $row["item_link"]
        );
    }

    $table = new neoTable($tableArr);
    echo $table->getTable();
}else{
    neoStatement("NO RESULTS RETURNED");
}

?>