<?php
include('setlist.php');
include('jam.php');
include('randomfire.php');
$parse = $_POST['text'];
if (strpos($parse, 'setlist') !== false) {
    setlist_function();
} elseif (strpos($parse, 'jam') !==false) {
    jam_function();
} elseif (strpos($parse, 'randomfire') !==false) {
    randomfire_function();
} else {
   echo "Foggy, rather groggy. Try again.";
}
?>
