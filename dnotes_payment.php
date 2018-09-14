<?php
        $amount_price = (float)$_POST['amount'];
        $tolerance = (float)$_POST['tolerance'];
        if($tolerance)
            $tolerance = $tolerance;
        else
            $tolerance = 0.01;
        $confirmation_url = filter_input(INPUT_POST, 'confirmation_url', FILTER_SANITIZE_URL);
        $confirmations_num = (int)$_POST['confirm_num'];
        $dnotes_address = filter_input(INPUT_POST, 'd_address', FILTER_SANITIZE_STRING);
        $p_description = filter_input(INPUT_POST, 'p_description', FILTER_SANITIZE_STRING);
        $order_num = filter_input(INPUT_POST, 'order_num', FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="dnotespay.css" type="text/css" />
</head>
<body>
    <div id="dnotes-page">
            <p class="header-ordernum">No.<?php echo $order_num; ?></p>
            <h1 class="header-text"><img src="header.png" alt="header"></h1>
            <div style="margin-top:4%;">
            <div id="loading"></div>
            <div style="display: inline-block;vertical-align: top;margin-top: 0px;">
                <p style="margin: 5px;font-size: 20px;font-weight: bold;">Pay with DNotes</p>
                <p style="margin: 5px;font-style: italic;font-size: 15px;"><?php echo $p_description ;  ?></p>
            </div>
            </div>
            <div id="dnotes-content">
                <div id="content-blogval">
                    <?php
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v2/ticker/184/');
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                    $result_json = json_decode($result);
                    $result_data = $result_json->data;
                    $result_quotes = $result_data->quotes;
                    $result_usd = $result_quotes->USD;
                    $usd_price = $result_usd->price;
                    $show_usdprice = round($usd_price , 3);

                    // if($usd_notes =="0")
                    // {
                        $send_mount = round(( $amount_price / $usd_price ) , 5);
                    // }else{
                    //     $send_mount = $amount_price;
                    // }

                    $unix_time = time();
                    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < 10; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $invoice_number = $unix_time.$randomString;

                    $dnotes_address = substr( $dnotes_address , 0 , 34 );
                    $send_address = $dnotes_address."+".$invoice_number;

                ?>
                <input type="hidden" id="send_value_address" value="<?php echo $send_address;  ?>" />
                <input type="hidden" id="send_mount" name="send_mount" value="<?php echo $send_mount;  ?>" />
                <input type="hidden" id="confirmation_url" value="<?php echo $confirmation_url;  ?>" />
                <input type="hidden" id="confirmations_num" value="<?php echo $confirmations_num;  ?>" />
                <input type="hidden" id="tolerance" value="<?php echo $tolerance;  ?>" />
                <div style="font-size: 16px;margin-bottom: 15px;">
                  <font style="font-weight: bold;">Amount:</font> $<?php echo $amount_price;  ?>
                </div>
                <div style="font-size: 16px;margin-bottom: 15px;">
                    <font style="font-weight: bold;">Please send exactly: </font> 
                    <input style="width: 105px;font-size: 14px;border: 1px solid #fff;" type="text" id="copyAmount" value="<?php echo $send_mount; ?>" readonly>
                    <input type="button" value="Click to Copy" id="copy_amounty" class="btnsubmit-property" style="margin-left: 41%;">
                </div>
                <div style="font-size: 16px;margin-bottom: 15px;">
                    <font style="font-weight: bold;">To : </font>
                    <input style="width: 77%;font-size: 14px;border: 1px solid #fff;" type="text" id="copyTarget" value="<?php echo $send_address; ?>" readonly>
                    <input type="button" value="Click to Copy" id="copy_address" class="btnsubmit-property">
                </div>
                <div id="payment_state_btn">
                    <input onclick="PaymentInsert()" id="download_product" value="Click Here once Payment is Complete" class="download-btnprop">
                </div>
                <div style="margin-top:50px;">
                    <p class="state_checktext" id="state_checktext"></p>
                    <p style="width: 54%;display: inline-block;text-align: right;margin-bottom: 5px;">1 DNotes = <?php echo $show_usdprice; ?> USD</p>
                </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script>
                var check_flag = 0;
                document.getElementById("copy_address").addEventListener("click", function() {
                    copyToClipboard(document.getElementById("copyTarget"));
                });

                function copyToClipboard(elem) {
                    var targetId = "_hiddenCopyText_";
                    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
                    var origSelectionStart, origSelectionEnd;
                    if (isInput) {
                        target = elem;
                        origSelectionStart = elem.selectionStart;
                        origSelectionEnd = elem.selectionEnd;
                    } else {
                        target = document.getElementById(targetId);
                        if (!target) {
                            var target = document.createElement("textarea");
                            target.style.position = "absolute";
                            target.style.left = "-9999px";
                            target.style.top = "0";
                            target.id = targetId;
                            document.body.appendChild(target);
                        }
                        target.textContent = elem.textContent;
                    }
                    var currentFocus = document.activeElement;
                    target.focus();
                    target.setSelectionRange(0, target.value.length);
                    
                    var succeed;
                    try {
                        succeed = document.execCommand("copy");
                    } catch(e) {
                        succeed = false;
                    }
                    
                    if (currentFocus && typeof currentFocus.focus === "function") {
                        currentFocus.focus();
                    }
                    
                    if (isInput) {
                        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
                    } else {
                        target.textContent = "";
                    }
                    return succeed;
                }

                document.getElementById("copy_amounty").addEventListener("click", function() {
                    copyToClipboardAmount(document.getElementById("copyAmount"));
                });

                function copyToClipboardAmount(elem) 
                {
                    var targetId = "_hiddenCopyText_";
                    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
                    var origSelectionStart, origSelectionEnd;
                    if (isInput) {
                        target = elem;
                        origSelectionStart = elem.selectionStart;
                        origSelectionEnd = elem.selectionEnd;
                    } else {
                        target = document.getElementById(targetId);
                        if (!target) {
                            var target = document.createElement("textarea");
                            target.style.position = "absolute";
                            target.style.left = "-9999px";
                            target.style.top = "0";
                            target.id = targetId;
                            document.body.appendChild(target);
                        }
                        target.textContent = elem.textContent;
                    }
                    var currentFocus = document.activeElement;
                    target.focus();
                    target.setSelectionRange(0, target.value.length);
                    
                    var succeed;
                    try {
                        succeed = document.execCommand("copy");
                    } catch(e) {
                        succeed = false;
                    }
                    
                    if (currentFocus && typeof currentFocus.focus === "function") {
                        currentFocus.focus();
                    }
                    
                    if (isInput) {
                        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
                    } else {
                        target.textContent = "";
                    }
                    return succeed;
                }

                function PaymentInsert(){
                    var confirmations_num = document.getElementById("confirmations_num").value;
                    var tolerance = document.getElementById("tolerance").value;
                    var confirmation_url = document.getElementById("confirmation_url").value;
                        
                    var send_value_address = document.getElementById("send_value_address").value;
                    var send_mount = document.getElementById("send_mount").value;

                    $.ajax({
                       type: "POST",
                       url: "dnotes_ajax.php",
                       data: {
                        order_num : "<?php echo $order_num; ?>", 
                        amount : send_mount,
                        address : send_value_address,
                        tolerance : tolerance,
                        confirmations_num : confirmations_num,
                        invoice_num : "<?php echo $invoice_number; ?>"
                       },
                       success: function(data) {
                            window.opener.location.href = confirmation_url;
                            self.close();
                       }
                   });
                }
            </script>
    </div>
    </body>
</html>
