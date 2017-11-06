<?php

$data = [];

$sources = [
    'php',
    'nodejs',
    'mock',
];

foreach ($sources as $source) {
    $file = "wait-time.$source.log";
    $sourceData = [];

    if (!file_exists($file)) {
        continue;
    }

    foreach (file($file) as $line) {
        $l = array_map('intval', explode('-', $line));
        $l []= $source;
        $sourceData []= $l;
    }

    usort($sourceData, function ($a, $b) {
        if ($a[0] === $b[0]) {
            return 0;
        }

        return $a[0] > $b[0] ? 1 : -1;
    });

    $t0 = $sourceData[0][0];

    $sourceData = array_map(function ($d) use ($t0) {
        return [$d[0] - $t0, $d[1] - $d[0]];
    }, $sourceData);

    for ($i = 0; $i < count($sourceData); $i++) {
        $sourceData[$i] []= $source;
    }

    foreach ($sourceData as $sd) {
        $data []= $sd;
    }
}


echo 'var data = ', json_encode($data), ';', PHP_EOL;
