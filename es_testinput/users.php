<?php
include_once 'database.php';

function makeHashPassword($password) {
	$work = str_pad(8, 2, '0', STR_PAD_LEFT);

    // Bcrypt expects the salt to be 22 base64 encoded characters including
    // dots and slashes. We will get rid of the plus signs included in the
    // base64 data and replace them with dots.
    if (function_exists('openssl_random_pseudo_bytes'))
    {
        $salt = openssl_random_pseudo_bytes(16);
    }
    else
    {
        $salt = Str::random(40);
    }

    $salt = substr(strtr(base64_encode($salt), '+', '.'), 0 , 22);

    return crypt($password, '$2a$'.$work.'$'.$salt);
}

$myfile = fopen("address.json", "r") or die("Unable to open file!");
$data = fread($myfile,filesize("address.json"));
fclose($myfile);
$jsonData = json_decode($data, true);

$sql = "INSERT INTO users (`fullname` ,
							`email` ,
							`password` ,
							`skill` ,
							`phone` ,
							`photo` ,
							`birthdate` ,
							`gender` ,
							`address` ,
							`aboutme` ,
							`latitude` ,
							`longitude` ,
							`status` ,
							`created_at` ,
							`updated_at`)
         VALUES (   :fullname, 
                    :email,                      
                    :password, 
                    :skill,
                    :phone, 
                    :photo, 
                    :birthdate, 
                    :gender, 
                    :address, 
                    :aboutme, 
                    :latitude, 
                    :longitude,
                    :status,
                    :created, 
                    :updated)";


$stmt = $pdo->prepare($sql);
$stmt->bindParam(':fullname',   $fullname,  PDO::PARAM_STR);
$stmt->bindParam(':email',      $email,     PDO::PARAM_STR);
$stmt->bindParam(':password',   $password,  PDO::PARAM_STR);
$stmt->bindParam(':skill',      $skill,     PDO::PARAM_INT);
$stmt->bindParam(':phone',      $phone,     PDO::PARAM_STR);
$stmt->bindParam(':photo',      $photo,     PDO::PARAM_STR);
$stmt->bindParam(':birthdate',  $birthdate, PDO::PARAM_STR);
$stmt->bindParam(':gender',     $gender,    PDO::PARAM_STR);
$stmt->bindParam(':address',    $address,   PDO::PARAM_STR);
$stmt->bindParam(':aboutme',    $aboutme,   PDO::PARAM_STR);
$stmt->bindParam(':latitude',   $latitude,  PDO::PARAM_STR);
$stmt->bindParam(':longitude',  $longitude, PDO::PARAM_STR);
$stmt->bindParam(':status',     $status,    PDO::PARAM_STR);
$stmt->bindParam(':created',    $created,   PDO::PARAM_STR);
$stmt->bindParam(':updated',    $updated,   PDO::PARAM_STR);


$created    = date('Y:m:d H:i:s');
$updated    = date('Y:m:d H:i:s');
$status     = 'active';

if(!empty($jsonData)){
    foreach ($jsonData as $key => $data) {
        $em = explode('@', $data['email']);

        $fullname = $data['fullname'];
        $email = $em[0].'@easyservice.com';
        $password = makeHashPassword($em[0]);
        $skill = rand(1,13);
        $phone = $data['phone'];
        $photo = $data['photo'];
        $birthdate = $data['birthdate'];
        $gender = $data['gender'];
        $address = $data['address'];
        $aboutme = $data['about'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        $stmt->execute(); 
        echo $pdo->lastInsertId().'<br />';
    }
}

?>
