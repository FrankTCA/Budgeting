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
    <script type="text/javascript" src="../crypto/aes.js"></script>
    <script type="text/javascript" src="../crypto/key-runtime.js"></script>
    <script type="text/javascript" src="resources/js/category.js"></script>
    <link type="text/css" rel="stylesheet" href="resources/css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/global.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/local.css"/>
</head>
<body>
    <div class="top">
        <div class="topleft">
            <h1>Budget for <?php echo $catName; ?></h1>
        </div>
        <div class="topright">
            <a href="https://infotoast.org/sso/" class="divLink" id="loginButton">
                <div class="loginbutton">
                    <svg class="user" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 128 128" enable-background="new 0 0 128 128" xml:space="preserve" width="40px" height="40px"><g><path fill="#FFFFFF" fill-opacity="0" d="M30.6,111.5c5.8-29.9,18.8-49.2,33.2-49.2c14.2,0,27.1,18.9,33,48.2L30.6,111.5z"/><path d="M63.8,62.8c13.9,0,26.5,18.5,32.4,47.2l-65,0.9C37,81.7,49.7,62.8,63.8,62.8 M63.8,61.8C48.6,61.8,35.6,82.5,30,112l67.4-0.9C91.7,82.1,78.8,61.8,63.8,61.8L63.8,61.8z"/></g><line fill="none" stroke="#FFFFFF" stroke-width="0" stroke-linecap="round" stroke-linejoin="round" x1="103.5" y1="68.5" x2="82.4" y2="68.8"/><line fill="none" stroke="#FFFFFF" stroke-width="0" stroke-linecap="round" stroke-linejoin="round" x1="48.5" y1="69.3" x2="31.5" y2="69.5"/><g><path fill="#FFFFFF" fill-opacity="0" d="M64.5,59.5c-7.2,0-13-5.8-13-13v-7c0-7.2,5.8-13,13-13c7.2,0,13,5.8,13,13v7C77.5,53.7,71.7,59.5,64.5,59.5z"/><path d="M64.5,27C71.4,27,77,32.6,77,39.5v7C77,53.4,71.4,59,64.5,59C57.6,59,52,53.4,52,46.5v-7C52,32.6,57.6,27,64.5,27 M64.5,26L64.5,26C57,26,51,32,51,39.5v7C51,54,57,60,64.5,60h0C72,60,78,54,78,46.5v-7C78,32,72,26,64.5,26L64.5,26z"/></g></svg>
                    <span id="loginText" class="littleMsg">Hi, <?php echo get_username(); ?></span>
                </div>
            </a>
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