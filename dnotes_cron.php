<?php
//***UPDATE YOUR DATABASE CONNECTION INFORMATION HERE***
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cart_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function CheckPayment( $address , $amount , $tolerance , $rowid , $row_num )
{
    //***UPDATE YOUR DATABASE CONNECTION INFORMATION HERE***
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cart_db";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$call_url = 'https://abe.dnotescoin.com/chain/DNotes/q/invoice/'.$address;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $call_url);
    $result = curl_exec($ch);
    curl_close($ch);

    $result_val = explode(",", $result);
    $limit_price = $amount - $tolerance;
    if( ($result_val[0] > $limit_price) && ($result_val[1] >= $row_num) )
    {
        $update_sql = 'UPDATE dnotes SET `state` = "complete" where `id` = ' . $rowid;
        $conn->query($update_sql);
		//***UPDATE YOUR ORDER TO MARK IT COMPLETE HERE***
    }
} 

$sql = "SELECT * FROM dnotes where `state` != 'complete' and `date` >= NOW() - INTERVAL 36 HOUR";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        CheckPayment( $row["address"] , $row["amount"] , $row["tolerance"] , $row["id"] , $row["confirmations_num"] );
    }
}

$conn->close();
?>
