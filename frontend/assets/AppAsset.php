<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap',
        // Main Font Families
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&display=swap',
        // Material Symbols
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        // Compiled Tailwind CSS with custom configuration
        'css/tailwind.css',
    ];
    public $js = [
        //'https://cdn.tailwindcss.com?plugins=forms,container-queries',
        //'js/tailwind.config.js'
        '//cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}