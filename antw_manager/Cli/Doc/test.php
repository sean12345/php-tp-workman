<?php

function getClosest($search, $arr) {
   $closest = null;
   $keyNow = null;
   $keys = null;
   $min = min($arr);
   if ($search <= 0) return '';
   foreach ($arr as $key => $item) {
      if ($closest === null || abs($search - $closest) > abs($item - $search)) {
         $closest = $item;
         $keyNow = $key;
      }
   }
   unset($arr[$keyNow]);
   $searchNow = abs($closest - $search);
   if ($searchNow !== 0 && !empty($arr) && $searchNow >= $min) {
        $keys .= ',' . getClosest($searchNow, $arr);
   }
   // array_push($keys, $keyNow);
   $keys .= ',' . $keyNow;
   return trim($keys, ',');
}


$arr = array(
        '1001' => 100,
        '1002' => 200,
        '1007' => 200,
        '1003' => 300,
        // '1004' => 400,
        '1005' => 500,
);

$sr = 350;

echo "=================" . PHP_EOL;

$a = getClosest($sr, $arr);
echo $a;

echo PHP_EOL . "=================" . PHP_EOL;