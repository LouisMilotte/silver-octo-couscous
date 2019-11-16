<?php

require ("/etc/rover/neoGenesis.php");
phpWarning();

$someone = $_GET["personID"];

//Connect to mySQL and grab teh data
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

if ($someone == "all"){
    $sql = "SELECT item_name, item_price, item_link FROM giftList;";
}else{
    $sql = "SELECT item_name, item_price, item_link FROM giftList WHERE uniqueID = '$someone';";
}

// $sql = "SELECT item_name, item_price, item_link FROM giftList WHERE uniqueID = '$someone';";
$res = mysqli_query($link, $sql);

//Gather headers because lazy...
$headers = array("Name", "Price", "Link");

if ($res->num_rows > 0) {
    $table = '';
    $table .= '<table class="table table-hover">';
    $table .= '<thead>';

    //Construct the table headers
    foreach ($headers as $header){
        $table .= "<th scope=\"col\">$header</th>";
    }
    
    $table .= '</tr></thead>';
    $table .= '<tbody><tr>';

    //Construct the table data
    while($row = mysqli_fetch_assoc($res)) {
        foreach($row as $key => $value) {
            $cellType = 'td';		
			$extraAttrs = '';
            if(is_array($value)){					
                if(isset($value['cell_type']) && !empty($value['cell_type'])) $cellType = $value['cell_type'];
            	$extraAttrs = $value['attrs'];
				$value = $value['value'];
			}
            
            $table .= "<$cellType $extraAttrs>$value</$cellType>";
            
        }

        $table .= '</tr>';
    }

    $table .= '</tbody></table>';
    echo $table;
}else{
    neoStatement("NO RESULTS RETURNED");
}

?>