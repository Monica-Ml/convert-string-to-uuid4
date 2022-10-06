<?php
$clear_string = '15:A6:84:9C:08:73:0C:21:1A:79:F7:66:F5:2B:54:E9';

list($flg, $result) = convert_to_uuid_v4($clear_string);
if ($flg) {
    echo $result;
} else {
    echo 'error: '.$result;
}

function convert_to_uuid_v4($val)
{
    // remove -> :
    $val = str_replace(':', '', $val);
    // lower words
    $val = strtolower($val);
    // set uuid version 4
    $part_3 = substr_replace(substr($val, 12, 4), '4', 0, 1);
    // set uuid sign 0->8,1->9,2->a,3->b
    $part_4 = substr($val, 16, 4);
    $sign_detect = substr($part_4, 0, 1);
    switch ($sign_detect) {
        case '0':
            $sign = '8';
            break;
        case '1':
            $sign = '9';
            break;
        case '2':
            $sign = 'a';
            break;
        case '3':
            $sign = 'b';
            break;
        default:
            return array(false, "can't sign detected");
    }
    // replace sign
    $part_4=substr_replace($part_4, $sign, 0, 1);
    // include -> -
    $uuid_v4 = substr($val, 0, 8).'-'.substr($val, 8, 4).'-'.$part_3.'-'.$part_4.'-'.substr($val, 20, 31);
    // return data
    return array(true, $uuid_v4);
}