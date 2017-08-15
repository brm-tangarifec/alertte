<?php

ini_set('display_errors', 1);
require('class/classMongo.php');
$alertMongo= new AlertMongo();


$lastTweet=$alertMongo->searhLastIdTweet();

if(!empty($lastTweet)){
    $lastSend=$lastTweet[0]['lastSend'];
}else{
    $lastSend=0;
}

//$alertMongo->printVar($lastSend);
//die();

$concidencias=array('Avianca',"@Avianca");
$almacen=array();
foreach ($concidencias as $key => $value) {
    
    $result=$alertMongo->getTweetMongo($value,$lastSend);
    $count=count($result);
    for ($i=0;$i<$count;$i++){
        //printVar($result[$i]);
        array_push($almacen,$result[$i]);
        
    }
    
}

//echo count($almacen);
foreach ($almacen as $key=>$val ){
   // $maxRt=(int)$val->retweet;
    //$alertMongo->printVar($val);
    //if($maxRt>1){
        //echo "hola";
        //die();
       echo "idTweet: $val->idText Usuario $val->arrobaUsuario | Followers $val->followers | Favs $val->favorite | Retweets $val->retweet | Tweet $val->texto".";";
        
   // }    //json_encode($key:$val->texto);
    
}