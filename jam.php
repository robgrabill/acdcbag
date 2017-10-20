<?php
include('simple_html_dom.php');
function jam_function($parameter)
{
$channel = $_POST['channel_id'];
$text = $parameter;
$cleantext = str_replace(" ", "-", $text);
$cleantext = strtolower($cleantext);
$url = "http://phish.net/jamcharts/song/".$cleantext."/";
$html = file_get_html($url);
$chartcheckdump = $html->find('h2');
$chartcheckarray = array();
foreach ($chartcheckdump as $man) {
  $chartcheckarray[] = $man->plaintext;
}
$ccstring = ($chartcheckarray[0]);
$ccpos = strpos($ccstring, "0 entries");

if ($chartcheckarray[0]==NULL){
  echo "Couldn't find that song. Try again.";
} elseif ($ccpos===FALSE){
  $es = $html->find('table td');
  $array = array();
  foreach ($es as $boy) {
    $array[] = $boy->plaintext;
  }
  $keeperarray = array();
  foreach ($array as $keeper) {
    if (strlen($keeper)==10) {
      $keeperarray[] = $keeper;
    }
  }

  $winnerkey = array_rand($keeperarray);
  $winner = ($keeperarray[$winnerkey]);
  $desckey = $winnerkey*5+4;
  $winnerdesc = ($array[$desckey]);
  $winnerdesc2 = str_replace("&quot;", "", $winnerdesc);
  $streamlink = "http://phish.in/".$winner."/".$cleantext."/";
  $streamlink2 = "http://phishtracks.com/shows/".$winner."/".$cleantext."";
  $venueurl = "http://phish.in/api/v1/shows/:".$winner."";

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "$venueurl",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "{}",
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  $decode = json_decode($response);
  $venuearray = json_decode(json_encode($decode), true);
  $venue = ($venuearray["data"]["venue"]["name"]);

  $payloadtext = "----------------\n";
  $payloadtext .= "Random Jamchart Version of ";
  $payloadtext .= $text;
  $payloadtext .= "\n\n";
  $payloadtext .= "<".$streamlink."|".$winner.">";
  $payloadtext .= "\n\n";
  $payloadtext .= "<".$streamlink2."|(mobile)>";
  $payloadtext .= "\n\n";
  $payloadtext .= "*".$venue."*";
  $payloadtext .= "\n\n";
  $payloadtext .= $winnerdesc2;

  $payloadarray = array(
    "username" => "AC/DC Bag",
    "channel" => $channel,
    "text" => $payloadtext,
    "markdwn" => true,
  );
  $slack_webhook_url = getenv('WEB_HOOK');
  $json_payload = json_encode($payloadarray);
  $slack_call = curl_init($slack_webhook_url);
  curl_setopt($slack_call, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
  curl_setopt($slack_call, CURLOPT_POSTFIELDS, $json_payload);
  curl_setopt($slack_call, CURLOPT_CRLF, true);                                                               
  curl_setopt($slack_call, CURLOPT_RETURNTRANSFER, true);                                                                      
  curl_setopt($slack_call, CURLOPT_HTTPHEADER, array(                                                                          
    "Content-Type: application/json",                                                                                
    "Content-Length: " . strlen($json_payload))                                                                       
  );                                                                                                                   
  $result = curl_exec($slack_call);
  curl_close($slack_call);
  } else {
  echo "No JamChart exists for that song.";
}
}
?>
