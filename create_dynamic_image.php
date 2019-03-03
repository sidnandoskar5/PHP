<?php

/*
 * @param width         $wt
 * @param height        $ht
 * @param background    $bg
 * @param text_color    $txtclr
 * @param font_size     $size
 * @param text          $t
*/

if (isset($_GET['wt']) || !empty($_GET['wt'])){
    $font = 'font/montserrat.otf';

    $img = [];
    $img['background'] = (string) isset($_GET['bg']) ? $_GET['bg'] : "000";
    $img['color'] = (string) isset($_GET['txtclr']) ? $_GET['txtclr'] : "fff";
    $img['width'] = (int) isset($_GET['wt']) ? $_GET['wt'] : 300;
    $img['height'] = (int) isset($_GET['ht']) ? $_GET['ht'] : 300;
    $font_size = isset($_GET['size']) ? $_GET['size'] : 16;

    $font_size = doubleval($font_size);

    $background = explode(",",hex2rgb($img['background']));
    $textColorRgb = explode(",",hex2rgb($img['color']));
    $width = empty($img['width']) ? 100 : $img['width'];
    $height = empty($img['height']) ? 100 : $img['height'];

    $text = (string) isset($_GET['t']) ? urldecode($_GET['t']) : $width ." x ". $height;

    $image = @imagecreate($width, $height) or die("Cannot Initialize new GD image stream");

    $background_color = imagecolorallocate($image, $background[0], $background[1], $background[2]);

    $bounding_box_size = imagettfbbox($font_size, 0, $font, $text);
    $text_width = $bounding_box_size[2] - $bounding_box_size[0];
    $text_height = $bounding_box_size[7]-$bounding_box_size[1];

    $x = ceil(($width - $text_width) / 2);
    $y = ceil(($height - $text_height) / 2);

    $text_color = imagecolorallocate($image, $textColorRgb[0], $textColorRgb[1], $textColorRgb[2]);

    imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $text);

    header('Content-Type: image/png');

    imagepng($image);
    imagedestroy($image);
}else{
    echo "Opps! No Legendary Pokemon Available";
}

function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    switch(strlen($hex)){
        case 1:
            $hex = $hex.$hex;
        case 2:
            $r = hexdec($hex);
            $g = hexdec($hex);
            $b = hexdec($hex);
            break;
        case 3:
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            break;
        default:
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
            break;
    }

    $rgb = array($r, $g, $b);
    return implode(",", $rgb); 
}