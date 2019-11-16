<?php
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>