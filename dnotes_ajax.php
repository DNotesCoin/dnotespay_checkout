<?php
//***UPDATE YOUR DATABASE CONNECTION INFORMATION HERE***
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "cart_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$order_num = $_POST['order_num'];
$amount = $_POST['amount'];
$address = $_POST['address'];
$invoice_num = $_POST['invoice_num'];
$tolerance = $_POST['tolerance'];
$confirmations_num = $_POST['confirmations_num'];
$today_value = date("Y-m-d H:i:s");

$sql = "INSERT INTO dnotes (`order_num` , `amount` , `address` , `invoice_num` , `tolerance` , `confirmations_num` , `date` , `state`) 
    VALUES ('$order_num' , '$amount' , '$address' , '$invoice_num' , '$tolerance' , '$confirmations_num' , '$today_value' , 'complete' )";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
