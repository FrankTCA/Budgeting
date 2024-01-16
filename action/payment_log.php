<?php
require_once "../common.php";
require_once "../creds.php";
require_once "settings_get.php";
require_once "../../sso/common.php";

if (!isset($_GET["category"])) {
    http_response_code(400);
    die("noinfo");
}

validate_token("https://infotoast.org/budget/action/payment_log.php");
$user_id = get_user_id();

$category = parse_setting($_GET["category"]);
if ($category == -1) {
    http_response_code(400);
    die("invalidsetting");
}

$conn = mysqli_connect(get_database_host(), get_database_username(), get_database_password(), get_database_db());
if ($conn->connect_error) {
    http_response_code(500);
    die("dbconn");
}

$total_amount = get_setting($conn, $user_id, $category);
$amount_spent = calculate_spent($conn, $user_id, $category);

echo "{\"total_amount\": " . $total_amount . ", \"already_spent\": " . $amount_spent . ", \"payments\": [";

$month = date('m-Y');
$sql = $conn->prepare("SELECT * FROM expenses WHERE user_id = ? AND category = ? AND expense_month LIKE ?;");
$uid = $user_id;
$catid = $category;
$sql->bind_param('iis', $uid, $catid, $month);
$sql->execute();
$rows = 0;
if ($result = $sql->get_result()) {
    while ($row = $result->fetch_assoc()) {
        if ($rows > 0) {
            echo ", ";
        }
        echo "{\"id\":" . $row["id"] . ", \"name\": \"" . $row["name"] . "\", \"amount\": " . $row["amount"] . ", \"expense_date\": \"" . $row["expense_date"] . "\", \"encrypted\":" . $row["encrypted"] . "}";
        $rows++;
    }
}

echo "], \"username\": \"" . get_username() . "\"}";
