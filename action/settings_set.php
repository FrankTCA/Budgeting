<?php
require_once "../creds.php";
require_once "../common.php";
require_once "../../sso/common.php";
if (!isset($_GET["setting"]) || !isset($_GET["value"])) {
    die("noinfo");
}

validate_token("https://infotoast.org/budget/action/settings_set.php");
$setting_str = $_GET["setting"];
$setting = parse_setting($setting_str);

if ($setting == -1) {
    http_response_code(400);
    die("invalid setting");
}

$value_str = $_GET["value"];
$value = floatval($value_str);
$user_id = get_user_id();

$conn = mysqli_connect(get_database_host(), get_database_username(), get_database_password(), get_database_db());
if ($conn->connect_error) {
    die("dbconn");
}

$sql = $conn->prepare("SELECT * FROM settings WHERE user_id = ? AND setting_id = ?;");
$uid = $user_id;
$sid = $setting;
$sql->bind_param('ii', $uid, $sid);
$sql->execute();

$alreadyset = false;
$row_id = -1;

if ($result = $sql->get_result()) {
    while ($row = $result->fetch_assoc()) {
        $alreadyset = true;
        $row_id = $row['id'];
    }
}

if ($alreadyset) {
    $sql2 = $conn->prepare("UPDATE settings SET value = ? WHERE id = ?;");
    $val = $value;
    $rid = $row_id;
    $sql2->bind_param('fi', $val, $rid);
    $sql2->execute();
} else {
    $sql2 = $conn->prepare("INSERT INTO settings (user_id, setting_id, value) VALUES (?, ?, ?);");
    $uid2 = $user_id;
    $sid2 = $setting;
    $val = $value;
    $sql2->bind_param('iif', $uid2, $sid2, $val);
    $sql2->execute();
}
$conn->commit();
$conn->close();

echo "success";
