<?php
include('simple_html_dom.php');
$channel = $_POST['channel_id'];
$text = $_POST['text'];
//$channel = "@rob";
//$text = "aaa";
$cleantext = str_replace(" ", "-", $text);
$url = "https://phish.net/song/".$cleantext."/lyrics/";
$html = file_get_html($url);
$elem = $html->find('blockquote', 0);
if ($elem==NULL){
  echo "No lyrics found.";
} else {
$clean1 = str_replace("<br />", "\n", $elem);
$clean2 = str_replace("<blockquote class='bq'>", "", $clean1);
$clean3 = str_replace("</blockquote>", "", $clean2);
$clean4 = str_replace("&#8232;", "", $clean3);
$clean5 = str_replace("\t", "", $clean4);
$decodelyrics = "$text Lyrics:\n";
$decodelyrics .=$clean5;

$payloadarray = array(
  "username" => "AC/DC Bag",
  "channel" => $channel,
  "text" => $decodelyrics,
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
}
?>