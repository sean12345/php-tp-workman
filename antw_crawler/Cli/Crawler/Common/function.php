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