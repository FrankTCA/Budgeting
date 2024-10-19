<?php
require_once "common.php";
require "../sso/common.php";
validate_token("https://infotoast.org/budget/category.php");

if (!isset($_GET['category'])) {
    http_response_code(302);
    header("Location: https://infotoast.org/budget/");
    die();
}

$category = parse_setting($_GET["category"]);
switch($category) {
    case 1:
        $catName = "Rent/Utilities";
        break;
    case 2:
        $catName = "Food";
        break;
    case 3:
        $catName = "Household Supply";
        break;
    case 4:
        $catName = "Travel";
        break;
    case 5:
        $catName = "Software";
        break;
    case 6:
        $catName = "Luxury";
        break;
    default:
        http_response_code(400);
        die("Invalid info sent as category.");
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Budget for <?php echo $catName; ?></title>
    <script type="text/javascript" src="resources/js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="resources/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/sso/resources/node_modules/js-cookie/dist/js.cookie.min.js"></script>
    <script type="text/javascript" src="/sso/resources/login-box.js"></script>
    <script type="text/javascript" src="../crypto/aes.js"></script>
    <script type="text/javascript" src="../crypto/key-runtime.js"></script>
    <script type="text/javascript" src="resources/js/category.js"></script>
    <link type="text/css" rel="stylesheet" href="resources/css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="/sso/resources/login-box.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/global.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/local.css"/>
</head>
<body>
    <div class="top">
        <div class="topleft">
            <h1><a href="/budget/">◀ Budget for <?php echo $catName; ?></a></h1>
        </div>
        <div class="topright">
                <div class="loginbutton"></div>
        </div>
    </div>
    <div class="theBody">
        <div class="iconBodyHeader" id="firstHeader">
            <h2>📊Usage:</h2>
        </div>
        <div class="iconSet">
            <div id="progressbar"></div>
        </div>
        <div class="iconBodyHeader">
            <h2>💳Create Payment:</h2>
        </div>
        <div class="iconSet">
            <h4>Name of Payment:</h4><br>
            <input type="text" id="paymentNameBox" class="loginTextBox" name="paymentName" placeholder="Milk"><br>
            <h5>Date of Payment:</h5><br>
            <input type="text" id="paymentDateBox" class="loginTextBox" name="paymentDate" value="<?php echo date("m/d/Y"); ?>"><br>
            <h5>Amount:</h5><br>
            <input type="text" id="paymentAmountBox" class="loginTextBox" name="paymentAmount" placeholder="5.00"><br>
            <input type="hidden" id="category" name="category" value="<?php echo $_GET['category']; ?>">
            <p class="badtextboxmsg"></p>
            <div class="continuebtn" id="continuebtn">
                <button class="continue" id="continue" onclick="onPaymentSubmit();">Submit</button>
            </div>
            <p><i>Names of payments are encrypted end-to-end. We cannot see the nature of your purchases.</i></p>
        </div>
        <div class="iconBodyHeader">
            <h2>💲This Month's Payment Log:</h2>
        </div>
        <p class="errorMsg" id="errorMsg"></p>
        <div class="iconSet">
            <div class="payments">
                <table id="paymentTable" cellpadding="10em" cellspacing="10em"></table>
            </div>
        </div>
    </div>
</body>
</html>