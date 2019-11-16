<?php

//Enable debugging
ini_set('html_errors', true);
ini_set('display_errors', true);
error_reporting(E_ALL);

//Include the library and setup the page
include ("../funcs/autoload.php");
new cc_builder("Gifticality | Wishlist", "Create a new wishlist or add some new items!");

//Setup the people-searchey thing
$link = mysqli_connect("localhost", "pi", "reverse", "boxx");
$sql = "SELECT uniqueID, first_name, last_name FROM people;";
$res = mysqli_query($link, $sql);
$peopleArr = array();
while ($foo = mysqli_fetch_assoc($res)) {
    $peopleArr[$foo["uniqueID"]] = $foo["first_name"] . " " . $foo["last_name"];
}

//Build select

$select = '';
$select .= '<select class="custom-select custom-select-sm" id="personID">';
$select .= '<option selected>Open this select menu</option>';
foreach($peopleArr as $key=> $value){
    $select .= "<option value=\"$key\">$value</option>";
}
$select .= '</select>';

echo '<form id="peopleSelect">';
echo $select;
echo '<button class="btn btn-sm btn-primary" type="submit">Search!</button>';
echo '</form>';
echo '<div id="empty">';

?>

<!-- Modal -->
<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog modal-lg">
 
     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Wishlist</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
 
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
     </div>
    </div>
   </div>


<script>
  $(document).ready(function(){
    $('#peopleSelect').on('submit', function(e){
      //Stop the form from submitting itself to the server.
      e.preventDefault();
      var search = $('#personID').val();
      console.log(search);
      $.ajax({
          type: "GET", 
          url: '../api/wishlistController.php', 
          data: {personID: search}, 
          success: function(data){
            $('.modal-body').html(data);
            $('#empModal').modal('show');
          }
        });
    });
  });
</script>