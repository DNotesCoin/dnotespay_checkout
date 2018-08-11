<?php 
//***UPDATE YOUR CONFIGURATIONS HERE***
$amount = "8"; // Amount to pay. Configure to your carts total payment. 
$tolerance = 0.1; // Payment tolerance default 0.1
$confirmation_url = "https://website.com/thankyou.php"; // Thank you page once order has been processed
$confirm_num = 6; // Number of transaction confirmations required( 0=Fastest, payment has been sent but not confirmed to be valid, up to 1 minute 6=Slow, up to 6 minutes, transaction fully validated on the network )
$p_description = "Change this text to your own short description"; // A short description shown on the payment page
$all_addresses = array("SN3F6mFQ7eydWh7xyYRGRpLmpweav67hdK", "SN3F6mFQ7eydWh7xyYRGRpLmpweav67hdK", "SN3F6mFQ7eydWh7xyYRGRpLmpweav67hdK"); // Add your DNotes addresses to receive payment
$d_address = array_random($all_addresses);
$order_num = "125"; // Order number. Configure to your carts order number or unique identification number for the order. 


function array_random($arr, $num = 1) {
    shuffle($arr);
    
    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}
?>

<?php 
//***ADD THE FOLLOWING BUTTON TO YOUR CHECKOUT PAGE***
?>


<style>
#dnotes_buttonvalue {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:5px;
    border:1px solid #337bc4;
    display:inline-block;
    cursor:pointer;
    color:#ffffff;
    font-family:Arial;
    font-size:17px;
    font-weight:bold;
    padding:10px 21px;
    text-decoration:none;
    background: #29abe2;
}
</style>
    <form id="DnotesForm" method="post" action="dnotes_payment.php" target="DnotesWindow">
      <input type="hidden" id="p_description" name="p_description" value="<?php echo $p_description ?>">
      <input type="hidden" id="d_address" name="d_address" value="<?php echo $d_address ?>">
      <input type="hidden" id="amount" name="amount" value="<?php echo $amount ?>">
      <input type="hidden" id="tolerance" name="tolerance" value="<?php echo $tolerance ?>">
      <input type="hidden" id="confirmation_url" name="confirmation_url" value="<?php echo $confirmation_url ?>">
      <input type="hidden" id="confirm_num" name="confirm_num" value="<?php echo $confirm_num ?>">
      <input type="hidden" id="order_num" name="order_num" value="<?php echo $order_num ?>">
      <input type="button" id="dnotes_buttonvalue" class="buy-button" value="Pay with DNotes Pay" onclick="return PaymentpageShow();return false;">
    </form>
        <script>
            function PaymentpageShow() {
                newwindow = window.open('', 'DnotesWindow', 'toolbar=yes,scrollbars=yes,resizable=yes,top=350,left=500,width=650,height=600');
                document.getElementById('DnotesForm').submit();
                if (window.focus) {newwindow.focus()}
            }
        </script>

