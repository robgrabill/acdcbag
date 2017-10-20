<?php
include('setlist.php');
include('jam.php');
include('randomfire.php');
$parse = $_POST['text'];
if (strpos($parse, 'setlist') !== false) {
    $parameter= substr(strstr("setlist"," "), 1); 
    setlist_function($parameter);
} elseif (strpos($parse, 'jam') !==false) {
    $parameter= substr(strstr("jam"," "), 1); 
    echo $parameter;
    jam_function();
} elseif (strpos($parse, 'randomfire') !==false) {
    $parameter= substr(strstr("randomfire"," "), 1); 
    echo $parameter;
    randomfire_function();
} else {
   echo "Foggy, rather groggy. Try again.";
}
?>
