<?php
function check_date($str): bool {
    $pattern = '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/i';
    return preg_match($pattern, $str) == 1;
}
