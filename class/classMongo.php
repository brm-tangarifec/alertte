<?php

class AlertMongo{
    /*Función para hacer depuración del código*/
    function printVar( $variable, $title = "" ){
        $var = print_r( $variable, true );
        echo "<pre style='background-color:#dddd00; border: dashed thin #000000;'><strong>[$title]</strong> $var</pre>";
    }
    /*Funciòn para mongo */
    
    function insertTweet($campos) {
        //printVar($campos);
        //die();
        $mongo = new MongoDB\Driver\Manager();
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert([
            "idText" => (string)$campos['idText'],
            "texto" => (string)$campos['textoTw'],
            "idUsuario" => (string)$campos['idTw'],
            "arrobaUsuario" => $campos['arroa'],
            "followers" => $campos['followers'],
            "retweet" => $campos['retweet'],
            "favorite" => $campos['favorite'],
            "cuentaInsert" => $campos['cuentaInsert'],
            "enviado" => 'N',
            "fechaCreacion" => $campos['fechaText'],
            "fecha" => new \MongoDB\BSON\UTCDateTime(),
            "fechaEnvio" => ''
            ]);
            $result = $mongo->executeBulkWrite('callaut.tweet', $bulk);
            if ($result->getInsertedCount() >= 1) {
                return true;
                
            } else {
                return false;
                
            }
        
    }
    // Get tweet into collection
    function getTweet($idStr) {
        //printVar($idStr);
        $mongo = new MongoDB\Driver\Manager();
        $query = new MongoDB\Driver\Query(['idText' => $idStr], []);
        $cursor = $mongo->executeQuery('callaut.tweet', $query);
        $posts = [];
        foreach ($cursor as $document) {
            //printVar($document);
            //die();
            array_push($posts, json_decode(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($document))));
            
        }
        return $posts;
        
    }
    
    // Get word for search
    function getTWord() {
        //printVar($idStr);
        $mongo = new MongoDB\Driver\Manager();
        $query = new MongoDB\Driver\Query([], []);
        $cursor = $mongo->executeQuery('callaut.av_search', $query);
        $posts = [];
        foreach ($cursor as $document) {
            //printVar($document);
            //die();
            array_push($posts, json_decode(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($document))));
            
        }
        return $posts;
        
    }
        
    /*Función para mongo */
    function getTweetMongo($texto,$lastSend) {
       //$this->printVar($lastSend);
       $lastSend=$lastSend+1;
       //$feche=new MongoDB\BSON\UTCDateTime($idlast[0]['fecha']);
       //$this->printVar($feche);
       //die();
        $mongo = new MongoDB\Driver\Manager();
        $filter=['texto' => new MongoDB\BSON\Regex($texto,'i'),'cuentaInsert'=> ['$gte' => $lastSend]];
        $options=[
            'sort' => ['_id' => -1]
            ];
        $query = new MongoDB\Driver\Query($filter,$options);
    
        $cursor = $mongo->executeQuery('callaut.tweet', $query);
        //printVar($cursor);
        $posts = [];
        foreach ($cursor as $document) {
            array_push($posts, json_decode(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($document))));
        }
        return $posts;
        
    }
    
    //Función para insertar el ùltimo tweet enviado
    function insertLastTweetSend($campos){
        $this->printVar($campos['cuentaInsert']);
        $mongo = new MongoDB\Driver\Manager();
        $filter=['lastSend'=>$campos['cuentaInsert']];
        $options=['limit' => 1];
        $query = new MongoDB\Driver\Query($filter,$options);
        $cursor = $mongo->executeQuery('callaut.tweetsend', $query);
        //$this->printVar($cursor);
        $last=[];
        foreach($cursor as $doc){
           //$this->printVar($doc);
           array_push($last,$doc->lastSend);
          
        }
        
        if(empty($last)){
            $bulk = new MongoDB\Driver\BulkWrite;
             $bulk->insert([
            "idLastTweet" => (string)$campos['id'],
            "fecha" => new \MongoDB\BSON\UTCDateTime($campos['fecha']),
            "lastSend" => $campos['cuentaInsert']
            ]);
            $result = $mongo->executeBulkWrite('callaut.tweetsend', $bulk);
            if ($result->getInsertedCount() >= 1) {
                return true;
                
            } else {
                return false;
                
            }
        }else{
            return false;
        }
    }
    
    //Función para obtener el último _id de antes de agregar nuevos tweets
    function getLastIdTweet(){
        $mongo = new MongoDB\Driver\Manager();
        $options = [
            'sort' => ['cuentaInsert' => -1],
            'limit' => 1,
            ];
        $query = new MongoDB\Driver\Query([], $options);
        $cursor = $mongo->executeQuery('callaut.tweet', $query);
        $idtweet=[];
        $tweet=[];
        foreach ($cursor as $document) {
            //$this->printVar($document->fecha->__toString());
            //die();
            $tweet['id']=$document->_id->__toString();
            $tweet['fecha']=$document->fecha->__toString();
            $tweet['contador']=$document->cuentaInsert;
            array_push($idtweet,$tweet);
            
        }
        return $idtweet;
    }
    
    
    function searhLastIdTweet(){
        $mongo = new MongoDB\Driver\Manager();
        $options = [
            'sort' => ['_id' => -1],
            'limit' => 1,
            ];
        $query = new MongoDB\Driver\Query([], $options);
        $cursor = $mongo->executeQuery('callaut.tweetsend', $query);
        $idtweet=[];
        $tweet=[];
        foreach ($cursor as $document) {
            //$this->printVar($document->_id->__toString());
            //die();
            $tweet['lastSend']=$document->lastSend;
            //$tweet['fecha']=$document->fecha->__toString();
            array_push($idtweet,$tweet);
            //array_push($posts, json_decode(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($document))));
            
        }
        return $idtweet;
    }
    
    
    
    
    //Fin de la clase
}
