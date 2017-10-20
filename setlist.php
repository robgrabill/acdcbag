<?php
function setlist_function($parameter)
{
$channel = $_POST['channel_id'];
$showdate = $parameter;
$url = "http://phish.in/api/v1/shows/:".$showdate."";

//$channel = "#bottests";
//$showdate = "2014-11-03";
//$url = "http://phish.in/api/v1/shows/:2014-11-02";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$url",
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
$array = json_decode(json_encode($decode), true);
$exists = ($array["success"]);
if ($exists==NULL){
  echo "Setlist not found.";
} else {

$setlist = "----------------\n";
$setlist .= ("*".$array["data"]["venue"]["name"]."*\n");
$setlist .= "*".$showdate."*\n";
$setlist .= "<http://phish.net/setlists/?d=".$showdate."|Phish.net>";
$setlist .= "\n";
$tracks = count($array["data"]["tracks"]);

$set_exists=array_search("Set 1", array_column($array["data"]["tracks"], "set_name"));
$set_exists_type=gettype($set_exists);
if ($set_exists_type=="integer"){
  $set1 ="\n\n*Set 1*\n\n";
  for ($row = 0; $row < $tracks; $row++) {
    $setcheck=$array["data"]["tracks"]["$row"]["set"]; 
    if ($setcheck==1){
      $songtitle = ($array["data"]["tracks"]["$row"]["title"]);
      $songtitleclean = str_replace(">", "&gt;", $songtitle);
      $songslug = ($array["data"]["tracks"]["$row"]["slug"]);
      $songslugclean = str_replace(">", "&gt;", $songslug);
      $set1 .= "<http://phish.in/".$showdate."/".$songslug."/|".$songtitle.">";
      $set1 .= ", ";
    } 
  }
$set1trimmed = rtrim($set1,', ');
$setlist .= $set1trimmed;
}

$set_exists=array_search("Set 2", array_column($array["data"]["tracks"], "set_name"));
$set_exists_type=gettype($set_exists);
if ($set_exists_type=="integer"){
  $setlist .="\n\n*Set 2*\n\n";
  for ($row = 0; $row < $tracks; $row++) {
    $setcheck=$array["data"]["tracks"]["$row"]["set"]; 
    if ($setcheck==2){
      $songtitle = ($array["data"]["tracks"]["$row"]["title"]);
      $songtitleclean = str_replace(">", "&gt;", $songtitle);
      $songslug = ($array["data"]["tracks"]["$row"]["slug"]);
      $songslugclean = str_replace(">", "&gt;", $songslug);
      $set2 .= "<http://phish.in/".$showdate."/".$songslugclean."/|".$songtitleclean.">";
      $set2 .= ", ";
    } 
  }
$set2trimmed = rtrim($set2,', ');
$setlist .= $set2trimmed;
}

$set_exists=array_search("Set 3", array_column($array["data"]["tracks"], "set_name"));
$set_exists_type=gettype($set_exists);
if ($set_exists_type=="integer"){
  $setlist .="\n\n*Set 3*\n\n";
  for ($row = 0; $row < $tracks; $row++) {
    $setcheck=$array["data"]["tracks"]["$row"]["set"]; 
    if ($setcheck==3){
      $songtitle = ($array["data"]["tracks"]["$row"]["title"]);
      $songtitleclean = str_replace(">", "&gt;", $songtitle);
      $songslug = ($array["data"]["tracks"]["$row"]["slug"]);
      $songslugclean = str_replace(">", "&gt;", $songslug);
      $set3 .= "<http://phish.in/".$showdate."/".$songslug."/|".$songtitle.">";
      $set3 .= ", ";
    } 
  }
$set3trimmed = rtrim($set3,', ');
$setlist .= $set3trimmed;
}

$set_exists=array_search("Encore", array_column($array["data"]["tracks"], "set_name"));
$set_exists_type=gettype($set_exists);
if ($set_exists_type=="integer"){
  $setlist .="\n\n*Encore*\n\n";
  for ($row = 0; $row < $tracks; $row++) {
    $setcheck=$array["data"]["tracks"]["$row"]["set"]; 
    if ($setcheck=="E"){
      $songtitle = ($array["data"]["tracks"]["$row"]["title"]);
      $songtitleclean = str_replace(">", "&gt;", $songtitle);
      $songslug = ($array["data"]["tracks"]["$row"]["slug"]);
      $songslugclean = str_replace(">", "&gt;", $songslug);
      $setE .= "<http://phish.in/".$showdate."/".$songslug."/|".$songtitle.">";
      $setE .= ", ";
    } 
  }
$setEtrimmed = rtrim($setE,', ');
$setlist .= $setEtrimmed;
}

$set_exists=array_search("Encore 2", array_column($array["data"]["tracks"], "set_name"));
$set_exists_type=gettype($set_exists);
if ($set_exists_type=="integer"){
  $setlist .="\n\n*Encore 2*\n\n";
  for ($row = 0; $row < $tracks; $row++) {
    $setcheck=$array["data"]["tracks"]["$row"]["set"]; 
    if ($setcheck=="E2"){
      $songtitle = ($array["data"]["tracks"]["$row"]["title"]);
      $songtitleclean = str_replace(">", "&gt;", $songtitle);
      $songslug = ($array["data"]["tracks"]["$row"]["slug"]);
      $songslugclean = str_replace(">", "&gt;", $songslug);
      $setE2 .= "<http://phish.in/".$showdate."/".$songslug."/|".$songtitle.">";
      $setE2 .= ", ";
    } 
  }
$setE2trimmed = rtrim($setE2,', ');
$setlist .= $setE2trimmed;
}

$set_exists=array_search("Set 4", array_column($array["data"]["tracks"], "set_name"));
$set_exists_type=gettype($set_exists);
if ($set_exists_type=="integer"){
  $setlist .="\n\n*Set 4*\n\n";
  for ($row = 0; $row < $tracks; $row++) {
    $setcheck=$array["data"]["tracks"]["$row"]["set"]; 
    if ($setcheck==4){
      $songtitle = ($array["data"]["tracks"]["$row"]["title"]);
      $songtitleclean = str_replace(">", "&gt;", $songtitle);
      $songslug = ($array["data"]["tracks"]["$row"]["slug"]);
      $songslugclean = str_replace(">", "&gt;", $songslug);
      $set4 .= "<http://phish.in/".$showdate."/".$songslug."/|".$songtitle.">";
      $set4 .= ", ";
    } 
  }
$set4trimmed = rtrim($set4,', ');
$setlist .= $set4trimmed;
}

$payloadarray = array(
  "username" => "AC/DC Bag",
  "channel" => $channel,
  "text" => $setlist,
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
}
?>
