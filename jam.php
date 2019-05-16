<?php
include('simple_html_dom.php');

// Create variables for the channel to post back to and the text that was searched for.
$channel = $_POST['channel_id'];
$text = $_POST['text'];

//Create slug used to build song URL and Jamchart URL
$cleantext = str_replace(" ", "-", $text);
$cleantext = strtolower($cleantext);

//Grab jamchart and dump into array... then do some other stuff. Not gonna worry about this too much as it's all going away with v2.
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
  
//In lieu of the jamchart scraping, here's where we'll need to do steps 4-8. It should be simpler than what's above, but there may be some stuff to pick up/copy over.
  
//Here we pick up at step 9. The array_rand function will still be used, the rest may not.
  $winnerkey = array_rand($keeperarray);
  $winner = ($keeperarray[$winnerkey]);
  
//This will probably be pitched as we're now getting the description from the .in API.
  $desckey = $winnerkey*5+4;
  $winnerdesc = ($array[$desckey]);
  
//This is formatting that we'll maybe need, maybe not based on how the description comes back.
  $winnerdesc2 = str_replace("&quot;", "", $winnerdesc);
  
//This is step 15b
  $streamlink = "http://phish.in/".$winner."/".$cleantext."/";
  
//This is optional depending on if we want to keep the phishtracks link
  $streamlink2 = "http://phishtracks.com/shows/".$winner."/".$cleantext."";

//This... doesn't seem to work at all! Is all of this just to get the venue? We can definitely get this from the .in API.
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
    CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: 1424bc7de102445b1f788d0d589c44120032c379bd74c8f081b1f94e6c4c4d3e8d831b8b1b99dc89d469b21a2bf12ee3",
    "cache-control: no-cache",
    "postman-token: 25e77aed-7681-9476-fab4-14129d3f78e6"
  ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  $decode = json_decode($response);
  $venuearray = json_decode(json_encode($decode), true);
  $venue = ($venuearray["data"]["venue"]["name"]);

//Building the payload.
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

//Sending to the webhook.
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
  
//Good lord is this whole thing embedded in the if statement started back on 22? It doesn't appear so, but wtf. So glad I'm redoing this. 
  } else {
  echo "No JamChart exists for that song.";
}
?>
