<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css2?family=Manrope:wght@200;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        'css/site.css', // Custom CSS for glass-card and hero-gradient
    ];
    public $js = [
        'https://cdn.tailwindcss.com?plugins=forms,container-queries',
        'js/tailwind.config.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}