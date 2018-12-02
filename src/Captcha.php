<?php

namespace JJYY\FontCaptcha;

use Imagick;
use ImagickDraw;
use ImagickPixel;

class Captcha
{
    public $letters = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';

    public $fonts = [
        [
            'name' => 'super_mario_256.ttf',
        ],
        [
            'name' => 'super_mario_bros.ttf',
        ],
        [
            'name' => 'actionj.ttf',
        ],
        [
            'name' => 'alpha_rope.ttf',
        ],
        [
            'name' => 'seriesorbit.ttf',
        ],
    ];

    public function generateCode($len = 5)
    {
        return substr(str_shuffle(str_repeat($this->letters, 3)), 0, $len);
    }

    public function generateImage($string, $fontSize = 20)
    {
        $image = new Imagick();
        $draw = new ImagickDraw();

        $width = strlen($string) * 25;
        $height = $fontSize + 10;
        $fontPath = dirname(__DIR__).DIRECTORY_SEPARATOR.'fonts'.DIRECTORY_SEPARATOR.$this->fonts[array_rand($this->fonts, 1)]['name'];
        $bgColor = 'rgba('.rand(100, 200).', '.rand(100, 200).', '.rand(100, 200).', 0.5)';
        $fillColor = '#696969';

        $image->newImage($width, $height, new ImagickPixel($bgColor), 'png');
        $draw->setFillColor($fillColor);
        $draw->setTextKerning(5);
        $draw->setFont($fontPath);
        $draw->setFontSize($fontSize);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $image->annotateImage($draw, 0, 0, rand(-10, 10), $string);
        header('Content-Type: image/png');
        echo $image;
        $image->clear();
        $image->destroy();
    }
}
