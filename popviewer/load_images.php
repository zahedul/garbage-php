<?php

include_once 'database.php';

$url = 'http://image-database-env-mfmus2tjm5.elasticbeanstalk.com/api/v1/images/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: application/json'));
$returnData = curl_exec($ch);
curl_close($ch);

$jsonData = json_decode($returnData,true);
//echo '<pre>'; print_r($jsonData);die();
$sql = "INSERT INTO images (
						`id`, 
						`installed_date`, 
						`publish_date`, 
						`path`,
                        `creative`,
                        `comments`,
                        `campaign_id`,
                        `location_id`,
                        `workorder_id`,
						`created`, 
						`modified` 
		)
		VALUES ( :id, 
                :installed_date, 
                :publish_date, 
                :path, 
                :creative,
                :comments,
                :campaign_id,
                :location_id,
                :workorder_id,
                :created,
                :modified 
        )";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id',   			$id,               PDO::PARAM_STR);
$stmt->bindParam(':installed_date', $installed_date,   PDO::PARAM_STR);
$stmt->bindParam(':publish_date',   $publish_date,     PDO::PARAM_STR);
$stmt->bindParam(':path',           $path,             PDO::PARAM_STR);
$stmt->bindParam(':creative',       $creative,         PDO::PARAM_STR);
$stmt->bindParam(':comments',       $comments,         PDO::PARAM_STR);
$stmt->bindParam(':campaign_id',    $campaign_id,      PDO::PARAM_STR);
$stmt->bindParam(':location_id',    $location_id,      PDO::PARAM_STR);
$stmt->bindParam(':workorder_id',   $workorder_id,     PDO::PARAM_STR);
$stmt->bindParam(':created',      	$created,     	   PDO::PARAM_STR);
$stmt->bindParam(':modified',      	$modified,     	   PDO::PARAM_STR);

if(!empty($jsonData)){
    foreach ($jsonData as $key => $data) {
        $id 			= $data['id'];
        $installed_date = $data['installed_date'];
        $publish_date	= $data['publish_date'];
        $path 	        = $data['path'];
        $creative       = $data['creative'];
        $comments       = $data['comments'];
        $campaign_id    = $data['campaign']['id'];
        $location_id    = $data['location']['id'];
        $workorder_id   = $data['workorder_id'];
        $created		= date('Y-m-d H:i:s');
        $modified		= date('Y-m-d H:i:s');

        $stmt->execute(); 
        echo $pdo->lastInsertId().'<br />';
    }
} else {
	echo 'Empty Set';
}
?>