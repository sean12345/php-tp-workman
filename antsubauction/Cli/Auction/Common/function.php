<?php

/**
 * 生成手机验证码
 * @param type $length
 * @return type
 */
function generateCode($length = 6)
{
    return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}

function diffDate($date1, $date2)
{
    //array('-1' => '全部', '1' => '3年以下', '2' => '3到6年', '3' => '6到10年', '4' => '10年以上');
    $datetime1 = new \DateTime($date1);
    $datetime2 = new \DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    $year = $interval->format('%Y');
    if ($year < 3) {
        $diffY = 1;
    } else if ($year >= 3 && $year < 6) {
        $diffY = 2;
    } else if ($year >= 6 && $year < 10) {
        $diffY = 3;
    } else {
        $diffY = 4;
    }
    return $diffY;
}
