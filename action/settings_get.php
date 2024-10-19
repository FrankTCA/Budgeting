<?php
function get_setting($conn, $user_id, $setting_id) {
    $sql = $conn->prepare("SELECT * FROM settings WHERE user_id = ? AND setting_id = ?;");
    $sql->bind_param('ii', $user_id, $setting_id);
    $sql->execute();
    if ($result = $sql->get_result()) {
        while ($row = $result->fetch_assoc()) {
            return $row["value"];
        }
    }
    if ($setting_id == "googleChart") {
        return 1;
    } else {
        return null;
    }
}

function calculate_spent($conn, $user_id, $setting_id) {
    $month = date('m-Y');
    $sql = $conn->prepare("SELECT * FROM expenses WHERE user_id = ? AND category = ? AND expense_month LIKE ?;");
    $sql->bind_param('iis', $user_id, $setting_id, $month);
    $sql->execute();

    $amount_spent = 0.0;
    if ($result = $sql->get_result()) {
        while ($row = $result->fetch_assoc()) {
            $amount_spent += floatval($row["amount"]);
        }
    }
    return $amount_spent;
}
