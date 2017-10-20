<?php
include('setlist.php');
include('jam.php');
include('randomfire.php');
$parse = $_POST['text'];
if (strpos($parse, 'setlist') !== false) {
    $parameter= substr(strstr("setlist"," "), 1); 
    setlist_function();
} elseif (strpos($parse, 'jam') !==false) {
    $parameter= substr(strstr("jam"," "), 1); 
    jam_function();
} elseif (strpos($parse, 'randomfire') !==false) {
    $parameter= substr(strstr("randomfire"," "), 1); 
    randomfire_function();
} else {
   echo "Foggy, rather groggy. Try again.";
}
?>
