<?php

include_once 'database.php';

$url = 'http://image-database-env-mfmus2tjm5.elasticbeanstalk.com/api/v1/campaigns/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: application/json'));
$returnData = curl_exec($ch);
curl_close($ch);

$jsonData = json_decode($returnData,true);

$sql = "INSERT INTO campaigns (
						`id`, 
						`customer_campaign_id`, 
						`installer_campaign_id`, 
						`advertiser`, 
						`created`, 
						`modified` 
						)
		VALUES ( :id, :customerID, :installerID, :advertiser, :created, :modified )";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id',   			$id,  			PDO::PARAM_STR);
$stmt->bindParam(':customerID',     $customerID,    PDO::PARAM_STR);
$stmt->bindParam(':installerID',   	$installerID,  	PDO::PARAM_STR);
$stmt->bindParam(':advertiser',     $advertiser,    PDO::PARAM_STR);
$stmt->bindParam(':created',      	$created,     	PDO::PARAM_STR);
$stmt->bindParam(':modified',      	$modified,     	PDO::PARAM_STR);

if(!empty($jsonData)){
    foreach ($jsonData as $key => $data) {
        //print_r($data);die();
        $id 			= $data['id'];
        $customerID 	= $data['customer_campaign_id'];
        $installerID 	= $data['installer_campaign_id'];
        $advertiser 	= $data['advertiser'];
        $created		= date('Y-m-d H:i:s');
        $modified		= date('Y-m-d H:i:s');

        $stmt->execute(); 
        echo $pdo->lastInsertId().'<br />';
    }
} else {
	echo 'Empty Set';
}
?>