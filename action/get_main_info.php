<?php
require_once "../common.php";
require_once "../creds.php";
require_once "../../sso/common.php";
require_once "settings_get.php";

validate_token("https://infotoast.org/budget/action/get_main_info.php");
$user_id = get_user_id();

$conn = mysqli_connect(get_database_host(), get_database_username(), get_database_password(), get_database_db());
if ($conn->connect_error) {
    http_response_code(500);
    die("dbconn");
}

$settings = array(
    "income" => get_setting($conn, $user_id, 0),
    "util" => get_setting($conn, $user_id, 1),
    "food" => get_setting($conn, $user_id, 2),
    "supply" => get_setting($conn, $user_id, 3),
    "travel" => get_setting($conn, $user_id, 4),
    "software" => get_setting($conn, $user_id, 5),
    "luxury" => get_setting($conn, $user_id, 6)
);

if (is_null($settings["income"])) {
    die("gotosettings");
}

$spent = array(
    "util" => calculate_spent($conn, $user_id, 1),
    "food" => calculate_spent($conn, $user_id, 2),
    "supply" => calculate_spent($conn, $user_id, 3),
    "travel" => calculate_spent($conn, $user_id, 4),
    "software" => calculate_spent($conn, $user_id, 5),
    "luxury" => calculate_spent($conn, $user_id, 6),
);

$spent["income"] = $spent["util"] + $spent["food"] + $spent["supply"] + $spent["travel"] + $spent["software"] + $spent["luxury"];

$ratios = array(
    "income" => $spent["income"] / $settings["income"],
    "util" => $spent["util"] / $settings["util"],
    "food" => $spent["food"] / $settings["food"],
    "supply" => $spent["supply"] / $settings["supply"],
    "travel" => $spent["travel"] / $settings["travel"],
    "software" => $spent["software"] / $settings["software"],
    "luxury" => $spent["luxury"] / $settings["luxury"]
);

$settings["save"] = $settings["income"] - ($settings["util"] + $settings["food"] + $settings["supply"] + $settings["travel"] + $settings["software"] + $settings["luxury"]);

echo "{\"ratio_complete\":" . $ratios["income"] . ", \"income\": " . $settings["income"] . ", \"settings\":{\"util\":" . $settings["util"] . ", \"food\":" . $settings["food"] . ", \"supply\":" . $settings["supply"] .
    ", \"travel\":" . $settings["travel"] . ", \"software\":" . $settings["software"] . ", \"luxury\":" . $settings["luxury"] . "}, " .
    "\"amount_spent\": {\"income\": " . $spent["income"] . ", \"util\": " . $spent["util"] . ", \"food\": " . $spent["food"] . ", \"supply\": " . $spent["supply"] . ", \"travel\": " . $spent["travel"] . ", \"software\": " . $spent["software"] . ", \"luxury\": " . $spent["luxury"] . "}, " .
    "\"ratio_spent\": {\"income\": " . $ratios["income"] . ", \"util\": " . $ratios["util"] . ", \"food\": " . $ratios["food"] . ", \"supply\": " . $ratios["supply"] . ", \"travel\": " . $ratios["travel"] . ", \"software\": " . $ratios["software"] . ", \"luxury\": " . $ratios["luxury"] . "}, " .
    "\"leftover_save\": " . $settings["save"] . ", \"username\": \"" . get_username() . "\"}";

