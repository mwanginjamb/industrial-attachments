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
        'js/menu-toggle.js',
        '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js',
        '//cdn.jsdelivr.net/npm/sweetalert2@11',
        '//cdnjs.cloudflare.com/ajax/libs/tinymce/7.9.1/tinymce.min.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}