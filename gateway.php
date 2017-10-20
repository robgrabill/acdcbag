<?php
include('setlist.php');
include('jam.php');
include('randomfire.php');
$parse = $_POST['text'];
if (strpos($parse, 'setlist') !== false) {
    $parameter= substr(strstr("$parse"," "), 1); 
    setlist_function($parameter);
} elseif (strpos($parse, 'jam') !==false) {
    $parameter= substr(strstr("$parse"," "), 1); 
    jam_function($parameter);
} elseif (strpos($parse, 'randomfire') !==false) {
    $parameter= substr(strstr("$parse"," "), 1); 
    randomfire_function($parameter);
} else {
   echo "Foggy, rather groggy. Try again.";
}
?>
