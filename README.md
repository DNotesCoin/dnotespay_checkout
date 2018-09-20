![Dnotes Pay](header.png)

DNotes Pay custom cart and checkout integration

# Installation

## Database
Import the dnotes.sql file into your site/store database from shell or with [phpMyAdmin](https://phpmyadmin.net)

## Upload Files
Upload the following files to your site/store directory:
* `button.php`
* `dnotes_ajax.php`
* `dnotes_cron.php`
* `dnotes_payment.php`
* `dnotespay.css`
* `header.png`
* `left.png`

## Integration
Integration is completely dependent on the specific site's setup, the following is a general guideline.

Open `button.php` and update the configuration settings at the top. 
* __$amount__ and __$order_num__ should be dynamic and get their values from your store for the current order.
* __$confirmation_url__ should point to your Success or Thank You store page. Or to a store page for any further processing before showing the user the Success/ThankYou page.

### Method 1
Include `button.php` into your checkout page's PHP code:
`
require_once("button.php");
`

### Method 2
Copy the coding - *including the configuration values* - and place in parts into your checkout page where needed. The button calls the Javascript function `PaymentpageShow()` when clicked to submit the form, creating the new window for DNotes payment. You can add additional functionality here as needed:
  * Submit a separate, main form to a hidden iFrame
  * Perform actions via AJAX (such as validating checkout data, submitting cart/order info, etc)
