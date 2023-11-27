<?php
require "../creds.php";
require_once "../common.php";
require "../../sso/common.php";

if (!(isset($_GET["category"]) && isset($_GET["name"]) && isset($_GET["date"]) && isset($_GET["amount"]))) {
    http_response_code(400);
    die("noinfo");
}

$category_str = $_GET["category"];
$category = parse_setting($category_str);
if ($category == -1) {
    http_response_code(400);
    die("invalid setting");
}
$name = $_GET["name"];
$date = $_GET["date"];
$amount = $_GET["amount"];

if (strlen($name) > 64) {
    http_response_code(400);
    die("Name must be max 64 characters.");
}

if (!check_date($date)) {
    http_response_code(400);
    die("Date must be written as MM/DD/YYYY");
}

validate_token("https://infotoast.org/budget/action/payment.php");
$user_id = get_user_id();

$conn = mysqli_connect(get_database_host(), get_database_username(), get_database_password(), get_database_db());
if ($conn->connect_error) {
    http_response_code(500);
    die("dbconn");
}
$month = date('m-Y');
$sql = $conn->prepare("INSERT INTO expenses (user_id, category, name, amount, expense_date, expense_month) VALUES (?, ?, ?, ?, ?, ?);");
$uid = $user_id;
$cat = $category;
$amt = $amount;
$expensename = $name;
$expensedate = $date;
$sql->bind_param('iisdss', $uid, $cat, $expensename, $amt, $expensedate, $month);
$sql->execute();

$conn->commit();
$conn->close();

echo "success";
