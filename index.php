<?php
require 'vendor/autoload.php';

use  App\Spride;

$spride = new Spride();
echo 'Staring.......' . PHP_EOL;
for ($i = 0; $i < 10; $i++) {
    $imageUrl = "https://avatars3.githubusercontent.com/u/$i";
    echo "$imageUrl" . PHP_EOL;
    $spride->downloadFromSrc($imageUrl);
}
echo "Download Complete!";
