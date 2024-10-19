<?php
require "../sso/common.php";
validate_token("https://infotoast.org/budget/settings.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Budget Settings</title>
    <script type="text/javascript" src="resources/js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="resources/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/sso/resources/node_modules/js-cookie/dist/js.cookie.min.js"></script>
    <script type="text/javascript" src="/sso/resources/login-box.js"
    <script type="text/javascript" src="resources/js/settingsPage.js"></script>
    <link type="text/css" rel="stylesheet" href="resources/css/jquery-ui.min.css"/>
    <link type="text/css" rel="stylesheet" href="/sso/resources/login-box.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/global.css"/>
    <link type="text/css" rel="stylesheet" href="resources/css/local.css"/>
</head>
<body>
    <div class="top">
        <div class="topleft">
            <h1>Budget Settings</h1>
        </div>
        <div class="topright">
                <div class="loginbutton"></div>
        </div>
    </div>
    <div class="theBody">
        <div class="iconBodyHeader" id="firstHeader">
            <h2>⚙️Choose your Settings:</h2>
        </div>
        <p class="errorMsg" id="errorMsg"></p>
        <div class="iconSet">
            <h4>Your monthly income:</h4><br>
            <input type="text" id="incomeBox" class="loginTextBox" name="income" placeholder="5000.00"><br>
            <h5>Rent/Utilities:</h5><br>
            <input type="text" id="utilBox" class="loginTextBox" name="util" placeholder="1500.00"><br>
            <h5>Food:</h5><br>
            <input type="text" id="foodBox" class="loginTextBox" name="util" placeholder="500.00"><br>
            <h5>Household Supply:</h5><br>
            <input type="text" id="supplyBox" class="loginTextBox" name="supply" placeholder="300.00"><br>
            <h5>Travel:</h5><br>
            <input type="text" id="travelBox" class="loginTextBox" name="travel" placeholder="700.00"><br>
            <h5>Software:</h5><br>
            <input type="text" id="softwareBox" class="loginTextBox" name="software" placeholder="200.00"><br>
            <h5>Luxury:</h5><br>
            <input type="text" id="luxuryBox" class="loginTextBox" name="luxury" placeholder="300.00"><br>
            <p><i>Extra money can be left for saving/investments.</i></p>
            <div class="continuebtnfloat" id="continuebtn">
                <button class="continue" id="continue" onclick="onSettingsSubmit();">Submit</button>
            </div>
        </div>
    </div>
</body>
</html>