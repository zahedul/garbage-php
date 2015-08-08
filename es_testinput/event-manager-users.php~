<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbName = 'event_manager';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

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

$myfile = fopen("event-manager-users.json", "r") or die("Unable to open file!");
$data = fread($myfile,filesize("event-manager-users.json"));
fclose($myfile);
$jsonData = json_decode($data, true);

$sql = "INSERT INTO users (`firstname` ,
							`lastname`,
							`email` ,
							`password` ,
							`company` ,
							`phonenumber`,
							`role`,
							`type`,
							`created` ,
							`updated`)
         VALUES (   :firstname, 
                    :lastname,                      
                    :email, 
                    :password,
                    :company, 
                    :phonenumber, 
                    :role, 
                    :type,
                    :created, 
                    :updated)";


$stmt = $pdo->prepare($sql);
$stmt->bindParam(':firstname',   $firstname,  PDO::PARAM_STR);
$stmt->bindParam(':lastname',      $lastname,     PDO::PARAM_STR);
$stmt->bindParam(':email',      $email,     PDO::PARAM_STR);
$stmt->bindParam(':password',   $password,  PDO::PARAM_STR);
$stmt->bindParam(':phonenumber',      $phonenumber,     PDO::PARAM_STR);
$stmt->bindParam(':company',      $company,     PDO::PARAM_STR);
$stmt->bindParam(':role',  $role, PDO::PARAM_STR);
$stmt->bindParam(':type',     $type,    PDO::PARAM_STR);
$stmt->bindParam(':created',    $created,   PDO::PARAM_STR);
$stmt->bindParam(':updated',    $updated,   PDO::PARAM_STR);


$created    = date('Y:m:d H:i:s');
$updated    = date('Y:m:d H:i:s');
$type    = 'user';

if(!empty($jsonData)){
    foreach ($jsonData as $key => $data) {
        $em = explode('@', $data['email']);

        $firstname = $data['firstname'];
		$lastname = $data['lastname'];
        $email = $data['email'];
        $password = $em[0];        
        $phonenumber = $data['phone'];
        $company = $data['company'];
        $role = $data['role'];
        $type = $type;

        $stmt->execute(); 
        echo $pdo->lastInsertId().'<br />';
    }
}

?>
