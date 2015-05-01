<?php
include_once 'database.php';

$myfile = fopen("skills", "r") or die("Unable to open file!");
$data = fread($myfile,filesize("skills"));
fclose($myfile);

$string = preg_replace('/[0-9]/', '', $data);
$data = explode(PHP_EOL,trim($string));

//echo '<pre>';print_r($data);
$sql = "INSERT INTO skills (`name`,`created_at`,`updated_at`)
         VALUES (:name, :created, :updated)";

$stmt = $pdo->prepare($sql);
for ($i=0; $i <count($data) ; $i++) {     
    if(strlen(trim($data[$i])) > 0) { 
        $stmt->bindParam(':name', $data[$i], PDO::PARAM_STR);      
        $stmt->bindParam(':created', date('Y:m:d H:i:s'), PDO::PARAM_STR);  
        $stmt->bindParam(':updated', date('Y:m:d H:i:s'), PDO::PARAM_STR);  

        $stmt->execute(); 
        echo $pdo->lastInsertId().'<br />';    
    }
    
}


?>
