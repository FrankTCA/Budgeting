<?php
function check_date($str): bool {
    $pattern = '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/i';
    return preg_match($pattern, $str) == 1;
}

function parse_setting($name): int {
    $setting = -1;
    switch ($name) {
        case "income":
            $setting = 0;
            break;
        case "util":
            $setting = 1;
            break;
        case "food":
            $setting = 2;
            break;
        case "supply":
            $setting = 3;
            break;
        case "travel":
            $setting = 4;
            break;
        case "software":
            $setting = 5;
            break;
        case "luxury":
            $setting = 6;
            break;
    }
    return $setting;
}

function get_setting_name($setting_int): string {
    $setting_name = "";
    switch ($setting_int) {
        case 0:
            $setting_name = "income";
            break;
        case 1:
            $setting_name = "util";
            break;
        case 2:
            $setting_name = "food";
            break;
        case 3:
            $setting_name = "supply";
            break;
        case 4:
            $setting_name = "travel";
            break;
        case 5:
            $setting_name = "software";
            break;
        case 6:
            $setting_name = "luxury";
            break;
    }
    return $setting_name;
}
