<?php

declare(strict_types=1);

function imageSize($fileName){

    $fileName = $_FILES['image'];
    $percent = 0.5;
    // Content type
    header('Content-Type: image/jpeg');

    // Get new sizes
    list($width, $height, $type) = getimagesize($fileName);
    $newWidth = $width * $percent;
    $newHeight = $height * $percent;
    //$type = $list[2];
    echo $type;

    // Load
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    $source = imagecreatefromjpeg($fileName);

    // Resize
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Output
    imagejpeg($thumb,'new.jpeg');
}

return imageSize($fileName);