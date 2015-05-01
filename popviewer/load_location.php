<?php

include_once 'database.php';

$url = 'http://image-database-env-mfmus2tjm5.elasticbeanstalk.com/api/v1/locations/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: application/json'));
$returnData = curl_exec($ch);
curl_close($ch);

$jsonData = json_decode($returnData,true);
//echo '<pre>'; print_r($jsonData);die();
$sql = "INSERT INTO locations (
						`id`, 
						`panel_id`, 
						`latitude`, 
						`longitude`,
                        `name`,
                        `provider`,
                        `format`,
                        `example`,
                        `panel_alt_id`,
						`created`, 
						`modified` 
		)
		VALUES ( :id, 
                :panel_id, 
                :latitude, 
                :longitude, 
                :name,
                :provider,
                :format,
                :example,
                :panel_alt_id,
                :created,
                :modified 
        )";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id',   			$id,  			PDO::PARAM_STR);
$stmt->bindParam(':panel_id',       $panel_id,      PDO::PARAM_STR);
$stmt->bindParam(':latitude',   	$latitude,  	PDO::PARAM_STR);
$stmt->bindParam(':longitude',      $longitude,     PDO::PARAM_STR);
$stmt->bindParam(':name',           $name,          PDO::PARAM_STR);
$stmt->bindParam(':provider',       $provider,      PDO::PARAM_STR);
$stmt->bindParam(':format',         $format,        PDO::PARAM_STR);
$stmt->bindParam(':example',        $example,       PDO::PARAM_STR);
$stmt->bindParam(':panel_alt_id',   $panel_alt_id,  PDO::PARAM_STR);
$stmt->bindParam(':created',      	$created,     	PDO::PARAM_STR);
$stmt->bindParam(':modified',      	$modified,     	PDO::PARAM_STR);

if(!empty($jsonData)){
    foreach ($jsonData as $key => $data) {
        $id 			= $data['id'];
        $panel_id 	    = $data['panel_id'];
        $latitude 	    = $data['latitude'];
        $longitude 	    = $data['longitude'];
        $name           = $data['name'];
        $provider       = $data['panel_id'];
        $format         = $data['latitude'];
        $example        = $data['longitude'];
        $panel_alt_id   = $data['panel_alt_id'];
        $created		= date('Y-m-d H:i:s');
        $modified		= date('Y-m-d H:i:s');

        $stmt->execute(); 
        echo $pdo->lastInsertId().'<br />';
    }
} else {
	echo 'Empty Set';
}
?>