<?php
//Enable debugging
ini_set('html_errors', true);
ini_set('display_errors', true);
error_reporting(E_ALL);

//Include the library and construct the page
include ("../funcs/autoload.php");
new cc_builder("Gifticality | People", "Update your relationships, or add some new ones");

//Why I have to do this twice I'll never know
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");

//Grab data about the people
$sql = "SELECT first_name, last_name, relationship, birthday FROM boxx.people;";
$peopleRes = mysqli_query($link, $sql);

//Grab data about the wishlist
$qry = "SELECT item_name, item_price, item_link FROM boxx.giftList;";
$qryRes = mysqli_query($link, $qry);

//Setup the table headers
$headers = array("First Name", "Last Name", "Birthday", "Relationship");

//Begin constructing the actual table
if ($peopleRes->num_rows > 0) {
    $table = '';
    $table .= '<table class="table table-hover">';
    $table .= '<thead><tr data-target="#accordion" class="clickable">';
    
    //Construct the table headers
    foreach ($headers as $header){
        $table .= "<th scope=\"col\">$header</th>";
    }

    $table .= '</tr></thead>';
    $table .= '<tbody><tr>';

    //Construct the *FIRST LAYER* of table data
    while($row = mysqli_fetch_assoc($peopleRes)) {
        foreach($row as $key => $value) {
            $cellType = 'td';		
			$extraAttrs = '';
            if(is_array($value)){					
                if(isset($value['cell_type']) && !empty($value['cell_type'])) $cellType = $value['cell_type'];
            	$extraAttrs = $value['attrs'];
				$value = $value['value'];
			}
            
            $table .= "<$cellType $extraAttrs>$value</$cellType>";
            $table .= '</tr>';

            $table .= '<tr><td colspan="4">';
            $table .= '<div id="accordion" class="collapse">';
            $table .= '<table class="table">';
            $table .= '<thead><th></th><th></th><th></th></thead>';
            $table .= '<tbody><tr>';

            while($foo = mysqli_fetch_assoc($qryRes)) {
                foreach($foo as $key => $value) {
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
            } //END SECOND  LAYER
		}        
    } //END FIRST LAYER

    






    echo $table;
}



?>